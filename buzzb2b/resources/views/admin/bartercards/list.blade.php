@extends('admin.layouts.base-2cols')
@section('title','BarterCards List')
@section('content')
<div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : BarterCard List</h3>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-3">
                <a href="{{route('add-bartercard')}}" class="btn btn-success" style="margin-top: 8px;" title="">
                 Add BarterCard
                </a>
            </div>
            @if(!empty($cards))
            <!-- starts here -->
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Serial no.</th>
                                <th>Number</th>
                                <th>Status</th>
                                <!-- <th>Edit</th> -->
                            </tr>
                        </thead>
                            <tbody>
                            @php $i=1; @endphp
                            @foreach($cards as $card)
                              <tr>
                               <td>{{$i++}}</td>
                               <td>{{$card->number}}</td>
                               <td>
                               	@if($card->type==1)
                               	 Active
                               	@else
                               	 Inctive
                               	@endif
                               </td>
                               <!-- <td>
                               	<a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                               </td> -->
                              </tr>
                             @endforeach
                            </tbody>
                    </table>
                    <div class="paginator">
                       {{ $cards->render() }}   
                    </div>
                       
                </div>
            </div>

            @endif

        </div>

@endsection