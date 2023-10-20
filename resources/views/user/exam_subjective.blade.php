@extends('layouts.app')

@section('content')
<div class="container">

  <h1><span class="badge badge-danger" id="demo"> 
    <?php 
     
    echo date("Y-m-d h:i:s"); ?>
  
  </span></h1>
    
  <div class="alert alert-danger">
    <strong>Anda diwajibkan untuk menjawab 2 soalan subjektif.
  </div>
 
 <h3> Bilangan Soalan yang dijawab : <span class="badge badge-success">{{$count}}/2 </span></h3>
   
      @foreach($questions as $index => $question)
      
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ $loop->iteration + $questions->firstItem() - 1 }}. {!! $question->question !!}</h4>
         
          <form method="POST" action="{{ route('user.subjectiveStore') }}">           
           @csrf
            <div class="form-group">
              <label for="email">Jawapan anda :</label>

              <textarea  id="summernote2" class="form-control"   name="answer" required>
                 <?php
                 $user_id = Auth::user()->id;
                 $userAnswer = \App\Models\UserAnswer::where('question_id',$question->id)
                 ->where('user_id',$user_id)
                 ->first();
                 ?>
                 @if(!empty($userAnswer->id))
                 {{$userAnswer->answer}}
                 @endif
              </textarea>
            </div> 
          
             <input type="hidden" name="question_id" value="<?php if(!empty($question->id)){ echo $question->id; } ?>">
             
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>


          
        </div>
      </div>


      @endforeach
	  
  
  
    </tbody>
  </table>
  

<br>
  {!! $questions->links() !!}
 
   


  
</div>
@endsection
