<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {

    }

    public function store(CompanyRequest $request)
    {
        $company = Company::create(array_merge($request->all(), ['user_id' => auth()->id()]));
        return $this->show($company->id);
    }

    public function show($companyId)
    {
        $company = Company::where('id', $companyId)->first();
        return new CompanyResource($company);
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->all());
        return new CompanyResource($company);
    }
}
