@extends('industry/industry')

@section('calout1_title')
Wind Industry Focused
@endsection

@section('calout1_icon')
fa-bullseye
@endsection

@section('calout1_text')
<p>PatchChat is focused on
connecting men and women
working in the Wind industry.</p>
@endsection

@section('calout1_button')
    <a href="{{ route('industry.register', ['industry' => $industry]) }}" class="btn btn-lg btn-primary">Join Our Community</a>
@endsection

@section('facilities_names')
onshore and offshore wind farm facilities
@endsection


