<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Mai Trung Duc">
    <meta name="description" content="Realtime chat app using Laravel, VueJS, Redis, Laravel Echo, SocketIO">
    <meta name="keywords" content="Realtime chat app, Laravel, VueJS, Laravel Echo, Redis, SocketIO">

    <title>Realtime Chat | Laravel, VueJS, Redis, Laravel Echo, SocketIO</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font_awesome/all.min.css') }}">
    <link rel="icon favicon" href="{{ asset('images/favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('lib/css/emoji.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>
<div id="app" class="h-100"></div>

<script>window.__app__ = @json($data)</script>
<script src="http://localhost:6001/socket.io/socket.io.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<!-- ** Don't forget to Add jQuery here ** -->
<script src="{{asset('lib/js/config.js')}}"></script>
<script src="{{asset('lib/js/util.js')}}"></script>
<script src="{{asset('lib/js/jquery.emojiarea.js')}}"></script>
<script src="{{asset('lib/js/emoji-picker.js')}}"></script>
{{--<script>--}}
{{--    $(function() {--}}
{{--        // Initializes and creates emoji set from sprite sheet--}}
{{--        window.emojiPicker = new EmojiPicker({--}}
{{--            emojiable_selector: '[data-emojiable=true]',--}}
{{--            assetsPath: '../lib/img/',--}}
{{--            popupButtonClasses: 'fa fa-smile-o'--}}
{{--        });--}}
{{--        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields--}}
{{--        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process--}}
{{--        // It can be called as many times as necessary; previously converted input fields will not be converted again--}}
{{--        window.emojiPicker.discover();--}}
{{--    });--}}
{{--</script>--}}
{{--<script>--}}
{{--    // Google Analytics--}}
{{--    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){--}}
{{--        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),--}}
{{--        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)--}}
{{--    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');--}}

{{--    ga('create', 'UA-49610253-3', 'auto');--}}
{{--    ga('send', 'pageview');--}}
{{--</script>--}}
</body>
</html>
