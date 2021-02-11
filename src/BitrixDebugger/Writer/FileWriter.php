<?php

use GGrach\BitrixDebugger\Contract\WritableContract;

namespace GGrach\BitrixDebugger\Writer;

/**
 * Description of FileWriter
 *
 * @author ggrachdev
 */
class FileWriter implements WritableContract {

    /**
     * Запись данных в ресурс
     * 
     * @param type $data
     * @param resource $resource
     * @param string $delimeter
     */
    public static function write($data, resource $resource, string $delimeter): bool {
        $result = false;

        return $result;
    }

    /**
     * Очистка данных
     * 
     * @param resource $resource
     */
    public static function clear(resource $resource): bool {
        $result = false;

        return $result;
    }

}
