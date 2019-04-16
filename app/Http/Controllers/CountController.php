<?php

namespace App\Http\Controllers;

use App\Post;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class CountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function countPost(){
        if(\Gate::allows('laundry')){
            return Post::count();
        }
        
    }
    public function countCustomer(){
        if(\Gate::allows('laundry')){
            return User::where('type','Customer')->count();
        }
    }
    public function countTransaction(){
        if(\Gate::allows('laundry')){
            return Transaction::count();
        }
    }
}
