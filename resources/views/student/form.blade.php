@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Maklumat Staf</div>

                     <div class="card-body">
                        @if($act=='edit')
                        <form method="POST" action="{{ route('student.edit') }}">
                        @else
                        <form method="POST" action="{{ route('student.create') }}">
                        @endif
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="@if(!empty($users->name)){{$users->name}} @endif" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('No KP') }}</label>

                            <div class="col-md-6">
                                <input id="no_kp" type="text" class="form-control @error('no_kp') is-invalid @enderror" name="no_kp" value="@if(!empty($users->no_kp)){{$users->no_kp}} @endif" required   autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						
						<div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('No. Staf') }}</label>

                            <div class="col-md-6">
                                <input id="staff_no" type="text" class="form-control @error('staff_no') is-invalid @enderror" name="staff_no" value="@if(!empty($users->staff_no)){{$users->staff_no}} @endif" required   autofocus>

                                @error('staff_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						
						
                        
                        


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input   type="hidden"  name="id" value="@if(!empty($users->id)) {{$users->id}} @endif">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
