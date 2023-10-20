 
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MYSTAF</title>

    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  
     
                            
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    

  
     

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script>
        
</script>
<style>
    .countup {
        text-align: center;
        margin-bottom: 20px;
      }
      .countup .timeel {
        display: inline-block;
        padding: 10px;
        background: #151515;
        margin: 0;
        color: white;
        min-width: 2.6rem;
        margin-left: 13px;
        border-radius: 10px 0 0 10px;
      }
      .countup span[class*="timeRef"] {
        border-radius: 0 10px 10px 0;
        margin-left: 0;
        background: #e8c152;
        color: black;
      }


    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    MySTAF
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                               
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Utama</a>
                            </li>
                             

                            @if(Auth::user()->level_id==2) 
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('student.index') }}">Staf</a>
                            </li>

                             
                            @endif

                             

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>




<script>


  @if(Session::has('success'))
  		toastr.success("{{ Session::get('success') }}");
  @endif


  @if(Session::has('info'))
  		toastr.info("{{ Session::get('info') }}");
  @endif


  @if(Session::has('warning'))
  		toastr.warning("{{ Session::get('warning') }}");
  @endif


  @if(Session::has('error'))
  		toastr.error("{{ Session::get('error') }}");
  @endif


</script>


    
<script>
    $('#summernote').summernote({
      placeholder: 'Sila taip..',
      tabsize: 2,
      height: 400,
      maximumImageFileSize: 1048576
    });

    $('#summernote2').summernote({
        placeholder: 'Sila taip..',
        tabsize: 2,
        height: 400,
        maximumImageFileSize: 1048576,
        toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],  
    ['para', ['ul', 'ol', 'paragraph']], 
  ]
      });







  </script>
  <script>
            /*
 * Basic Count Up from Date and Time
 * Author: @mrwigster / https://guwii.com/bytes/count-date-time-javascript/
 */
window.onload = function() {
    // Month Day, Year Hour:Minute:Second, id-of-element-container
    //countUpFromTime("Jan 1, 2014 12:00:00", 'countup1'); // ****** Change this line!
    <?php
    date_default_timezone_set("Asia/Kuala_Lumpur");

    $month = date('M');
    $date = date('d');
    $year = date('Y');
    //$t = date('H:i');//$time="10:09";
    $t="11:00";
     $time = date('H:i', strtotime($t.'+1 hour'));
    ?>
    countUpFromTime("<?php echo $month ?> <?php echo $date ?>, <?php echo $year ?> <?php echo $time ?>:00", 'countup1'); // ****** Change this line!
  };
  function countUpFromTime(countFrom, id) {
    countFrom = new Date(countFrom).getTime();
    var now = new Date(),
        countFrom = new Date(countFrom),
        timeDifference = (now - countFrom);
      
    var secondsInADay = 60 * 60 * 1000 * 24,
        secondsInAHour = 60 * 60 * 1000;
      
    days = Math.floor(timeDifference / (secondsInADay) * 1);
    hours = Math.floor((timeDifference % (secondsInADay)) / (secondsInAHour) * 1);
    mins = Math.floor(((timeDifference % (secondsInADay)) % (secondsInAHour)) / (60 * 1000) * 1);
    secs = Math.floor((((timeDifference % (secondsInADay)) % (secondsInAHour)) % (60 * 1000)) / 1000 * 1);
  
    var idEl = document.getElementById(id);
    
    idEl.getElementsByClassName('hours')[0].innerHTML = hours;
    idEl.getElementsByClassName('minutes')[0].innerHTML = mins;
    idEl.getElementsByClassName('seconds')[0].innerHTML = secs;
  
    clearTimeout(countUpFromTime.interval);
    countUpFromTime.interval = setTimeout(function(){ countUpFromTime(countFrom, id); }, 1000);
  }
</script>