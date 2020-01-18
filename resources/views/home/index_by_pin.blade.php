<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Find a Quiz | AyoSekolah</title>
    <!-- Twitter -->
    <link rel="shortcut icon" type="image/x-icon" href="{!! asset('v1/images/defaults/17x17/Ayosekolah-logo-color-opaque.png') !!}">
    @yield("header")
    <!-- vendor css -->
    <link href="{!! asset('v1/lib/@fortawesome/fontawesome-free/css/all.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('v1/lib/ionicons/css/ionicons.min.css" rel="stylesheet') !!}">
    <link href="{!! asset('v1/lib/typicons.font/typicons.css') !!}" rel="stylesheet">
    <link href="{!! asset('v1/lib/prismjs/themes/prism-vs.css') !!}" rel="stylesheet">
    <link href="{!! asset('v1/lib/jqvmap/jqvmap.min.css') !!}" rel="stylesheet">


    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.css') !!}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Poppins:400,500,600,700' rel="stylesheet">
    <style>	
        .wrapper {
            animation: animation_wrapper 5s infinite linear alternate;
            font-family: 'Poppins', sans-serif;
            height:100vh;
        }
        @keyframes animation_wrapper {
            0% {background-color: #3498db;}
            25% {background-color: ##2ecc71;}
            50%{background-color:#9b59b6;}
            100% {background-color: #e74c3c;}
        }
        figure img {
            height: 100%;
            width: 100%;
        }
    </style>

</head>
<body>
    <div class="wrapper">
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
                <div class="col-md-3 text-center p-3">
                    
                    <figure>
                        <img src="{{ url('v1/images/defaults/logo/Ayosekolah-logo-white-transparent.png')}}">
                    </figure>
                    @include('_partial.alert')
                    @if(Auth::guard('busines')->check())
                        <p class="text-white">Cant Join Again</p>
                        <a href="{{ url('/')}}" class="btn btn-dark">Back</a>
                    @else
                    <form action="" method="POST" id="join">
                        @csrf
                        <input type="hidden" name="type" value="student">
                        <div class="form-group">
                            <input type="text" name="code" class="form-control ht-45 busines_id" placeholder="Enter code Quiz">
                        </div>
                        <button type="submit" class="btn-block btn-dark btn ht-45 tx-bold">Join</button>
                    </form>
                    @endif
                </div>
                <div class="text-center fixed-bottom pb-2 pt-5">
                    <a href="http://" class="text-white">Create your own ayosekolah for FREE Ayosekolah.com</a><br>
                    <a href="http://" class="text-white">Term</a> <span class="text-white">|</span> <a class="text-white" href="http://">Privacy</a>
                </div>
        </div>
        </div>
    </div>
    <script src="{!! asset('v1/lib/jquery/jquery.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>

    <script>
        $(document).ready(function(){
            $("#join").submit(function(e){
            e.preventDefault()
            id = $("input[name='code']").val();
            if(id.length == 0){
                alert('Enter your code')
                return false
            }
            window.location.href="{{ url('detail_quiz/')}}/" + id

            });
        });
    </script>
</body>
</html>