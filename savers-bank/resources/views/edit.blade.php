@extends('main')
@section('content')

    <header>
        <h2>{{$addOrWithdrow}}</h2>
    </header>
    <main>
    <div class="list-labels">
        <div class="label">Name</div>
        <div class="label">Surname</div>
        <div class="label">ID</div>
        <div class="label">Account Number</div>
        <div class="label">Balance</div>
        <div class="label">{{$addOrWithdrow}} eur.</div>
    </div>
    <
    <form class="list-of-clients" method="POST" action="{{route('doEdit', [$client, $addOrWithdrow])}}">
        <div class="client-data">{{$client->name}}</div>
        <div class="client-data">{{$client->surname}}</div>
        <div class="client-data">{{$client->person_id}}</div>
        <div class="client-data">{{$client->account_num}}</div>
        <div class="client-data">{{$client->sum}} eur.</div>
        <input class="edit-input" name="{{$addOrWithdrow}}">
        @csrf
        @method('put')
        <button class="edit-btn"type="submit">{{$addOrWithdrow}}</button>      
    </form>
    </main>
@endsection