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
<div class="float-right"> 
<a href="{{ route('question.form') }}" class="btn btn-primary">Cipta Soalan</a>
</div>
    <h2>Koleksi Soalan</h2>  
        <hr>  
        
        
        <form class="form-inline" action="{{ route('question.filter') }}" method="POST">
          @csrf

          <label for="email">Soalan :</label>
          <input type="text" class="form-control"  name="question"  value="<?php if(!empty($question)){ echo $question; } ?>">
          &nbsp;

          <label for="email">Pilih Jenis Soalan :&nbsp; </label>
          <select class="form-control" name="question_type_id"  >
            <option value="">-Pilih-</option>
            @foreach($questionTypes as $index => $questionType)
            <option value="{{  $questionType->id }}" <?php if(!empty($question_type_id)){ if($question_type_id==$questionType->id){ echo "selected"; } } ?>>{{  $questionType->question_type }}</option>
            @endforeach
          </select>
           
          <button type="submit" class="btn btn-primary ml-5">Filter</button>
        </form>

<br/>


  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No.</th>
        <th>Soalan</th>
        <th>Pilihan Jawapan</th>
        <th>Tindakan </th>
       
      </tr>
    </thead>
    <tbody>
      @foreach($questions as $index => $question)
      <tr>
        <td>{{ $loop->iteration + $questions->firstItem() - 1 }}. </td>
        <td>{!! $question->question !!}

          @if($question->question_type_id ==2) 
          <br>
          <span class="badge badge-warning">Soalan Subjektif</span>
          @endif

        </td>
        <td> 
         @if($question->question_type_id ==2) 
          <span class="badge badge-warning">Jawapan Subjektif</span>
         @else 

          @foreach($question->question_options as $question_option)

          <div class="card">
            <div class="card-body">              
              <p class="card-text"> 
                @if($question_option->is_correct==1)
                <span class="badge badge-success">  {{ $question_option->question_option }}</span>               
                @else
                {{ $question_option->question_option }}
                @endif
                
              <hr>
              <a class="btn btn-danger btn-sm" href="{{ route('question_option.delete', $question_option->id) }}" class="" onclick="return confirm('anda Pasti ?')">
                <i class='fas fa-trash'></i>
              </a>

              <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalEdit{{ $question_option->id }}">
                <i class='fas fa-edit'></i>
              </a>

              <!-- The Modal -->
          <div class="modal fade" id="myModalEdit{{ $question_option->id }}">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Pilihan Jawapan</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                  @if(!empty($question_option->id))
                  <form method="POST" action="{{ route('question_option.edit') }}">
                  @else
                  <form method="POST" action="{{ route('question_option.store') }}">
                  @endif
                 
                      @csrf
                    <div class="form-group">
                      <label for="email">Pilihan Jawapan :</label>
                      <input type="text"   class="form-control"   name="question_option" value="<?php if(!empty($question_option->question_option)){ echo $question_option->question_option; } ?>" required> 
                    </div>


                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="1" name="is_correct" <?php if($question_option->is_correct==1){ echo "checked"; } ?>>Tick Jika ini jawapan betul
                      </label>
                    </div>
                    <input type="hidden"   value="{{ $question_option->id }}"   name="question_option_id"> 
                    <input type="hidden"   value="{{ $question->id }}"   name="question_id"> 
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                  
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                
              </div>
            </div>
          </div>

              

            </div>

            
          </div>
              
          @endforeach

          @endif

        </td>
        <td class="justify-content-center">
          @if($question->question_type_id ==1)  
          <a href="#" class="btn btn-primary btn-sm mx-auto" data-toggle="modal" data-target="#myModal{{ $question->id }}" data-toggle="tooltip" title="Hooray!">
            <i class='fas fa-check'></i>
          </a> 
          @endif
          <!-- Button to Open the Modal -->
          

          <!-- The Modal -->
          <div class="modal fade" id="myModal{{ $question->id }}">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Pilihan Jawapan</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                  <form method="POST" action="{{ route('question_option.store') }}">
                      @csrf
                    <div class="form-group">
                      <label for="email">Pilihan Jawapan :</label>
                      <input type="text"   class="form-control"   name="question_option" value="<?php if(!empty($question->question_option)){ echo $question->question_option; } ?>"> 
                    </div>


                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="1" name="is_correct" >Tick Jika ini jawapan betul
                      </label>
                    </div>
 
                    <input type="hidden"   value="{{ $question->id }}"   name="question_id"> 
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                  
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                
              </div>
            </div>
          </div>

          

         

          <a href="{{ route('question.editForm', $question->id) }}" class="btn btn-warning btn-sm m-1">
            <i class='fas fa-edit'></i>
          </a>

          <a href="{{ route('question.delete', $question->id) }}" class="btn btn-danger btn-sm"  onclick="return confirm('anda Pasti ?')">
            <i class='fas fa-trash'></i>
          </a>
         </td> 
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="d-flex justify-content-center">
  

    {{ $questions->appends(Request::except('page'))->links() }}
</div>

  
</div>
@endsection
