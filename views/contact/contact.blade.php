@extends('app')

@section('title')
Contact Us
@endsection

@section('content')
<div class="section section-padded">
    <div class="container">
<div class="content">
        <h3>Thank you for reaching out!</h3>
        
        <p>What's on your mind?</p>
        
        <div class="row"><div class="col-sm-8">
        {!! Form::open([
            'id'=>'frmContact', 
            'class'=>'form form-vertical',
            'action' => 'ContactController@send'
        ]) !!}

        <div class="form-group @if ($errors->has('name'))  has-error @endif ">
            {!! Form::label('name', 'Name', ['class'=>'control-label ']) !!}
            {!! Form::text('name', null, [
                'class'=>'form-control', 
                'placeholder' => 'Name'
            ] ) !!} 
            
            @if ($errors->has('name'))
                <span class="error">{{ $errors->first('name') }}</span>
            @endif  
        </div>
        
        
        <div class="form-group @if ($errors->has('email'))  has-error @endif ">
            {!! Form::label('email', 'Email Address', ['class'=>'control-label ']) !!}
            {!! Form::email('email', null, [
                'class'=>'form-control', 
                'placeholder' => 'Email Address'
            ] ) !!} 
            
            @if ($errors->has('email'))
                <span class="error">{{ $errors->first('email') }}</span>
            @endif  
        </div>
        
        
        <div class="form-group @if ($errors->has('subject'))  has-error @endif ">
            {!! Form::label('subject', 'Subject', ['class'=>'control-label ']) !!}
    
            {!! Form::text('subject', null, [
                'class'=>'form-control', 
                'placeholder' => 'Subject'
            ] ) !!} 
            
            @if ($errors->has('subject'))
                <span class="error">{{ $errors->first('subject') }}</span>
            @endif  
        </div>
        
        <div class="form-group @if ($errors->has('message'))  has-error @endif ">
            {!! Form::label('message', 'Message', ['class'=>'control-label ']) !!}
        
                {!! Form::textarea('message', null, [
                    'class'=>'form-control', 
                    'placeholder' => 'Please provide as much information as possible'
                ] ) !!} 
                
                @if ($errors->has('message'))
                    <span class="error">{{ $errors->first('message') }}</span>
                @endif  
        </div>

        <div class="form-group">
            {!! Recaptcha::render() !!}
        </div>
        
        <div class="form-group">
                <button class="btn btn-primary btn-lg">Send</button> 
        </div>
        
        {!! Form::close() !!}
        </div></div>
        </div>
    </div>
</div>
@endsection


