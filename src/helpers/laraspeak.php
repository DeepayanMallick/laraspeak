<?php
use Illuminate\Support\Arr;

if (!function_exists('laraspeak_live')) {
    function laraspeak_live($options)
    {
        $laraspeak__appKey = config('laraspeak.broadcast.pusher.app_key');
        $laraspeak__appName = config('laraspeak.broadcast.app_name');
        $laraspeak__options = config('laraspeak.broadcast.pusher.options');
        if(config('laraspeak.broadcast.driver') === 'laravel-websockets'){
            $laraspeak__options = Arr::only($laraspeak__options, [
                'wsHost', 'wsPort', 'forceTLS', 'disableStats'
            ]);
        }
        $laraspeak__options = json_encode($laraspeak__options);

        $laraspeak_user_channel = isset($options['user']['id']) ? $laraspeak__appName.'-user-'.$options['user']['id'] : '';
        $laraspeak_conversation_channel = isset($options['conversation']['id']) ? $laraspeak__appName.'-conversation-'.$options['conversation']['id'] : '';
        $laraspeak__userChannel['name'] = sha1($laraspeak_user_channel);
        $laraspeak__conversationChannel['name']  = sha1($laraspeak_conversation_channel);
        $laraspeak__userChannel['callback'] = isset($options['user']['callback']) ? $options['user']['callback'] : [];
        $laraspeak__conversationChannel['callback'] = isset($options['conversation']['callback']) ? $options['conversation']['callback'] : [];

        return view('laraspeak::pusherjs', compact('laraspeak__appKey', 'laraspeak__options', 'laraspeak__userChannel', 'laraspeak__conversationChannel'))->render();
    }
}
