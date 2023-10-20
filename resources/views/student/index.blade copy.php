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
  <a href="{{ route('student.form') }}" class="btn btn-primary">Cipta </a>
  </div>

  

  
  
 

    <h2>Senarai Pelajar</h2>  
        <hr>  
        
        <form class="form-inline" action="{{ route('student.filter') }}" method="POST">
          @csrf
          <label for="email">No.KP :</label>
          <input type="text" class="form-control"  name="email"  value="<?php if(!empty($email)){ echo $email; } ?>">
          &nbsp;


          <label for="email">Pilih Ipt :&nbsp; </label>
          <select class="form-control" name="ipt_id"  >
            <option value="">-Pilih-</option>
            @foreach($ipts as $index => $ipt)
            <option value="{{  $ipt->id }}" <?php if(!empty($ipt_id)){ if($ipt_id==$ipt->id){ echo "selected"; } } ?>>
              {{  $ipt->ipt }}</option>
            @endforeach
          </select>
           
          <button type="submit" class="btn btn-primary ml-5">Filter</button>
        </form>


  <table class="table table-bordered mt-2">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>No. KP</th>
        <th>Ipt </th>
        <th>  </th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $index => $user)
      <tr>
        <td>{{ $loop->iteration + $users->firstItem() - 1 }}. </td>
        <td>{{  $user->name }}</td>
        <td>{{  $user->no_kp }} </td>
        <td class="justify-content-center">{{$user->ipts->ipt}}  </td> 
        <td class="justify-content-center"> 
           

          <a href="{{ route('student.delete', $user->id) }}" class="btn btn-danger btn-sm"  onclick="return confirm('anda Pasti ?')">
            <i class='fas fa-trash'></i>
          </a>

          <a href="{{ route('student.editForm', $user->id) }}" class="btn btn-warning btn-sm"   >
            <i class='fas fa-edit'></i>
          </a>
        
        </td> 
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="d-flex justify-content-center">
  

    {{ $users->appends(Request::except('page'))->links() }}
</div>

  
</div>

<script type="text/javascript">

  function changeFunc() {
   var selectBox = document.getElementById("ipt_id");
   var selectedValue = selectBox.options[selectBox.selectedIndex].value;
   alert(selectedValue);
 url='aduan_list.php?ipt_id='+selectedValue;
 window.location = url;
  }

 </script>

@endsection
