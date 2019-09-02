@extends('layouts.app')

@section('content')
<div class="col-sm-2">

</div>

<div class="col-md-8" >
    <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
            <a class="nav-link active" id="compose-tab" data-toggle="tab" href="#compose" role="tab" aria-controls="compose" aria-selected="true">Contact Us</a>
        </li>
    </ul>
    <div class="tab-content profile-tab" id="myTabContent">
        <div class="tab-pane fade show active" id="compose" role="tabpanel" aria-labelledby="compose-tab">
            {!! Form::open(['url' => 'contact-us/submit']) !!}
                <div class="form-group">
                    {{Form::label('email', 'Email')}}
                    {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'Enter your e-mail' ])}}
                </div>
                <div class="form-group">
                    {{Form::label('subject', 'Subject')}}
                    {{Form::text('subject', $value = old("subject") , ['class' => 'form-control', 'placeholder' => 'Enter subject' ])}}
                </div>
                <div class="form-group">
                    {{Form::label('body', 'Massage')}}
                    {{Form::textarea('body', $value = old("body") , ['class' => 'form-control', 'placeholder' => 'Enter message' ])}}
                </div>
                <div>
                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                </div>
            {!! Form::close() !!}
        </div>
       
    </div>
</div>
<div class="col-sm-2">

</div>
@endsection