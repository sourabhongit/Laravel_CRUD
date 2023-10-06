<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $details = [
            'name' => 'Example',
        ];
        dispatch(new SendEmailJob($details));
    }
}
