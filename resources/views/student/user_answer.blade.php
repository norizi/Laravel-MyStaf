@extends('layouts.app')

@section('content')
<div class="container">
  @if(Session::has('success'))
  <p class="alert alert-info">{{ Session::get('success') }}</p>
  @endif
    
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 
    <h2>Jawapan Pelajar : {{ $users->name }}</h2>  
        <hr>  
        
        


  <table class="table table-bordered mt-2">
    <thead>
      <tr>
        <th>No.</th>
        <th>Soalan</th>
        <th>Jawapan Pelajar</th>
        <th>Jawapan betul </th>
        <th> Markah </th>
      </tr>
    </thead>
    <tbody>
      @foreach($userAnswers as $index => $userAnswer)
      <tr>
        <td>{{ $loop->iteration + $userAnswers->firstItem() - 1 }}. </td>
        <td>{!!  $userAnswer->questions->question !!} </td>
        <td> 
          @if($userAnswer->question_type_id ==1)
            @if(!empty($userAnswer->question_options->question_option))
            {{$userAnswer->question_options->question_option}}  
            @endif
          @else
            @if(!empty($userAnswer->answer))
            {!! $userAnswer->answer !!}  
            @endif
          @endif
          </td>
        <td>   {{$userAnswer->question_answer_correct() }}   </td> 
        <td class="justify-content-center"> 
           
        @php
        if($userAnswer->question_type_id == 1){
           $student_answer = optional($userAnswer->question_options)->question_option;
           $correct_answer = $userAnswer->question_answer_correct();
           if($student_answer!='' && $student_answer==$correct_answer){
              echo "1";
           }else{
            echo "0";
           }
        }
          
         @endphp
        
        </td> 
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="d-flex justify-content-center">
  

    {{ $userAnswers->appends(Request::except('page'))->links() }}
</div>

  
</div>
 

@endsection
