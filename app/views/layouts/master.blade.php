<!DOCTYPE html>
<html>
<head>
    <title>C2 - Assignment - {{ $title }} - Jose Sinisterra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    {{ HTML::style('assets/css/bootstrap.min.css') }}
    {{ HTML::style('assets/css/custom.css') }}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        {{ HTML::script('assets/js/html5shiv.js') }}
        {{ HTML::script('assets/js/respond.min.js') }}
    <![endif]-->
</head>
<body>

    <div class="navbar navbar-default navbar-static-top">

        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {{ HTML::linkRoute('main', 'C2 - Assignment', array(), array('class' => 'navbar-brand')) }}
            </div>

            <div class="navbar-collapse collapse">

                @section('main_menu')

                <ul class="nav navbar-nav">
                    <li>{{ HTML::linkRoute('images', 'Last images') }}</li>
                    <li>{{ HTML::linkRoute('description', 'Description') }}</li>
                </ul>

                @show                

            </div><!--/.navbar-collapse -->

        </div> <!-- end of container -->

    </div> <!-- end of navbar navbar-default navbar-static-top -->

    <div class="container" id="main">

        <div class="row clearfix">

            @if(Session::has('files'))
            <div class="col-md-8">
            @else
            <div class="col-md-12">
            @endif               

                @yield('content')

            </div>

            
            @if (Session::has('files'))
            <div class="col-md-4">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Original image(s)</h3>
                    </div>
                    <div class="panel-body">

                            @foreach (Session::get('files') as $file)
                                {{-- */$id = Images::findOrFail($file)->id;/* --}}
                                {{-- */$img_big = Images::findOrFail($file)->img_big;/* --}}
                                <a href="{{ URL::to('uploads/' . $id . '/' . $img_big) }}" title="{{ $img_big }}">

                                {{ HTML::image('uploads/' .$id . '/' . $img_big, $img_big, array('class' => 'img-responsive img-thumbnail', 'style' => 'display: block; margin: 0 auto;')) }}
                                </a>
                                 <br class="clear" />
                            @endforeach

                    </div>
                </div>

            </div>
            @endif

            

        </div>

    </div>

    <br class="clear" />

    
    <hr />
    <div class="container">
        <p style="text-align: center;">Copyright by Jose Sinisterra {{ date('Y') }}.</p>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {{ HTML::script('http://code.jquery.com/jquery.js') }}
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {{ HTML::script('assets/js/bootstrap.min.js') }}
    <!-- Logowanie - ajax -->
    {{ HTML::script('assets/js/login.ajax.js') }}
    <!-- Wrzucanie zdjec -->
    {{ HTML::script('assets/js/img.send.js') }}
    <!-- Taby i confirm delete-->
    <script>
        $(document).ready(function() {
            var main = $('#main');
            main.hide();
            main.fadeIn(800);
        });
    </script>
    @section('add_script')
    @show
</body>
</html>
