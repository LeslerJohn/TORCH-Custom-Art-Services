<?php

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('send-welcome-mail', function () {
    Mail::to('leslerjohngantalao@gmail.com')->send(new WelcomeMail("Lesler John"));
    
    // Also, you can use specific mailer if your default mailer is not "mailtrap" but you want to use it for welcome mails
    // Mail::mailer('mailtrap')->to('testreceiver@gmail.com')->send(new WelcomeMail("Jon"));
})->purpose('Send welcome mail');