@extends('admin.layouts.base-2cols')
@section('title', 'User List')
@section('content')
    
<div class="row">    
<div class="col-md-12">
	
        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
		{{-- user lists --}}
		
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> {{ Session::get('EXCHANGE_CITY_NAME') }} : User List</h3>
                    </div>
                    <div class="panel-body">
                    <!-- searching section start -->
                   <form action="{{route('admin_user')}}" id="search">
                        <!-- email text field -->
                                <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                  <input type="trext" class="form-control required" name="keyword" placeholder="Enter The Keyword"> 
                                                </div>
                                                <!-- first_name text field -->
                                        </div>
                                </div>

                        <div class="form-group">
                           
                           
                            <button onclick="laravel();" type="button" class="btn btn-default search-reset">
                        <i class="fa fa-refresh" aria-hidden="true"></i>  Reset
                        </button>

                         <button type="submit" class="btn btn-info" >
                         <i class="fa fa-search" aria-hidden="true"></i> Search
                        </button>
                        </div>
                        </form>
                    <!-- end searching section -->
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <a href="{!! URL::route('admin_user_create') !!}" class="btn btn-info" title="Add New User"><i class="fa fa-plus"></i> Add User</a>
                            </div>
                        </div>
                                <div class="row">
                        <div class="col-md-12">
                            @if( $lists->count() )
                            <table class="table table-hover">
                                  <thead>
                                      <tr>
                                          <th>Email</th>
				                                  <th>Name</th>
                                          <th>Member(s)</th>
				                                  <th>Member Primary</th>
				                                  <th>User Since</th>
				                                  <th>Last Updated</th>    
                                          <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lists as $record)
                                      <tr>
				                                <td>
                                          <a href="{!! URL::route('admin_user_edit', ['id' => $record->id]) !!}" style="color: #2cafe3;">
                                          {{ $record->email}}
                                          </a>
                                        </td>
				                                    <td>{{ $record->first_name.' '.$record->last_name}}</td>
				                                 <td>
      						                         {{ $record->first_name}} 
                                           @if(App\User::GetUsersCount($record->id)>1) + 
                                           <strong>{{App\User::GetUsersCount($record->id)}} more</strong> 
                                           @endif
					                               </td>
					                              <td>
                                          @if( $record->primary) 
                                            <i class="fa fa-check" aria-hidden="true" style="color:green;"></i> 
                                          @else 
                                          -- 
                                          @endif
                                        </td>
					                                <td>{{ date('jS M, Y', strtotime($record->created_at)) }}</td>
					                                <td>{{ timeAgo($record->updated_at) }} ago</td>    
                                       
                                            <td>
                                              
                                              <!-- @if($record->is_admin==0)
                                              <a href="{{route('admin.makeAdmin',$record->id)}}" title="Make Admin">
                                              <i class="fa fa-user"></i>
                                              </a> 
                                              @endif

                                              @if($record->is_admin==1)
                                              <a href="{{route('admin.makeAdmin',$record->id)}}" title="Remove Admin">
                                              <i class="fa fa-user" style="color:green"></i>
                                              </a> 
                                              @endif -->                                             
                                            
                                              <a href="{!! URL::route('admin_user_edit', ['id' => $record->id]) !!}" title="Edit User">
                                              <i class="fa fa-pencil-square-o fa-2x"></i>
                                              </a>                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                            </table>
                            <div class="paginator">
                                {!! $lists->appends(['keyword' => $keyword])->render(); !!}
                            </div>
                            @else
                                <span class="text-warning"><h5>No results found.</h5></span>
                            @endif
                        </div>
                      </div>
                    </div>
                </div>
                
                
	</div>
</div> 
<!-- reset searach form -->
<script type="text/javascript">
  function laravel(){
    document.getElementById('search').reset();
    $('#search').submit();
  }

</script>
@endsection 