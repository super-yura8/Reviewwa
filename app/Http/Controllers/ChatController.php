<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessagesRequest;
use App\Events\Message;

class ChatController extends Controller
{
    public function sendMessage(MessagesRequest $request)
    {
        Message::dispatch($request->input('body'));
    }
}
