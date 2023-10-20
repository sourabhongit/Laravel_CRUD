<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class SendMailableController extends Controller
{
	public function mailSend()
	{
		$name = "Example Name";
		$receiver = 'get.sourabhdas@gmail.com';
		Mail::to($receiver)->send(new SendMailable($name));
	}
}
