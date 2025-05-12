<?php
namespace Helpers; // Si vous utilisez des namespaces

class Session {
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function exists($key) {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function delete($key) {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy() {
        self::start();
        session_destroy();
    }
}
?>