@extends('layouts.app')

@section('content')
<div class="col-sm-2">

</div>

<div class="col-md-8">
    <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
            <a class="nav-link active" id="compose-tab" data-toggle="tab" href="#compose" role="tab" aria-controls="compose" aria-selected="true">Compose</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="inbox-tab" data-toggle="tab" href="#inbox" role="tab" aria-controls="inbox" aria-selected="true">Inbox</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="sent-tab" data-toggle="tab" href="#sent" role="tab" aria-controls="sent" aria-selected="true">Sent</a>
        </li>
    </ul>
    <div class="tab-content profile-tab" id="myTabContent">
        <div class="tab-pane fade show active" id="compose" role="tabpanel" aria-labelledby="compose-tab">
            {!! Form::open(['url' => 'contact/submit']) !!}
                <div class="form-group">
                    {{Form::label('receiver', 'Send to')}}
                    {{Form::text('receiver', isset($name) ? $name : null, ['class' => 'form-control', 'placeholder' => 'Enter Username' ])}}
                </div>
                <div class="form-group">
                    {{Form::label('subject', 'Subject')}}
                    {{Form::text('subject', $value = old("subject") , ['class' => 'form-control', 'placeholder' => 'Enter subject' ])}}
                </div>
                <div class="form-group">
                    {{Form::label('message', 'Massage')}}
                    {{Form::textarea('message', $value = old("message") , ['class' => 'form-control', 'placeholder' => 'Enter message' ])}}
                </div>
                <div>
                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                </div>
            {!! Form::close() !!}
        </div>
        <div class="table-responsive-sm tab-pane fade" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
            <table class="table table-msg" data-form="deleteForm"> 
                <thead class="thead-light">
                    <tr>
                        <th style="width:20%; text-align:center;">Sender</th>
                        <th style="width:40%">Subject</th>
                        <th style="width:20%; text-align:center;">Received</th> 
                        <th style="width:20%; text-align:center;">Action</th>
                    </tr>
                </thead>
                @if($msg_got->count() > 0 )
                    @foreach($msg_got as $inbox)
                    <tr>
                        <td style="text-align:center;"><a href="/profile/{{$inbox->user_id}}">{{$inbox->name}}</a></td>
                        <td>{{$inbox->subject}} 
                            @if($inbox->receiver_mark == 0)
                                <small><i class="btn-small blinking">!!! NEW</i></small>
                            @else
                                <small><i class="btn-small">Already read</i></small>
                            @endif
                        </td>
                        <td>{{(Carbon\Carbon::parse($inbox->message_created))->diffforHumans()}}</td> 
                        <td style="text-align:center">
                            <a href="{{route('message', ['id' => $inbox->id])}}" title="View"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                            @if($inbox->receiver_mark == 0)
                                {!! Form::open(['route' => ['read', $inbox->id], 'method' => 'PUT', 'style' => 'margin-bottom:0 !important; display:inline;']) !!}
                                    <button type="submit" class="btn btn-alert btn-sm" title="Mark as Read"><i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                                {!! Form::close() !!}
                            @else
                                <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick=" document.getElementById('confirm').style.display = 'block'"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                <!-- Hidden confirmation modal -->
                                <div class="modal overlay" id="confirm">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you want to delete this?</p>
                                            </div>
                                            <div class="modal-footer">
                                                {!! Form::open(['route' => ['delete', $inbox->id], 'method' => 'DELETE', 'style' => 'margin-bottom:0 !important; display:inline']) !!}
                                                    <button type="submit" class="btn btn-sm btn-primary" id="delete-btn">Delete</button>
                                                {!! Form::close() !!}                
                                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onclick="document.getElementById('confirm').style.display = 'none'">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Hidden modal -->
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No Massage found!</td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="table-responsive-sm tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab">
           <table class="table table-msg">
                <thead class="thead-light">
                    <tr>
                        <th style="width:20%; text-align:center;">Receiver</th>
                        <th style="width:40%">Subject</th>
                        <th style="width:20%; text-align:center;">Sent</th> 
                        <th style="width:20%; text-align:center;">Action</th>
                    </tr> 
                </thead>
                @if($msg_sent->count() > 0 )
                    @foreach($msg_sent as $outbox)
                    <tr>
                        <td style="text-align:center;"><a href="/profile/{{$outbox->user_id}}">{{$outbox->name}}</a></td>
                        <td>{{$outbox->subject}}</td>
                        <td>{{(Carbon\Carbon::parse($outbox->message_created))->diffforHumans()}}</td> 
                        <td style="text-align:center">
                            <a href="{{route('message', ['id' => $outbox->id])}}" title="View"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                            <a href="{{route('delete', ['id' => $outbox->id])}}" title="Delete"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No data found!</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>
<div class="col-sm-2">

</div>
@endsection