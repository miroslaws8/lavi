<?php

namespace bundle;

class Redirector
{
    public static function to($location, $query = ""){

        if(!empty($query)){
            $query = '?' . http_build_query((array)$query, null, '&');
        }

        header("Location: ".$location);
    }

    public static function root($location = ""){
        return self::to("");
    }
}