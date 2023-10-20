@extends('layouts.app')

@section('content')
<div class="container">
    
    

     
      @foreach($questions as $index => $question)
      
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{$index+1}} . {!! $question->question !!} ({{ $question->id }})</h4>
          @foreach($question->question_options as $question_option)
          <p class="card-text">
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="optradio">{{ $question_option->question_option }}
              </label>
            </div>
            
            </p>
          @endforeach
        </div>
      </div>


      @endforeach
    </tbody>
  </table>


 
   


  
</div>
@endsection
