<?php

namespace App\Repositories;

use App\Http\Resources\Answer;
use App\Models\Property;

class PropertyRepository extends Repository
{
    public function model()
    {
        return \App\Models\Property::class;
    }

}
