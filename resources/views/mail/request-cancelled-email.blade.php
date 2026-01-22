@extends('layouts.mail')

@section('content')
<h1>Hello {{ $clientName }},</h1>
<p>Your service request has been successfully canceled.</p>
<p><strong>Request Details:</strong> {{ $requestDetails }}</p>
<p>If you have any questions, feel free to contact us.</p>
<p>Thank you for choosing Torch!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
