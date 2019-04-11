<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     protected $fillable = [
      'user_id','status_id','weight','total','service','date_reserve'
    ];
     public function customer()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

      public function status()
    {
        return $this->belongsTo('App\Status');
    }

}
