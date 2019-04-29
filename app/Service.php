<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $fillable = [
        'servicetype','price'
    ];

    public function transaction(){
        return $this->belongsTo('App\Transaction');
    }
}
