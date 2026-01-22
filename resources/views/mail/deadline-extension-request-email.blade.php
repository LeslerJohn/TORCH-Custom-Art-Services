@extends('layouts.mail')

@section('content')
<h1>Hello {{ $clientName }},</h1>
<p>{{ $artistName }} has requested a deadline extension for your commission.</p>
<p><strong>Reason:</strong> {{ $reason }}</p>
<p>Please review the request and respond at your earliest convenience.</p>
<p>Thank you for choosing Torch!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
