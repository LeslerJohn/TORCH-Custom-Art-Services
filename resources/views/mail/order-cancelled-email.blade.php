@extends('layouts.mail')

@section('content')
<h1>Hello {{ $clientName }},</h1>
<p>Your order has been successfully cancelled.</p>
<p><strong>Order Details:</strong> {{ $orderDetails }}</p>
<p>If you have any questions, feel free to contact us.</p>
<p>Thank you for choosing Torch!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
