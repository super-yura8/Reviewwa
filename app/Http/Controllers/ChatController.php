<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Message;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        Message::dispatch($request->input('body'));
    }
}
