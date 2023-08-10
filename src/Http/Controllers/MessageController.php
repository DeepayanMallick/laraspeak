<?php

namespace Deepayan\LaraSpeak\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Deepayan\LaraSpeak\Facades\LaraSpeak;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class MessageController extends Controller
{
    protected $authUser;
    public function __construct()
    {
        $this->middleware('auth');
        LaraSpeak::setAuthUserId(2);

        View::composer('laraspeak::partials.peoplelist', function($view) {
            $threads = LaraSpeak::threads();
            $view->with(compact('threads'));
        });
    }

    public function chatHistory($id)
    {
        $conversations = LaraSpeak::getMessagesByUserId($id, 0, 50);
        $user = '';
        $messages = [];
        if(!$conversations) {
            $user = User::find($id);
        } else {
            $user = $conversations->withUser;
            $messages = $conversations->messages;
        }

        if (count($messages) > 0) {
            $messages = $messages->sortBy('id');
        }
        $threads = LaraSpeak::threads();
        return view('laraspeak::messages.conversations', compact('messages', 'user','threads'));
    }

    public function ajaxSendMessage(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'message-data'=>'required',
                '_id'=>'required'
            ];

            $this->validate($request, $rules);

            $body = $request->input('message-data');
            $userId = $request->input('_id');

            if ($message = LaraSpeak::sendMessageByUserId($userId, $body)) {
                $html = view('laraspeak::ajax.newMessageHtml', compact('message'))->render();
                return response()->json(['status'=>'success', 'html'=>$html], 200);
            }
        }
    }

    public function ajaxDeleteMessage(Request $request, $id)
    {
        if ($request->ajax()) {
            if(LaraSpeak::deleteMessage($id)) {
                return response()->json(['status'=>'success'], 200);
            }

            return response()->json(['status'=>'errors', 'msg'=>'something went wrong'], 401);
        }
    }
}