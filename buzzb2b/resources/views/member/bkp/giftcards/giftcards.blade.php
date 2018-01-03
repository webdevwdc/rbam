@extends('admin.layouts.base-2cols')
@section('title', 'Gift Cards')
@section('content')
<div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : GiftCards</h3>
                    </div>
                </div>
            </div>
</div
@endsection