@extends('app')

@section('title')
Press
@endsection

@section('content')
<div class="jumbotron section text-center section-large" style="background-image:url(/img/bg-map.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <p>&nbsp;</p>
                
                <h3>Our mission is to be the world's largest resource industry-based community.<br>
                Our members contribute by authoring industry specific wikis and actively mapping all work camps and resource facilities worldwide.</h3>
                <p>&nbsp;</p>
            </div>
        </div>
        
    </div>
</div>

<div class="section section-white section-padded bottom-border text-center maps">
    <div class="container">
        <h2 class="text-center">Advertisers Include</h2>
        @include('ads/_sponsors',['limit'=>10])
    </div>
</div>
@endsection


