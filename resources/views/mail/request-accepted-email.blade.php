@extends('layouts.mail')

@section('content')
<h1>Good news, {{ $clientName }}!</h1>
<p>Your service request has been accepted by {{ $artistName }}.</p>
<p><strong>Service Details:</strong> {{ $serviceDetails }}</p>
<p>The artist will contact you soon to discuss further details.</p>
<p>Thank you for choosing Torch!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
