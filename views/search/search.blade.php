@extends('app')

@section('title')
    @if($industry and $industry->slug)
    {{ ucwords($industry->facilities_names) }}
    @else
    Search Results
    @endif
@endsection


@if($industry and $industry->slug)
@section('breadcrumb')
    <li><a href="{{ route('industry',['industry'=>$industry->slug]) }}">{{ $industry->name }}</a></li>
    <li>{{ ucwords($industry->facilities_names) }}</li>    
@endsection
@endif

@section('content')
<div class="section">
    <div class="container">    
        <div class="row">
            <div class="col-sm-9">
            <div class="">
            @if ( !$facilities->count() )
                <div class="search-result tab-pane">
                No facilities found
                </div>
            @else
                @foreach($facilities as $facility)		  
                <div class="search-result tab-pane">
                    <h3 class="facility-title"><a href="{{ route('facility.show', [
                      'facility'=>$facility->slug
                    ]) }}"><?php echo $facility->name;?></a> 
                        <small><br>{{ $facility->category->name }}
                        @if ($facility->companyObj)
                            - {{ $facility->companyObj->name }}
                        @endif 
                        </small>
                    </h3>
                    
                    <div class="row">
                      <div class="col-sm-12">
                          <div class="facility-location">
                            <i class="fa fa-map-marker"></i> 
                            @if($facility->cityObj)
                            {{ $facility->cityObj->name }}, 
                            @endif
                            @if($facility->state->name != "NA")
                            {{ $facility->state->name }}, 
                            @endif
                            {{ $facility->country->name }}
                                       
                            
                            @if ($facility->phone_emergency or $facility->phone_reservations or $facility->phone_main or $facility->phone_cell )
                                <i class="separator">|</i> <i class="fa fa-phone"></i>
                                @if ($facility->phone_main) 
                                <a rel="nofollow"  href="tel:{{ $facility->phone_main }}">{{ $facility->phone_main }}</a>
                                @elseif ($facility->phone_emergency)
                                <a rel="nofollow"  href="tel:{{ $facility->phone_emergency }}">{{ $facility->phone_emergency }}</a>                        
                                @elseif ($facility->phone_reservations)
                                <a rel="nofollow"  href="tel:{{ $facility->phone_reservations }}">{{ $facility->phone_reservations }}</a>
                                @elseif ($facility->phone_cell)
                                <a rel="nofollow"  href="tel:{{ $facility->phone_cell }}">{{ $facility->phone_cell }}</a>                     
                                @endif
                            @endif     
                                                      
                          </div>
                      </div>
                    </div>              
                </div>              
                @endforeach
                
                <div class="text-right">
                {!! $facilities->render() !!}
                </div>
                                		 
            @endif
            </div>
            </div>
            
            <div class="col-md-3">
                <h3>Sponsors</h3>
                @include('ads/_sponsors', ['limit' => '10'])
            </div>
        
        </div>           
   </div>
</div> 
@endsection
