@extends('app')

@section('title')
{{ $industry->name }} Community Forum
@endsection

@section('content')
<div class="section section-padded">
    <div class="container-fluid">        
        <a id="patchchat-community" class="patchchat-community" href="https://muut.com/i/Patchchat#!/{{ $industry->slug }}-industry">PatchChat {{ $industry->name }} Community</a>

    </div>
</div>
@endsection


