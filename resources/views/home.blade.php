@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">




        <div class="col-md-8">
		<center>
 
<p><b>MySTAF</b></p>

 
</center>
 


@if(session()->has('msg'))
    <div class="alert alert-danger">
        {{ session()->get('msg') }}
    </div>
@endif

 


            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
			




        </div>
    </div>
</div>
@endsection