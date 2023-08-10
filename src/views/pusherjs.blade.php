<script src="https://js.pusher.com/3.2/pusher.min.js"></script>
<script>

    Pusher.logToConsole = true;
    var pusher = new Pusher('{{$laraspeak__appKey}}', {!! $laraspeak__options !!});

    @if(!empty($laraspeak__userChannel['name']))
    var userChannel = pusher.subscribe('{{$laraspeak__userChannel['name']}}');
    userChannel.bind('laraspeak-send-message', function(data) {
        @foreach($laraspeak__userChannel['callback'] as $callback)
        {!! $callback . '(data);'  !!}
        @endforeach
    });

    @endif

    @if(!empty($laraspeak__conversationChannel['name']))
    var conversationChannel = pusher.subscribe('{{$laraspeak__conversationChannel['name']}}');
    conversationChannel.bind('laraspeak-send-message', function(data) {
        @foreach($laraspeak__conversationChannel['callback'] as $callback)
        {!! $callback . '(data);'  !!}
        @endforeach
    });
    @endif
</script>
