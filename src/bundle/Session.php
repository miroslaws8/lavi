<?php

namespace bundle;

class Session
{
    private function __construct() {}

    public static function init()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function isSessionValid()
    {

        $isLoggedIn  = self::getIsLoggedIn();
        $userId      = self::getUserId();

        if (empty($isLoggedIn) || empty($userId)) {
            return false;
        }

        return true;
    }

    public static function getToken()
    {
        return $_SESSION['token'];
    }

    public static function doLogin()
    {
        $_SESSION['is_logged_in'] = true;

        return $_SESSION['is_logged_in'];
    }

    public static function getIsLoggedIn()
    {
        return empty($_SESSION["is_logged_in"])
        || !is_bool($_SESSION["is_logged_in"]) ? false : $_SESSION["is_logged_in"];
    }

    public static function getUserID()
    {
        return empty($_SESSION["user_id"]) ? null : (int) $_SESSION["user_id"];
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function setError($key, $value)
    {
        $_SESSION['errors'][$key] = $value;
    }

    public static function get($key)
    {
        $isExist = array_key_exists($key, $_SESSION);

        if ($isExist && is_array($_SESSION[$key])) {
            $param = (object) $_SESSION[$key];

            return $param;
        }

        return $isExist? $_SESSION[$key] : null;
    }

    public static function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['is_logged_in']);
    }
}