@extends('layouts.app')

@section('content')
<div class="container">
    
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif

  @if(!empty($questions->id))
  <form method="POST" action="{{ route('question.edit') }}">
  @else
  <form method="POST" action="{{ route('question.store') }}">
  @endif
  
    @csrf
  <div class="form-group">
    <label for="email">Soalan :</label>
    <textarea  id="summernote" class="form-control"   name="question">
      @if(!empty($questions->question))
        {{$questions->question}}
      @endif
    </textarea>
  </div>

  <div class="form-group">
    <label for="sel1" >Jenis Soalan :</label>
    <select class="form-control" name="question_type_id" required>
      <option value="">-Pilih-</option>
      @foreach($question_types as $index => $question_type)
      <option value=" {{ $question_type->id }}" @if(!empty($questions->question_type_id)){ @if($question_type->id==$questions->question_type_id )  selected   @endif @endif> {{ $question_type->question_type }}</option> 
      @endforeach
    </select>
  </div>


   <input type="hidden" name="id" value="<?php if(!empty($questions->id)){ echo $questions->id; } ?>">
   
  <button type="submit" class="btn btn-primary">Submit</button>
</form>



  
</div>

 


@endsection
