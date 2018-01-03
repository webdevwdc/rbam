@extends('user_member.user.layouts.base-2cols')
@section('title','Phone List')
@section('content')
<div class="row">    

      <div class="col-md-12">
	
              {{-- messages section start--}}
              @include('admin.includes.messages')
	             {{-- messages section end--}}
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i>{{Auth::user()->email}}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <a href="{{route('user-add-phone')}}" class="btn btn-success" title="Add New Phone"><i class="fa fa-plus"></i>Add New</a>
                            </div>
                        </div>
                     <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover">
                                  <thead>
                                      <tr>
                            						<th>Number</th>
                            						<th>Type</th>
                            						<th>Primary</th>
                            						<th>Action</th>
                                      </tr>
                                    </thead>
                                  <tbody>
                                @foreach($phones as $phone)
                                  <tr>
                                    <td>{{$phone->number}}</td>
                                    <td>
                                      @if($phone->phone_type_id==1)
                                       Office
                                      @else
                                       Home
                                      @endif
                                    </td>
                                    <td>
                                     @if($phone->is_primary=='Yes')
                                       <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                      @else
                                       <a href="{{route('default-phone',[$phone->id])}}" class="btn btn-primary" title="Make Default">Make Default</a>
                                      @endif 
                                    </td>
                                    <td>
                                      @if($phone->is_primary=='No')
                                       <a href="{{route('delete-phone',[$phone->id])}}" onclick="return confirm('Are You Sure Want To Delete This Phone')">
                                        <i class="fa fa-trash-o"></i>
                                       </a>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                                  </tbody>
                            </table>
                            <div class="paginator">
                                
                            </div>
                           
                        </div>
                    </div>
                 </div>
               </div>
	        </div>
</div>
@endsection