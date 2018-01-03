@extends('admin.directory.layouts.base')
@section('title', 'Directory')
@section('container')
{{-- navbar --}}
     @include('admin.directory.layouts.navbar')
<div class="container-fluid">    
    <div class="row-fluid">
        <div class="col-sm-4 col-md-3 col-xs-12 sidebar common">
            @include('admin.directory.layouts.sidebar')
        </div>
        <div class="col-sm-8 col-xs-12 main common">
            @yield('content')
        </div>
    </div>      
</div>
    
@stop    