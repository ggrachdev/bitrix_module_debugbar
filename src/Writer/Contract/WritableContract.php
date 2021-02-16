<?php

namespace GGrach\Writer\Contract;

/**
 * Для записи данных
 * 
 * @author ggrachdev
 */
interface WritableContract {

    /**
     * Запись данных в ресурс
     * 
     * @param string $text
     * @param resource $resource
     * @param string $delimeter
     */
    public static function write(string $text, $resource, string $delimeter): bool;

    /**
     * Очистка данных
     * 
     * @param resource $resource
     */
    public static function clear($resource): bool;
}
