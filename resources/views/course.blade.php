@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h1 class="fs-1 fw-bold m-0">{{ __('Courses') }}</h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">{{ __('Add a Course') }}</button>
                </div>

                <div class="card-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                        @php
                            Session::forget('success');
                        @endphp
                    </div>
                    @endif
                    <div class="row py-3">
                        <form method="POST" action="{{ url('/') }}">
                            @csrf
                            <div class="d-md-flex">
                                <input type="text" class="form-control me-2 mb-2" name="name" placeholder="Search courses by name" aria-label="keyword" aria-describedby="basic-addon1" @if($name) value="{{ $name }}" @endif>
                                <input type="text" class="form-control me-2 mb-2" name="code" placeholder="Search courses by code" aria-label="keyword" aria-describedby="basic-addon2" @if($code) value="{{ $code }}" @endif>
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        @if(count($courses) > 0)
                        @foreach($courses as $course)
                        <div class="mb-2">
                            <div class="border p-3">
                                <h2><a href="{{ url('course/'.$course->id) }}">{{ $course->name }}</a></h2>
                                <p class="my-1 fs-5 fw-bold">{{ __('Code') }} : {{ $course->courseCode }}</p>
                                <p class="m-0">{{ $course->description }}</p>
                                <div class="mt-2">
                                    <a href="{{url('edit-course/'.$course->id)}}" class="btn btn-primary">Edit</a>
                                    <button type="button" class="btn btn-primary" data-href="{{url('delete-course/'.$course->id)}}" data-toggle="modal" data-target="#deleteModal">Delete</button>  
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="py-3">
                            {!! $courses->links() !!}
                        </div>
                        @else
                        <div>
                            <h3 class="text-center fw-bold">{{ __('No results found') }}</h3>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">{{ __('Add a new Modal') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" action="{{ url('add-course') }}">
            @csrf
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Course Name') }}</label>

                    <div class="col-md-7">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                        <input type="text" class="form-control @error('courseCode') is-invalid @enderror" name="courseCode" value="{{ old('courseCode') }}" required autocomplete="courseCode" autofocus>

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
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus>{{ old('description') }}</textarea>

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
                        <input type="text" class="form-control date @error('startDate') is-invalid @enderror" name="startDate" value="{{ old('startDate') }}" required autocomplete="startDate" autofocus>

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
                        <input type="text" class="form-control date @error('endDate') is-invalid @enderror" name="endDate" value="{{ old('endDate') }}" required autocomplete="endDate" autofocus>

                        @error('endDate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Add Course') }}</button>
            </div>
        </form>
    </div>
  </div>
</div>

<!--Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold m-0">Confirmation</h2>
            </div>
            <div class="modal-body fs-5">
                Are you sure to remove this course?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-confirm">Delete</a>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
<script type="text/javascript">
    $('#addModal').modal('toggle');
</script>
@endif
<script type="text/javascript">
    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('.btn-confirm').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
@endsection