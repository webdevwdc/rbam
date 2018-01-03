@extends('admin.pos.layouts.base')
@section('container')
{{-- navbar --}}
@include('admin.layouts.navbar')
<div class="container-fluid">    
    <div class="row-fluid">
        
        <div class="col-sm-12 col-md-12 col-xs-12 main">
            @yield('content')
        </div>
    </div>      
</div>
@stop    