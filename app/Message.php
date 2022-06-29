<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Chatroom;
use Illuminate\Support\Facades\Config;

class Message extends Model
{
    protected $fillable = ['room', 'sender', 'content'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender');
    }

    public function room()
    {
        return $this->belongsTo(Chatroom::class, 'room');
    }

    public static function convertContent($content)
    {
        $array = explode(" ", $content);
        $string = implode(",", $array);
        $result = [];
        foreach ($array as $a => $item) {
            if (str_starts_with($item, ':')) {
                array_push($result, $item);
            }
        }

        return $result;
    }

    public static function convertIcon($arr)
    {
        $array = Config::get('iconlist');
        $keys = array_keys($array);

        $string = implode(",", $keys);

        $data = explode(":", end($arr));

        $icons = [];

        foreach ($array as $k => $item) {
            if (str_starts_with($k, $data[1])) {
                array_push($icons, [$k => $item]);
            }
        }

        return $icons;
    }
}
