@extends('layouts.mail')

@section('content')
<h1>Hello {{ $clientName }},</h1>
<p>Your order return request has been successfully sent.</p>
<p><strong>Order Details:</strong> {{ $orderDetails }}</p>
<p>Please wait for the approval of the admin.</p>
<p>If you have any questions, feel free to contact us.</p>
<p>Thank you for choosing Torch!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
