<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cl_notary_services_price extends Model
{
    protected $fillable = ['service_id', 'price'];

    public function editPrice($fields)
    {
        $this->fill($fields);
        $this->save();
    }
}
