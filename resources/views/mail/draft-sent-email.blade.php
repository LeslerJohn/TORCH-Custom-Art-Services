@extends('layouts.mail')

@section('content')
<h1>Hello {{ $clientName }},</h1>
<p>The artist has sent a draft for your review.</p>
<p><strong>Draft Details:</strong> {{ $draftDetails }}</p>
<p>Please review the draft and provide your feedback.</p>
<p>Thank you for choosing Torch!</p>
<p>Best regards,<br>The Torch Team</p>
@endsection
