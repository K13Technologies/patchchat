@extends('industry/industry')

@section('calout1_title')
Energy Industry Focused
@endsection

@section('calout1_icon')
fa-bullseye
@endsection

@section('calout1_text')
<p>PatchChat hosts the worlds largest work camp community.</p>
@endsection

@section('calout1_button')
    <a href="{{ route('camp.add', ['industry' => $industry]) }}" class="btn btn-lg btn-primary">Add Your Camp</a>
@endsection

@section('facilities_names')
oil and gas facilities
@endsection


