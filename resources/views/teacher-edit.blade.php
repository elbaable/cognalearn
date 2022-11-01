@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header fs-1 fw-bold">{{ __('Edit Teacher') }}</div>
                @if(Session::has('success'))
                <div class="alert alert-success m-3">
                    {{ Session::get('success') }}
                    @php
                        Session::forget('success');
                    @endphp
                </div>
                @endif
                <div class="card-body">
                    <form method="POST" class="py-3" action="{{ url('update-teacher') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $teacher->id }}" />
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="firstName" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ $teacher->firstName }}" required autocomplete="firstName" autofocus>

                                        @error('firstName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="lastName" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ $teacher->lastName }}" required autocomplete="lastName" autofocus>

                                        @error('lastName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-7">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $teacher->email }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $teacher->phone }}" required autocomplete="phone" autofocus>

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-3">
                            <button type="submit" class="btn btn-primary">{{ __('Submit Changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection