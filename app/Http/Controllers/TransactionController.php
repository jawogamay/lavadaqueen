<?php

namespace App\Http\Controllers;

use App\Events\StatusChanged;
use App\Notifications\TransactionChanged;
use App\Transaction;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nexmo;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
         if (\Gate::allows('laundry')) 
         {
            
            return Transaction::with('customer','status','service')->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function editStatus(Request $request, $id){
        $status = Transaction::findOrFail($id);
        $status->update([
            'status_id' => $request['status']
        ]);
     /*   $transaction = Transaction::find(4);
        User::find($transaction->user->id)->notify(new TransactionChanged());*/
       
        $phone = json_decode($status->customer->phone,true);
        
        $st = $status->status_id;
        

        if($st == 2)
        {
            $text = Nexmo::message()->send([
            'to'   => $phone,
            'from' => '639472195796',
            'text' => 'You have been approved'
         ]); 
        }
        else if($st == 3){
               $text = Nexmo::message()->send([
            'to'   => $phone,
            'from' => '639472195796',
            'text' => 'Current Status: Order Placed'
         ]); 
        }
        else if ($st == 4){
            $text = Nexmo::message()->send([
            'to'   => $phone,
            'from' => '639472195796',
            'text' => 'Current Status: Washing'
         ]); 
        }
        else if($st==5){
                $text = Nexmo::message()->send([
            'to'   => $phone,
            'from' => '639472195796',
            'text' => 'Current Status: Drying'
         ]); 
        }
        else if($st == 6){
                $text = Nexmo::message()->send([
            'to'   => $phone,
            'from' => '639472195796',
            'text' => 'Current Status: Quality Check'
         ]); 
        }
        else if($st ==7){
                $text = Nexmo::message()->send([
            'to'   => $phone,
            'from' => '639472195796',
            'text' => 'Your laundry clothes is out for delivery'
         ]); 
        }
        return $phone;
      
        
     /*   $st = $status->status_id;
        $phone = $status->customer->phone;
        if($st === 4){
             Nexmo::message()->send([
             'to'   => $phone,
            'from' => '639472195796',
            'text' => $name.'add a reservation'
            ]); 
        }*/
      

    }
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'service' => 'required',
            'date_reserve' => 'date|date_format:Y-m-d|after:tomorrow'
        ]);
        $user = Auth::user()->id;
        return Transaction::create([
            'service_id' => (int)$request['service'],
            'date_reserve' => $request['date'],
            'user_id' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }
    public function getCustomerTransaction(){
        if (\Gate::allows('customer')){
            $id = Auth::user()->id;
            return Transaction::where('user_id',$id)->latest()->with('status','service')->get();
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $this->validate($request,[
                'weight' => 'required|numeric',
                'total' => 'required'
        ]);
         $transaction->update([
            'weight' => $request['weight'],
            'total' => $request['total']

         ]);
         return $transaction;

        /* $transaction->update([*/
           /* 'user_id' => $request['user_id'],
            'service' => $request['service'],
            'weight' => $request['weight'],
            'total' => $request['total'],
            'status_id' => $request['status'] */
        /* ]);
         return ['message' => 'Updated the user info'];*/

       /* $service = $request['service'];
        $id = $request['id'];
        $total = (int)$request['total'];
        $status = $request['status'];
        $weight =(int) $request['weight'];
         $query = DB::table('transactions')
                 ->where('id',$id)
                   ->update(        
                        ['total' => $total],
                        ['status_id' => $status],
                        ['weight' => $weight]
                   );
                   
        return $query;*/
        /*return Transaction::where('id',$id)->update([
             'user_id' => $request['user_id'],
            'service' => $request['service'],
            'weight' => $request['weight'],
            'total' => $request['total'],
            'status_id' => $request['status'] 
        ]);*/

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('laundry');
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return ['message' => 'Transaction deleted'];

    }
}
