<?php

namespace App\Http\Controllers;

use App\Models\SaversClient;
// use App\Http\Requests\StoreSaversClientRequest;
// use App\Http\Requests\UpdateSaversClientRequest;
use Illuminate\Http\Request; /// !!!!!

class SaversClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) //??????
    {
        if($request != null)
        {
            $msg = $request -> session()-> get('message' ?? '');
        }
        $clients = SaversClient::all();
        return view('list', ['title' => 'Clients', 'clients' => $clients, 'message' => $msg]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $msg = $request -> session()-> get('message', ''); 
        return view('post.create', ['title' => 'Create new client', 'message' => $msg, 'iban' => (new SaversClient)->validIban()]); 
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
        elseif(!SaversClient::isValidPersonId($request->person_id)){ // ar gerai???
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
    public function edit(SaversClient $saversClient, $addOrWithdrow) // ????????????
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
            if($request->withdrow < 0)
            {
                $msg = 'ERROR! Negative amount cannot be withdrawn.';
            }
            elseif($request->withdrow < $saversClient->sum)
            {
                $msg = 'ERROR! You are trying to withdrow more money than client has in balance.';
            }
            else
            {
                $saversClient->sum += $request->withdrow;
                $saversClient->save();
                $msg = "Money is withdrawn from client's balance.";
            }
        }
        // $url = route('clientEdit', $saversClient) . '/' . $request->addOrWithdrow;
        return redirect()-> route('list')->with('message', $msg);
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
