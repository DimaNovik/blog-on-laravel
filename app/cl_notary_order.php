<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cl_notary_order extends Model
{
    protected $fillable = ['region_id', 'office_id', 'user_id', 'action_id', 'sub_action_1_id','sub_action_2_id', 'service_id', 'code', 'count','price', 'created_at', 'pay_date', 'type', 'fio'];

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }
}
