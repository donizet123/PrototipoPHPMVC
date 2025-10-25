<?php
class Session {
    
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }
    
    public static function delete($key) {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    public static function destroy() {
        self::start();
        session_unset();
        session_destroy();
    }
    
    public static function isLoggedIn() {
        return self::has('user_id') && self::has('user_logged_in');
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }
    
    public static function setFlash($key, $message) {
        self::set('flash_' . $key, $message);
    }
    
    public static function getFlash($key) {
        $message = self::get('flash_' . $key);
        self::delete('flash_' . $key);
        return $message;
    }
}
?>