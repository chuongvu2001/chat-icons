<?php

namespace Emoji\Detect;

define('LONGEST_EMOJI', 8);
if (!function_exists('detect_emoji')) {
    function detect_emoji($string): array
    {
        // Find all the emoji in the input string

        $prevencoding = mb_internal_encoding();
        mb_internal_encoding('UTF-8');

        $data = array();

        static $map;
        if (!isset($map))
            $map = _load_map();

        static $regexp;
        if (!isset($regexp))
            $regexp = _load_regexp();

        if (preg_match_all($regexp, $string, $matches, PREG_OFFSET_CAPTURE)) {
            $emojisLength = 0;
            $lastMbOffset = 0;
            foreach ($matches[0] as $match) {
                $ch = $match[0];
                $offset = $match[1] - $emojisLength;
                $mbOffset = mb_strpos($string, $ch, $lastMbOffset);
                $mbLength = mb_strlen($ch);
                $lastMbOffset = $offset + $mbLength;
                $emojisLength += (strlen($ch) - 1);
                $points = array();
                for ($i = 0; $i < $mbLength; $i++) {
                    $points[] = strtoupper(dechex(uniord(mb_substr($ch, $i, 1))));
                }

                $hexStr = implode('-', $points);

                if (array_key_exists($hexStr, $map)) {
                    $short_name = $map[$hexStr];
                } else {
                    $short_name = null;
                }

                $skin_tone = null;
                $skin_tones = array(
                    '1F3FB' => 'skin-tone-2',
                    '1F3FC' => 'skin-tone-3',
                    '1F3FD' => 'skin-tone-4',
                    '1F3FE' => 'skin-tone-5',
                    '1F3FF' => 'skin-tone-6',
                );
                foreach ($points as $pt) {
                    if (array_key_exists($pt, $skin_tones))
                        $skin_tone = $skin_tones[$pt];
                }

                $data[] = array(
                    'emoji' => $ch,
                    'short_name' => $short_name,
                    'num_points' => mb_strlen($ch),
                    'points_hex' => $points,
                    'hex_str' => $hexStr,
                    'skin_tone' => $skin_tone,
                    'offset' => $offset,
                    'mb_offset' => $mbOffset,
                    'mb_length' => $mbLength
                );
            }
        }

        if ($prevencoding)
            mb_internal_encoding($prevencoding);

        return $data;
    }
}
if (!function_exists('get_first_emoji')) {
    function get_first_emoji($string)
    {
        $emojis = detect_emoji($string);
        if (count($emojis))
            return $emojis[0];
        else
            return null;
    }
}
if (!function_exists('replace_emoji')) {
    function replace_emoji($string, $prefix = '', $suffix = '')
    {
        while ($emoji = get_first_emoji($string)) {
            $offset = $emoji['mb_offset'];
            $length = $emoji['mb_length'];
            $strlen = mb_strlen($string, 'UTF-8');
            $start = mb_substr($string, 0, $offset, 'UTF-8');
            $end = mb_substr($string, $offset + $length, $strlen - ($offset + $length), 'UTF-8');
            $string = $start . $prefix . $emoji['short_name'] . $suffix . $end;
        }
        return $string;
    }
}
if (!function_exists('uniord')) {
    function uniord($c)
    {
        $ord0 = ord($c[0]);
        if ($ord0 >= 0 && $ord0 <= 127) return $ord0;
        $ord1 = ord($c[1]);
        if ($ord0 >= 192 && $ord0 <= 223) return ($ord0 - 192) * 64 + ($ord1 - 128);
        $ord2 = ord($c[2]);
        if ($ord0 >= 224 && $ord0 <= 239) return ($ord0 - 224) * 4096 + ($ord1 - 128) * 64 + ($ord2 - 128);
        $ord3 = ord($c[3]);
        if ($ord0 >= 240 && $ord0 <= 247) return ($ord0 - 240) * 262144 + ($ord1 - 128) * 4096 + ($ord2 - 128) * 64 + ($ord3 - 128);
        return false;
    }
}
