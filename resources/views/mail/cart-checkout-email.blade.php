@extends('layouts.mail')

@section('content')
<h1>Thank you for your purchase, {{ $clientName }}!</h1>
<p>We are excited to inform you that your purchase has been successfully processed.</p>
<p><strong>Artwork Details:</strong> {{ $artworkDetails }}</p>
<p><strong>Total Amount:</strong> {{ number_format($totalAmount, 2) }}</p>
<p>We hope you enjoy your new artwork!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
