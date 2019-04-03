@extends('app')

@section('title')
Wiki Encyclopedia
@endsection

@section('content')

<div class="section section-white section-padded bottom-border text-center section-large">
    <div class="container">
        
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
            <p>Are you employed in the natural resources Industry?</p>
            <p>Join us in building the ultimate industry specific encyclopedia</p>
            </div>
        </div>
        
        <p>
            <a href="{{ route('wiki.add') }}" class="btn btn-lg btn-primary">Join Us</a>
        </p>
    </div>
</div>

@endsection
