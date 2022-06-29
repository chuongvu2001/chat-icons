<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Events\MessagePosted;
use Illuminate\Support\Facades\Config;


class MessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = Message::with(['sender'])->where('room', $request->query('room', ''))->orderBy('created_at', 'asc')->get();
        return $messages;
    }

    public function store(Request $request)
    {
        $emoji = new \MarufMax\Emoticon\Emoticon();

        $message = new Message();
        $message->room = $request->input('room', '');
        $message->sender = Auth::user()->id;
        $message->content = $request->input('content', '')
//            . $emoji->emojify('I like :heart:')
        ;

        $message->save();
        broadcast(new MessagePosted($message->load('sender')))->toOthers();

        return response()->json(['message' => $message->load('sender')]);
    }

    public function checkIcon(Request $request)
    {

        if (strpos($request->content, ':') === false) {
            echo 'false';
            die;
        }

        $contentText = Message::convertContent($request->content);

        $arrayIcon = Message::convertIcon($contentText);
        $array = Arr::collapse($arrayIcon);

        return $array;
    }
}
