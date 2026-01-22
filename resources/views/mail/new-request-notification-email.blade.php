@extends('layouts.mail')

@section('content')
<h1>Hello {{ $artistName }},</h1>
<p>You have received a new service request.</p>
<p><strong>Request Details:</strong> {{ $requestDetails }}</p>
<p>Please review the request and respond accordingly.</p>
<p>Thank you for being a part of Torch!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
