@extends('user_member.member.pos.layouts.base')
@section('container')
{{-- navbar --}}
@include('user_member.member.pos.layouts.navbar')
<div class="container-fluid">    
    <div class="row-fluid">
        
        <div class="col-sm-12 col-md-12 col-xs-12 main">
            @yield('content')
        </div>
    </div>      
</div>
@stop    