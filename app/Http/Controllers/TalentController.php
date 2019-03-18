<?php

namespace App\Http\Controllers;

use App\Http\Requests\TalentRequest;
use App\Http\Resources\TalentResource;
use App\Talent;
use Illuminate\Http\Request;

class TalentController extends Controller
{
    public function index()
    {

    }

    public function store(TalentRequest $request)
    {
        $company = Talent::create(array_merge($request->all(), ['user_id' => auth()->id()]));
        return $this->show($company->id);
    }

    public function show($companyId)
    {
        $company = Talent::where('id', $companyId)->first();
        return new TalentResource($company);
    }

    public function update(TalentRequest $request, Talent $talent)
    {
        $talent->update($request->all());

        return new TalentResource($talent);
    }
}
