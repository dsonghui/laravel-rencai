<?php

namespace App\Http\Resources;

use App\User;

class CompanyResource extends Resource
{
    public static function collection($resource)
    {
        //$resource->loadMissing('company');
        //var_dump('collection');
        return parent::collection($resource);
    }

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
