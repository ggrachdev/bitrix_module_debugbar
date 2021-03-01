<?php

namespace GGrach\Writer;

use GGrach\Writer\Contract\WritableContract;

/**
 * Description of FileWriter
 *
 * @author ggrachdev
 */
class FileWriter implements WritableContract {

    /**
     * Запись данных в ресурс
     * 
     * @param type $text
     * @param resource $resource
     * @param string $delimeter
     */
    public static function write(string $text, $resource, string $delimeter): bool {
        return fwrite($resource, $text . $delimeter) !== false;
    }

    /**
     * Очистка данных
     * 
     * @param resource $resource
     */
    public static function clear($resource): bool {

        if (\is_resource($resource)) {
            $arMetaData = \stream_get_meta_data($resource);
            if ($arMetaData['uri']) {
                return \file_put_contents($arMetaData['uri'], '');
            }
        }

        return false;
    }

}
