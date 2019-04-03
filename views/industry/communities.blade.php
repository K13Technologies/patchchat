@extends('app')

@section('title')
Industry Communities
@endsection

@section('content')
<div class="section section-padded">
    <div class="container-fluid">
        <div class="content">
            
            <p>We have an industry specific communities for people like you</p>
            
            <h2>Pick your Industry</h2>
            
            <ul>
            @foreach($industries as $industry)
                <li><a href="{{ route('community.industry', ['industry' => $industry->slug]) }}">{{ $industry->name }}</a></li>
            @endforeach
            </ul>
        </div>        
    </div>
</div>
@endsection


