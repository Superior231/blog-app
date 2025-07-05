<?php

namespace App\Helpers;

class ReadTimeHelper
{
    public static function estimate(string $content, int $wpm = 230): string
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / $wpm);
        return "{$minutes} min read";
    }
}
