@extends('layouts.mail')

@section('content')
<h1>Hello {{ $clientName }},</h1>
<p>Here is the latest update on your order:</p>
<p><strong>Status:</strong> {{ $orderStatus }}</p>
<p><strong>Tracking Details:</strong> {{ $trackingDetails }}</p>
<p>Thank you for your patience and for choosing Torch!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
