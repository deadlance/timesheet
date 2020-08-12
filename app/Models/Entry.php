<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    public function timesheet()
    {
        return $this->belongsToMany('App\Models\Timesheet');
    }
}
