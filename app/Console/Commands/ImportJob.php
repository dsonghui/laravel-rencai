<?php

namespace App\Console\Commands;

use App\Models\QianLiAccount;
use App\Models\QianLiCompany;
use App\Models\QianLiJob;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ImportJob extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'ImportJob';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Import Job';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        // TODO 
        set_time_limit(0);
        $id = Cache::get('last_company_id', 0);
        $this->info('开始导入企业=> 企业最小ID为:' . $id);
        $companys = QianLiCompany::where('c_info_lmt', '>', '2017-00-01 00:00:00')
            ->where('c_approval', 1)
            ->where('company_info_id', '>', $id)
            ->orderBy('company_info_id', 'asc')
            ->limit(100)
            ->get();
        $companys->each(function ($company) {
            $this->importCompany($company);
            Cache::put('last_company_id', $company->company_info_id, 100000);
        });
        $this->info('导入结束');
    }

    public function importCompany($company)
    {
        $companyArr = $company->toArray();

        $account = QianLiAccount::where('account_id', $companyArr['a_id'])
            ->first();

        $jobs = QianLiJob::where('a_id', $companyArr['a_id'])
            ->where('j_approval', 1)
            ->where('j_lmt_date', '>', '2017-00-01 00:00:00')
            ->get();


        $this->info('开始导入企业=> 企业名称:' . $company->c_name . ' 职位数量:' . $jobs->count());

        $jobs->each(function ($job) use ($companyArr, $account) {
            $postCompany = $this->tranDataToCompany($companyArr, $job->toArray(), $account->toArray());
            $this->postCompany($postCompany);
        });
    }

    public function tranDataToCompany($company, $job, $account)
    {
        $salary = $this->getCompanySalary($job['j_salary']);
        $company = [
            'job_name'    => $job['j_name'],
            'com_name'    => $company['c_name'],
            'email'       => $company['c_email'],
            'moblie'      => $company['c_mobile'],
            'address'     => $company['c_addr'],
            'content'     => '<p>' . $company['c_dec'] . '</p>',
            'linkphone'   => '',
            'linkman'     => $company['c_linkman'],
            'linkjob'     => '',
            'money'       => $company['c_rc'] ?? '',
            'zip'         => '',
            'com_sdate'   => '',
            'linkqq'      => '',
            'website'     => $company['c_website'],
            'hy'          => $company['c_industry'], //行业
            'job_hy'      => '', // 职位行业
            'pr'          => $this->getCompanyType($company['c_type']),
            'mun'         => $this->getCompanySize($company['c_size']), // 行业规模
            'city'        => $company['c_area'],
            'job_city'    => $job['j_area'],
            'description' => $job['j_dec'],
            'job_cate'    => $job['j_position'],
            'minsalary'   => $salary[0],
            'maxsalary'   => $salary[1],
            'exp'         => $this->getCompanyWorkYear($job['j_q_w_e']),  // 需要转换 工作经验
            'report'      => '',
            'age'         => $job['j_q_age'],
            'type'        => '',
            'sex'         => $job['j_q_sex'] === 1 ? '男' : ($job['j_q_sex'] === 2 ? '女' : '不限'),
            'edu'         => $this->getCompanyEducation($job['j_q_education']),
            'marriage'    => '',
            'number'      => $job['j_person_no'],

            'sdate' => $job['j_lmt_date'], //开始招聘时间
            'edate' => $job['j_end_date'], //截止时间


            'j_linkman' => $job['j_linkman'],
            'j_phone'   => $job['j_phone'],
            'j_mobile'  => $job['j_mobile'],
            'j_email'   => $job['j_email'],

            'account_name'    => $account['account_name'],
            'account_email'   => $account['email'],
            'account_pwd_md5' => $account['psw'],
        ];

        return $company;

    }

    private function getCompanySalary($type)
    {
        $job_j_salary = array(
            3  => "1500-1999",
            4  => "2000-2999",
            5  => "3000-4499",
            6  => "4500-5999",
            7  => "6000-7999",
            8  => "8000-9999",
            9  => "10000-14999",
            10 => "15000-19999",
            11 => "20000-29999",
            12 => "30000-49999",
        );
        return isset($job_j_salary[$type]) ? explode('-', $job_j_salary[$type]) : array('面议', '');
    }

    private function getCompanyType($type)
    {
        $company_c_type = array(
            1 => "国有企业",
            2 => "外资企业",
            3 => "合资企业",
            4 => "私营企业",
            5 => "民营企业",
            6 => "其他性质",
        );
        return isset($company_c_type[$type]) ? $company_c_type[$type] : '民营企业';
    }

    private function getCompanySize($type)
    {
        $company_c_size = array(
            1 => "50人以下",
            2 => "50-150人",
            3 => "150-500人",
            4 => "500人以上",
        );
        return isset($company_c_size[$type]) ? $company_c_size[$type] : '50人以下';
    }

    private function getCompanyWorkYear($type)
    {
        $job_work_year = array(
            0 => "不限",
            1 => "在读学生",
            2 => "应届毕业生",
            3 => "一年以上",
            4 => "二年以上",
            5 => "三年以上",
            6 => "五年以上",
            7 => "八年以上",
            8 => "十年以上",
        );
        return isset($job_work_year[$type]) ? $job_work_year[$type] : '不限';
    }

    private function getCompanyEducation($type)
    {
        //学历
        $job_j_education = array(
            0 => "不限",
            1 => "初中以上",
            2 => "高中以上",
            3 => "中专以上",
            4 => "大专以上",
            5 => "本科以上",
            6 => "硕士以上",
            7 => "博士以上",
        );
        return isset($job_j_education[$type]) ? $job_j_education[$type] : '不限';
    }

    public function postCompany($postCompany)
    {

        // var_dump($postCompany);

        $client = new Client();

        $url = 'http://www.0758rc.net/api/locoy/index.php?m=job&c=add&key=123qwe123';

        $option = [
            'http_errors' => false,
            'timeout'     => 10,
            'form_params' => $postCompany
        ];

        $response = $client->post($url, $option);
        $result = $response->getBody()->getContents();
        $this->info('导入企业职位=> 职位名称:' . $postCompany['job_name'] . ' 导入结果: ' . $result);
    }
}
