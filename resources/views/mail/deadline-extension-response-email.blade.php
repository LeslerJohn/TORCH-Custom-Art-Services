@extends('layouts.mail')

@section('content')
<h1>Hello {{ $artistName }},</h1>
<p>{{ $clientName }} has responded to your deadline extension request.</p>
<p><strong>Response:</strong> {{ $response }}</p>
<p>Thank you for your dedication to Torch!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
