@extends('app')

@section('title')
Camp Communities
@endsection

@section('content')
<div class="section section-padded">
    <div class="container-fluid">
        <div class="content">
            
            <p>We have camp workers communities</p>
            
            <h2>Pick your location</h2>
            
            <ul>
                <li><a href="{{ route('community') }}#!/alberta-camps">Alberta Camps</a></li>
                <li><a href="{{ route('community') }}#!/bc-camps">British Columbia Camps</a></li>
                <li><a href="{{ route('community') }}#!/sk-camps">Saskatchewan Camps</a></li>
                <li><a href="{{ route('community') }}#!/north-dakota-camps">North Dakota Camps</a></li>
            </ul>
        </div>        
    </div>
</div>
@endsection


