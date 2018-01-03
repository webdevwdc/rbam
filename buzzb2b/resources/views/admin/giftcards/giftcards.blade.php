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
            
            <div class="col-lg-2 col-md-3 col-sm-3">
                <a href="{{route('issue-giftcacrd')}}" class="btn btn-success" style="margin-top: 8px;" title="">
                 Issue Giftcard to Member
                </a>
            </div>
           
            <!-- starts here -->
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Issue Member</th>
                                <th>Status</th>
                                <th>Issued</th>
                                <th>Original Balance</th>
                                <th>Current Balance</th>
                                <th>Earned Revenue</th>
                            </tr>
                        </thead>
                            <tbody>
                                @if(!empty($gifts))
                                @foreach($gifts as $gift)
                                <tr>
                                    <td>{{$gift->number}}</td>
                                    <td>--</td>
                                    <td>{{$gift->name}}</td>
                                    <td>
                                        @if($gift->active==1)
                                        Active
                                        @else
                                        Inactive
                                        @endif
                                    </td>
                                    <td>{{$gift->created_at->format('D, M,d Y')}}</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                </tr>
                                @endforeach

                                
                            </tbody>
                    </table>
                        <div class="paginator">
                          
                        </div>
                        @else
                          <span class="text-warning"><h5>No results found.</h5></span>
                        @endif
                </div>
            </div>

        </div>
@endsection