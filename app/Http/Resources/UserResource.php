<?php

namespace App\Http\Resources;

use App\User;

class UserResource extends Resource
{
    public static function collection($resource)
    {
        $resource->loadMissing('company');
        var_dump('collection');
        return parent::collection($resource);
    }

    public function toArray($request)
    {
        if (\auth()->id() !== $this->resource->id) {
            $this->resource->makeHidden(User::SENSITIVE_FIELDS);
        }
         if ($this->resource->is_company) {
            $this->resource->loadMissing('company');
        }else{
             $this->resource->loadMissing('talent');
         }

        return parent::toArray($request);
    }
}
