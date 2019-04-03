@extends('app')

@section('title')
Advertise on PatchChat
@endsection

@section('content')
<div class="section section-padded">
    <div class="container">
<div class="content">
        <h3>Thank you for reaching out!</h3>
        
        <p>Please be assured that we review and appreciate the requests submitted to our team through this form.</p>
            
        {!! Form::open([
            'id'=>'frmContact', 
            'class'=>'form form-vertical',
            'action' => 'ContactController@advertisingSend'
        ]) !!}

        <div class="row"><div class="col-sm-8">

            <div class="form-group @if ($errors->has('company'))  has-error @endif ">
                {!! Form::label('company', 'Company', ['class'=>'control-label sr-only  ']) !!}
        
                {!! Form::text('company', null, [
                    'class'=>'form-control', 
                    'placeholder' => 'Company Name',
                    'required'=>true
                ] ) !!} 
                
                @if ($errors->has('company'))
                    <span class="error">{{ $errors->first('company') }}</span>
                @endif  
            </div>
            
            <div class="form-group @if ($errors->has('brand'))  has-error @endif ">
                {!! Form::label('brand', 'Brand', ['class'=>'control-label sr-only  ']) !!}
        
                {!! Form::text('brand', null, [
                    'class'=>'form-control', 
                    'placeholder' => 'Brand'
                ] ) !!} 
                
                @if ($errors->has('brand'))
                    <span class="error">{{ $errors->first('brand') }}</span>
                @endif  
            </div>
            
            <div class="form-group @if ($errors->has('industry'))  has-error @endif ">
                {!! Form::label('industry', 'Industry', ['class'=>'control-label sr-only  ']) !!}
        
                {!! Form::select('industry', \App\Models\Industry::lists('name','name'), null, [
                    'class'=>'form-control', 
                    'placeholder' => 'Select Industry'
                ] ) !!} 
                
                @if ($errors->has('industry'))
                    <span class="error">{{ $errors->first('industry') }}</span>
                @endif  
            </div>
            
            <div class="form-group @if ($errors->has('name'))  has-error @endif ">
                {!! Form::label('name', 'Name', ['class'=>'control-label sr-only  ']) !!}
                {!! Form::text('name', null, [
                    'class'=>'form-control', 
                    'placeholder' => 'Contact Name',
                    'required' => true
                ] ) !!} 
                
                @if ($errors->has('name'))
                    <span class="error">{{ $errors->first('name') }}</span>
                @endif  
            </div>
            
            
            <div class="form-group @if ($errors->has('email'))  has-error @endif ">
                {!! Form::label('email', 'Email Address', ['class'=>'control-label sr-only  ']) !!}
                {!! Form::email('email', null, [
                    'class'=>'form-control', 
                    'placeholder' => 'Email Address',
                    'required' => true
                ] ) !!} 
                
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif  
            </div>
            
            <div class="form-group @if ($errors->has('budget'))  has-error @endif ">
                {!! Form::label('budget', 'budget', ['class'=>'control-label sr-only  ']) !!}
        
                {!! Form::select('budget', [
                    null => '-- Select Option --',
                    '$0 - 5,000' => '$0 - 5,000',
                    '$5,000 - 25,000' => '$5,000 - 25,000',
                    '$25,000 - 50,000' => '$25,000 - 50,000',
                    '$50,000 - 100,000' => '$50,000 - 100,000',
                    '$100,000+' => '$100,000+'
                ] , null, [
                    'class'=>'form-control', 
                    'placeholder' => 'Select Budget',
                    'required' => true
                ] ) !!} 
                
                @if ($errors->has('budget'))
                    <span class="error">{{ $errors->first('budget') }}</span>
                @endif  
            </div>
            
            <div class="form-group @if ($errors->has('message'))  has-error @endif ">
                {!! Form::label('message', 'Message', ['class'=>'control-label sr-only  ']) !!}
            
                    {!! Form::textarea('message', null, [
                        'class'=>'form-control', 
                        'placeholder' => 'Please provide as much information as possible',
                        'required' => true
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


