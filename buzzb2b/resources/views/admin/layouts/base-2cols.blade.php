@extends('admin.layouts.base')

@section('container')
{{-- navbar --}}
@include('admin.layouts.navbar')
<div class="container-fluid">    
    <div class="row-fluid">
        <div class="col-sm-3 col-md-2 col-xs-12 sidebar">
            @include('admin.layouts.sidebar')
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 col-xs-12 main">
            @yield('content')
        </div>
    </div>      
</div>
    
@stop    