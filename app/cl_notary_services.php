<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cl_notary_services extends Model
{
    protected $fillable = ['parent_id', 'subgroup_id', 'name', 'name_mik', 'name_kher', 'code'];

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }
}
