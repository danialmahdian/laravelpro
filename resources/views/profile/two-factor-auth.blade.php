@extends('profile.layouts')

@section('main')
    <h4>Two Factor Auth : </h4>
    <hr>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="#" method="POST">
        @csrf

        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="" class="form-control">
                @foreach(config('twofactor.types') as $key => $name)
                    ]
                    <option value="{{ $key }}" {{ old('type') === $key || auth()->user()->hasTwoFactor($key) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="please add your phone number"
                   value="{{ old('phone') ?? auth()->user()->phone_number }}">
        </div>

        <div class="form-group">
            <button class="btn btn-primary mt-3">
                update
            </button>
        </div>
    </form>
@endsection