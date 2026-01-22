@extends('layouts.mail')

@section('content')
    <h1 style="color: #4CAF50;">Welcome to Torch, {{ $name }}!</h1>
    <p>Thank you for joining Torch! We are thrilled to have you as a valued client.</p>
    <p>Explore our platform and connect with talented artists to bring your creative ideas to life.</p>
    <p>If you have any questions, feel free to reach out to our support team.</p>
    <p style="margin-top: 20px;">Best regards,<br><strong>The Torch Team</strong></p>
@endsection
