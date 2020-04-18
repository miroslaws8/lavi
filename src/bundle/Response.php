<?php

namespace bundle;

class Response
{
    public static function send($content = null)
    {
        self::sendContent($content);
        self::flushBuffer();

        return true;
    }

    private static function flushBuffer()
    {
        flush();
    }

    private static function sendContent($content)
    {
        if (is_array($content)) {
            $content = json_encode($content);
        }

        echo $content;

        return true;
    }
}