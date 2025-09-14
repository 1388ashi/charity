@extends('core::invoice.layouts.callback-master')

@section('content')
    <div style="color:#9c0000;box-shadow: 0px 1px 5px rgba(28,28,28,0.44); background-color: #98989829;padding: 1%">
        <h3 class="message">{{ $message }}</h3>
        @if(isset($description))<p>{{ $description }}</p>@endif
    </div>
@endsection


@section('style')
    <style>
        .message{
            text-align: center;
        }
        div.relative>span{
            padding-bottom: 0;
        }
    </style>
@endsection
