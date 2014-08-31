@extends('layouts.master')

@section('main_menu')
    @parent
@stop


@section('content')

    <div class="content">
      <h2>Description</h2>
      <p>This application allows you to upload and process one or more images of different predefined formats such as: png, jpg, jpeg. </p>
      <p>When uploading the image, you can:</p>
      <ul>
        <li>Add text on the image.</li>
        <li>Set the position where the text on the image is displayed. </li>
        <li>Resize the image.</li>
        <li>Set the font size on the image.</li>
        <li>Set the font color on the image.</li>
        <li>Set the alignment font on the image.</li>
        <li>Set the vertical alignment on the image. </li>
        <li>Set the angle text on the image.</li>
        <li>Generate and download the same image processed in different predefined formats.</li>
      </ul>
      <h2>Tools</h2>
      <ul>
        <li>Laravel 4 - Framework</li>
        <li>jQuery 1.10.2 (with AJAX)</li>
        <li>Twitter Bootstrap v3.0.0</li>
        <li>Intervention Image Class</li>
      </ul>
    </div>
@stop