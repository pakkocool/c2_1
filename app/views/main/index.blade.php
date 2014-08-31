@extends('layouts.master')

@section('main_menu')
    @parent
@stop


@section('content')

    {{ Form::open(array('url' => 'upload', 'method' => 'post', 'id' => 'upload-image', 'enctype' => 'multipart/form-data', 'files' => true)) }}

        <div class="form-group">
            <div id="browse" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-picture"></span>  Select images</div>
        </div>

        {{ Form::file('file[]', array('multiple' => 'multiple', 'id' => 'multiple-files', 'accept' => 'image/*')) }}

        <div id="files"></div>

        <div class="form-group" id="form-buttons">

            <div class="row">
              <div class="col-md-12"> {{ Form::label('text', 'Text on picture:') }}</div>              
            </div>
            <div class="row">
              <div class="col-md-12">{{ Form::text('text', null, ['class' => 'form-control', 'placeholder'=>'You must write something']) }}</div>              
            </div>
            <div class="row">
              <div class="col-md-6"> {{ Form::label('resize', 'Re-size picture:') }}</div>
              <div class="col-md-6"> {{ Form::label('position', 'Position text:') }}</div>
            </div>
            <div class="row">
              <div class="col-md-3">{{ Form::text('resizew', null, ['class' => 'form-control', 'placeholder'=>'Width']) }}</div>
              <div class="col-md-3">{{ Form::text('resizeh', null, ['class' => 'form-control', 'placeholder'=>'Height']) }}</div>
              <div class="col-md-3">{{ Form::text('posx', null, ['class' => 'form-control', 'placeholder'=>'Position X']) }}</div>
              <div class="col-md-3">{{ Form::text('posy', null, ['class' => 'form-control', 'placeholder'=>'Position Y']) }}</div>              
            </div>
            
            <div class="row">
              <div class="col-md-3"> {{ Form::label('font', 'Text size and font color:') }}</div>
              <div class="col-md-8"> {{ Form::label('align', 'Alignment and Angle text:') }}</div>
            </div>
            <div class="row">
              <div class="col-md-2">{{ Form::text('sizefont', null, ['class' => 'form-control', 'placeholder'=>'Size font']) }}</div>
              <div class="col-md-1">{{ Form::input('color', 'text_color', null, array('class' => 'input-big')) }}</div>
              <div class="col-md-3">{{ Form::select('align', ['left', 'right', 'center','justify'],'center', ['class' => 'form-control']) }}</div>
              
              <div class="col-md-3">{{ Form::select('valign', ['top', 'middle', 'bottom','baseline'],'top', ['class' => 'form-control']) }}</div>              
              <div class="col-md-3">{{ Form::text('angle', null, ['class' => 'form-control','placeholder'=>'-360&#176; till 360&#176;']) }}</div>              
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                {{ Form::submit('Process image...', array('class' => 'btn btn-success btn-lg btn-block')) }} 
              </div>              
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                {{ Form::reset('Cancel', array('class' => 'btn btn-warning btn-block', 'id' => 'reset')) }}
              </div>              
            </div>
            
        </div>

    {{ Form::close() }}

    <div id="notifications">

        @if (Session::has('image-message'))
            <div class="alert {{ Session::get('status') }} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('image-message') }}
            </div>
        @endif

        @if($errors->has())
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
             <ul>
            <h4>Potential Problems</h4>            
            @foreach ($errors->all() as $error)
                <li class="help-inline errorColor"> {{ $error }} </li>     
            @endforeach
            </ul></div>
        @endif

        @if (Session::has('files'))

            @foreach (Session::get('files') as $file)

                {{-- */$id = Images::findOrFail($file)->id;/* --}}
                {{-- */$img_big = Images::findOrFail($file)->img_big;/* --}}
                
                <div class="row">
                  <div class="col-md-3 col-centered">
                    <a href="{{ URL::to('download/' . $id . '/'. $img_big.'/') }}" class="btn btn-primary btn-small active">Download Original<i class="icon-white icon-download-alt"></i></a>
                  </div>   
                  <div class="col-md-3 col-centered">
                    <a href="{{ URL::to('download/' . $id . '/min_'. $img_big.'/png') }}" class="btn btn-success btn-small">Download in PNG<i class="icon-white icon-download-alt"></i></a>
                  </div>
                  <div class="col-md-3 col-centered">
                    <a href="{{ URL::to('download/' . $id . '/min_'. $img_big.'/jpeg') }}" class="btn btn-success btn-small">Download in JPEG<i class="icon-white icon-download-alt"></i></a>
                  </div>
                  <div class="col-md-3 col-centered">
                    <a href="{{ URL::to('download/' . $id . '/min_'. $img_big.'/jpg') }}" class="btn btn-success btn-small">Download in JPG<i class="icon-white icon-download-alt"></i></a>
                  </div>           
                </div> 
                <br>     
                <div class="row">
                    <div class="col-md-12 col-centered">
                        <a href="{{ URL::to('uploads/' . $id . '/min_' . $img_big) }}" title="{{ $img_big }}">
                        {{ HTML::image('uploads/' .$id . '/min_' . $img_big, $img_big, array('class' => 'img-responsive img-thumbnail', 'style' => 'display: block; margin: 0 auto;')) }}
                        </a>
                     </div>  
                 </div>  
            @endforeach          
        @endif
    </div>
@stop