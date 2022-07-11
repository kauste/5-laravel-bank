<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaversClient;

class CrudController extends Controller
{
    public function showClients()
    {
        $clients = SaversClient::all();
        return view('list', ['title' => 'Clients', 'clients' => $clients]);
    }
    public function showCreate(Request $request)
    {
            $msg = $request -> session()-> get('message', ''); // (2)
        // $msg = $request -> session()-> pull('message', ''); (1)
        return view('post.create', ['title' => 'Create new client', 'message' => $msg, 'iban' => (new SaversClient)->validIban()]); // taskas vietoj / t.y. folderiai
    }
    public function doCreate(Request $request) // kodel cia request, i skliaustelius,nors neparasem, kad reikia parametro?
    {
        // dump($request-> name); //kas tas dump
        if($request->name < 3)
        {
            $msg = 'ERROR! Name should be at least 3 symbols length.';
            // $request -> session()-> flash('message', 'ERROR! Name should be at least 3 symbols length.'); //(2)
            // $request -> session()-> put('message', 'ERROR! Name should be at least 3 symbols length.'); //(1)
        }
        elseif($request->surname < 3)
        {
            $msg = 'ERROR! Surname should be at least 3 symbols length.';
            // $request -> session()-> flash('message', 'ERROR! Surname should be at least 3 symbols length.'); //(2)
            // $request -> session()-> put('message', 'ERROR! Surname should be at least 3 symbols length.'); //(1)
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
            // $request -> session()-> flash('message', substr($request->name, 1, 2). ' ' . $request->surname . ' is added to client list.'); //(1)
            // $request -> session()-> put('message', substr($request->name, 1, 2). ' ' . $request->surname . ' is added to client list.'); /(2)
        }
        
        return  redirect()-> route('showCreate')-> with('message', $msg); // nedaeina, kodel cia -> , gi ne objektas, ar redirect funkcija objekta duoda????hmm\\\\ 
    }
}
