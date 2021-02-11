<?php

namespace GGrach\BitrixDebugger\Contract;

/**
 * Для записи данных
 * 
 * @author ggrachdev
 */
interface WritableContract {

    /**
     * Запись данных в ресурс
     * 
     * @param type $data
     * @param resource $resource
     * @param string $delimeter
     */
    public static function write($data, resource $resource, string $delimeter): bool;

    /**
     * Очистка данных
     * 
     * @param resource $resource
     */
    public static function clear(resource $resource): bool;
}
