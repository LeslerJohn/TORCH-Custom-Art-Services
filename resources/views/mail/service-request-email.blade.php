@extends('layouts.mail')

@section('content')
<h1>Hello {{ $clientName }},</h1>
<p>Your service artwork request has been successfully submitted.</p>
<p><strong>Service Details:</strong> {{ $serviceDetails }}</p>
<p>We will notify you once the artist responds to your request.</p>
<p>Thank you for choosing Torch!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
