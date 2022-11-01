@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header fs-1 fw-bold">{{ __('Edit Course') }}</div>
                @if(Session::has('success'))
                <div class="alert alert-success m-3">
                    {{ Session::get('success') }}
                    @php
                        Session::forget('success');
                    @endphp
                </div>
                @endif
                <div class="card-body">
                    <form method="POST" class="py-3" action="{{ url('update-course') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $course->id }}" />
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Course Name') }}</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $course->name }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="courseCode" class="col-md-4 col-form-label text-md-end">{{ __('Course Code') }}</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control @error('courseCode') is-invalid @enderror" name="courseCode" value="{{ $course->courseCode }}" required autocomplete="courseCode" autofocus>

                                        @error('courseCode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Course description') }}</label>

                                    <div class="col-md-7">
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus>{{ $course->description }}</textarea>

                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="startDate" class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control date @error('startDate') is-invalid @enderror" name="startDate" value="{{ $course->startDate }}" required autocomplete="startDate" autofocus>

                                        @error('startDate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="endDate" class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>

                                    <div class="col-md-7">
                                        <input type="text" class="form-control date @error('endDate') is-invalid @enderror" name="endDate" value="{{ $course->endDate }}" required autocomplete="endDate" autofocus>

                                        @error('endDate')
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