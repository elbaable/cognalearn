@extends('layouts.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header fs-1 fw-bold">{{ $course->name }} ({{ $course->courseCode }})</div>
                @if(Session::has('success'))
                    <div class="alert alert-success m-3">
                        {{ Session::get('success') }}
                        @php
                            Session::forget('success');
                        @endphp
                    </div>
                @endif
                <div class="card-body">
                    <p class="fs-5">{{ $course->description }}</p>
                    <h3 class="fw-bold">{{ __('Teachers in this course') }} ({{ count($teacherData) }})</h3>
                    <form method="POST" action="{{ url('add-teachers') }}">
                        @csrf
                        <input type="hidden" value="{{ $course->id }}" name="id" />
                        <div class="row align-items-center justify-content-between mb-3">
                            <label for="teachers" class="col-md-2 col-form-label text-md-end fw-bold">{{ __('Select Teachers') }}</label>

                            <div class="col-md-8">
                                <select class="select2 form-control @error('teachers') is-invalid @enderror" name="teachers[]" required multiple="multiple">
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->firstName.' '.$teacher->lastName }}</option>
                                    @endforeach
                                </select>

                                @error('teachers')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2 py-2">
                                <button type="submit" class="btn btn-primary">{{ __('Add Teachers') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        @if(count($teacherData) > 0)
                        @foreach($teacherData as $member)
                        <div class="col-md-4 mb-2">
                            <div class="border rounded p-3">
                                <h4><a href="{{ url('teacher/'.$member->id) }}">{{ $member->firstName }} {{ $member->lastName }}</a></h2>
                                <p class="m-0">{{ __('Email') }}: {{ $member->email }}</p>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div>
                            <h3 class="text-center fw-bold">{{ __('No teachers yet') }}</h3>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
       
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2').select2({
                placeholder: "Select Teachers",
                allowClear: true
            });
        });
    </script>
@endsection