@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Active Phone Number
                    </div>

                    <div class="card-body">
                        <form action="{{ route('profile.2fa.phone') }}" method="POST">
                            @csrf

                            <div class="div form-group">
                                <label for="token" class="col-form-label">Token</label>
                                <input type="text" class="form-control @error('token') is-invalid @enderror" name="token" placeholder="enter your token">
                                @error('token')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="div form-group">
                                <button class="btn btn-primary mt-3">Validate token</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
