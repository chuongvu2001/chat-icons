# Intro
This is starter project for my blog about Realtime chat app with Laravel, VueJS, SocketIO, Redis, here: https://viblo.asia/p/viet-ung-dung-chat-trong-laravel-su-dung-private-va-presence-channel-OeVKBRLrKkW

My complete full-features app is on `master` branch
# Demo
You can try my demo here: https://realtime-chat.jamesisme.com/

### Config and run install
1. php 7.x
2. composer install
3. php artisan key:generate
4. php artisan migrate --seed
5. npm install
6. npm install --save laravel-echo
7. laravel-echo-server init
   - yes
   - 6001
   - redis
   - http://localhost:8000
   - http
   - yes
   - No
   - laravel-echo-server.json
