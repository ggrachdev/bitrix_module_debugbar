<?php

namespace GGrach\BitrixDebugger\Cache;

/**
 * Description of RuntimeCache
 *
 * @author ggrachdev
 */
class RuntimeCache {

    private static $cacheRegister;

    public static function get($key) {
        if (self::has($key))
        {
            return self::getRegister()[$key];
        }
        
        return null;
    }

    public static function has($key) {
        return \array_key_exists($key, self::getRegister());
    }

    public static function set($key, $value) {
        self::$cacheRegister[$key] = $value;
    }

    public static function getRegister() {
        return self::$cacheRegister;
    }


    public static function remove($key) {
        if(self::has($key))
        {
            unset(self::$cacheRegister[$key]);
        }
    }
    
    public static function removeAll()
    {
        self::$cacheRegister = [];
    }
}
