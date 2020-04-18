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

    public static function getCsrfToken()
    {
        return empty($_SESSION["csrf_token"]) ? null : $_SESSION["csrf_token"];
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
        return array_key_exists($key, $_SESSION)? $_SESSION[$key] : null;
    }

    public static function generateCsrfToken()
    {

        $max_time = 60 * 60 * 24; // 1 day
        $stored_time = self::getCsrfTokenTime();
        $csrf_token  = self::getCsrfToken();

        if ($max_time + $stored_time <= time() || empty($csrf_token)) {
            $token = md5(uniqid(rand(), true));

            $_SESSION["csrf_token"]      = $token;
            $_SESSION["csrf_token_time"] = time();
        }

        return self::getCsrfToken();
    }

    public static function logout()
    {
        unset($_SESSION['is_logged_in']);
        unset($_SESSION['user_id']);
    }
}