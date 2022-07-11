@extends('main')
@section('content')

    <header>
        <h2>Create new client account</h2>
    </header>
    <main>
        <form class="create-form" method="POST" action="{{route('doCreate')}}">
            <div class="create-labels">
                <label class="create-label"id="name">Name</label>
                <label class="create-label"id="surname">Surname</label>
                <label class="create-label"id="person_id">ID</label>
                <label class="create-label"id="account_num">Account Number</label>
            </div>
            <div class="create-inputs">
                <input class="create-input" for="name" name="name" required />
                <input class="create-input" for="surname" name="surname" required />
                <input class="create-input" for="person_id" name="person_id" required />
                <input class="create-input" for="account_num" name="account_num" value="{{$iban}}" readonly />
                @csrf
                <button>Create</button>
            </div>
        </form>
    </main>
@endsection