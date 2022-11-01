@extends('layouts.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h1 class="fs-1 fw-bold">{{ $teacher->firstName }} {{ $teacher->lastName }}</h1>
                    <h4 class="m-0">{{ $teacher->email }}</h4>
                </div>
                <div class="card-body">
                    <h3 class="fw-bold">{{ __('Courses for this teacher') }} ({{ count($courseData) }})</h3>
                    <form method="POST" action="{{ url('add-courses') }}">
                        @csrf
                        <input type="hidden" value="{{ $teacher->id }}" name="id" />
                        <div class="row align-items-center justify-content-between mb-3">
                            <label for="teachers" class="col-md-2 col-form-label text-md-end fw-bold">{{ __('Select Courses') }}</label>

                            <div class="col-md-8">
                                <select class="select2 form-control @error('courses') is-invalid @enderror" name="courses[]" required multiple="multiple">
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name.'('.$course->courseCode.')' }}</option>
                                    @endforeach
                                </select>

                                @error('courses')
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
                        @if(count($courseData) > 0)
                        @foreach($courseData as $course)
                        <div class="mb-2">
                            <div class="border p-3">
                                <h2><a href="{{ url('course/'.$course->id) }}">{{ $course->name }}</a></h2>
                                <p class="my-1 fs-5 fw-bold">{{ __('Code') }} : {{ $course->courseCode }}</p>
                                <p class="m-0">{{ $course->description }}</p>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div>
                            <h3 class="text-center fw-bold">{{ __('No courses yet') }}</h3>
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
                placeholder: "Select Courses",
                allowClear: true
            });
        });
    </script>
@endsection