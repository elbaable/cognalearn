@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h1 class="fs-1 fw-bold m-0">{{ __('Teachers') }}</h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">{{ __('Add a Teacher') }}</button>
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
                        <form method="POST" action="{{ url('teachers') }}">
                            @csrf
                            <div class="d-md-flex">
                                <input type="text" class="form-control me-2 mb-2" name="firstName" placeholder="Search teachers by first name" aria-label="firstName" aria-describedby="basic-addon1" @if($firstName) value="{{ $firstName }}" @endif>
                                <input type="text" class="form-control me-2 mb-2" name="lastName" placeholder="Search teachers by last name" aria-label="lastName" aria-describedby="basic-addon2" @if($lastName) value="{{ $lastName }}" @endif>
                                <input type="text" class="form-control me-2 mb-2" name="email" placeholder="Search teachers by email" aria-label="email" aria-describedby="basic-addon3" @if($email) value="{{ $email }}" @endif>
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        @if(count($teachers) > 0)
                        @foreach($teachers as $teacher)
                        <div class="col-md-4 mb-2">
                            <div class="border rounded p-3">
                                <h4><a href="{{ url('teacher/'.$teacher->id) }}">{{ $teacher->firstName }} {{ $teacher->lastName }}</a></h2>
                                <p class="m-0">{{ __('Email') }}: {{ $teacher->email }}</p>
                                <div class="mt-2">
                                    <a href="{{url('edit-teacher/'.$teacher->id)}}" class="btn btn-primary">Edit</a>
                                    <button type="button" class="btn btn-primary" data-href="{{url('delete-teacher/'.$teacher->id)}}" data-toggle="modal" data-target="#deleteModal">Delete</button>  
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="py-3">
                            {!! $teachers->links() !!}
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
        <form method="POST" action="{{ url('add-teacher') }}">
            @csrf
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="firstName" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                    <div class="col-md-7">
                        <input type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" required autocomplete="firstName" autofocus>

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
                        <input type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required autocomplete="lastName" autofocus>

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
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Add Teacher') }}</button>
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
                Are you sure to remove this teacher?
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