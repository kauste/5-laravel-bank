<?php

namespace App\Http\Controllers;

use App\Models\SaversClient;
// use App\Http\Requests\StoreSaversClientRequest;
// use App\Http\Requests\UpdateSaversClientRequest;
use Illuminate\Http\Request; /// !!!!!

class SaversClientController extends Controller
{
    public static function isValidPersonId($personId){
        if (strlen($personId) != 11){
            return false;
        }
        $year = $personId[1] . $personId[2]; 
        $month = $personId[3] . $personId[4];
        $day = $personId[5] . $personId[6];
        function dayRange($month ){
            if ($month == '02'){
                return range(1, 29);
            }
            else if($month == '04' || $month == '06' || $month == '09' || $month == '11') {
                return range(1, 30);
            } else {
                return range(1, 31);
            }
        }
        if (!in_array($personId[0], range(3, 4))
        || !in_array($month, range(1, 12))
        || !in_array($day, dayRange($month))){
            return false;
        }
        else {
            return true;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        $clients = match($request->by){
            'name' => match($request->sort){
                'asc'=> SaversClient::orderBy('name', 'asc')->get(),
                'desc'=> SaversClient::orderBy('name', 'desc')->get(),
            },
            'surname' => match($request->sort){
                'asc'=> SaversClient::orderBy('surname', 'asc')->get(),
                'desc'=> SaversClient::orderBy('surname', 'desc')->get(),
            },
            'money' => match($request->sort){
                'asc'=> SaversClient::orderBy('sum', 'asc')->get(),
                'desc'=> SaversClient::orderBy('sum', 'desc')->get(),
            },
            default => SaversClient::all(),
        };
        return view('list', ['title' => 'Clients', 'clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('post.create', ['title' => 'Create new client', 'iban' => (new SaversClient)->validIban()]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->name < 3)
        {
            $msg = 'ERROR! Name should be at least 3 symbols length.';
        }
        elseif($request->surname < 3)
        {
            $msg = 'ERROR! Surname should be at least 3 symbols length.';
        }
        elseif(!self::isValidPersonId($request->person_id)){ 
            $msg = 'ERROR! Not valid ID.';
        }
        else
        {
            $client = new SaversClient;
            $client->name = $request->name;
            $client->surname = $request->surname;
            $client->account_num = $request->account_num;
            $client->person_id = $request->person_id;
            $client->sum = 0;
            $client->save();
            $msg = substr($request->name, 0, 1). ' ' . $request->surname . ' is added to client list.';
        }
        
        return  redirect()-> route('showCreate')-> with('message', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaversClient  $saversClient
     * @return \Illuminate\Http\Response
     */
    public function show(SaversClient $saversClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaversClient  $saversClient
     * @return \Illuminate\Http\Response
     */
    public function edit(SaversClient $saversClient, $addOrWithdrow, Request $request) 
    {
        return view('edit', ['title' => $addOrWithdrow, 'client'=> $saversClient, 'addOrWithdrow' => $addOrWithdrow]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaversClient  $saversClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaversClient $saversClient)
    {
        if($request->addOrWithdrow === 'add'){
            if($request->add < 0)
            {
                $msg = 'ERROR! Negative amount cannot be added.';
            }
            else
            {
                $saversClient->sum += $request->add;
                $saversClient->save();
                $msg = "Money is added to client's balance.";
            }

        }
        if($request->addOrWithdrow === 'withdrow'){
            if($request->withdrow <= 0)
            {
                $msg = 'ERROR! Negative amount cannot be withdrawn.';
            }
            elseif($request->withdrow > $saversClient->sum)
            {
                $msg = 'ERROR! You are trying to withdrow more money than client has in balance.';
            }
            else
            {
                $saversClient->sum -= $request->withdrow;
                $saversClient->save();
                $msg = "Money is withdrawn from client's balance.";
            }
        }
        return redirect()-> route('clientEdit', [$saversClient, $request->addOrWithdrow])->with('message', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaversClient  $saversClient
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaversClient $saversClient)
    {
        if($saversClient->sum > 0) {
            $msg = "ERROR! There are some money in client's account, therefore it cannot be deleted.";
        }
        else{
            $saversClient->delete();
            $msg = 'Client was deleted from the list';
        }
        
        return redirect()-> route('list')->with('message', $msg);
    }
}
