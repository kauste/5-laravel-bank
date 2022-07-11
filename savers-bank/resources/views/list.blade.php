@extends('main')
@section('content')

<header>
    <h2>Our clients</h2>
</header>

<main>
    <div class="dropdown-sort">
    <div class="sort-by">Sort by</div>
    <div class="dropdown-sort-content">
        <a class="sort-property" href="{{route('list', ['by'=> 'name', 'sort' => 'asc'])}}">Name A-Z</a>
        <a class="sort-property" href="{{route('list', ['by'=> 'name', 'sort' => 'desc'])}}">Name Z-A</a>
        <a class="sort-property" href="{{route('list', ['by'=> 'surname', 'sort' => 'asc'])}}">Surname A-Z</a>
        <a class="sort-property" href="{{route('list', ['by'=> 'surname', 'sort' => 'desc'])}}">Surname Z-A</a>
        <a class="sort-property" href="{{route('list', ['by'=> 'money', 'sort' => 'asc'])}}">Balance, smallest first</a>
        <a class="sort-property" href="{{route('list', ['by'=> 'money', 'sort' => 'desc'])}}">Balance, biggest first</a>
    </div>
    </div>
    <div class="list-labels">
        <div class="label">Name</div>
        <div class="label">Surname</div>
        <div class="label">ID</div>
        <div class="label">Account Number</div>
        <div class="label">Balance</div>
    </div>
    @forelse($clients as $client)
    <div class="list-of-clients" method="POST" action="">
        <div class="client-data">{{$client->name}}</div>
        <div class="client-data">{{$client->surname}}</div>
        <div class="client-data">{{$client->person_id}}</div>
        <div class="client-data">{{$client->account_num}}</div>
        <div class="client-data">{{$client->sum}} eur.</div>
        <a class="list-a" href="{{route('clientEdit', $client). '/add'}}">Add</a>
        <a class="list-a" href="{{route('clientEdit', $client). '/withdrow'}}">Withdrow</a>
        <form class="list-btn-fom" method="post" action="{{route('doDelete', $client)}}">
            @csrf
            @method('delete')
            <button class="list-btn" type="submit">Delete</button>
        </form>
    </div>
    @empty
    <div>There is no clients added yet.</div>
    @endforelse
</main>
@endsection
