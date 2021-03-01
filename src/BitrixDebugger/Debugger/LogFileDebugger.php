<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Cache\RuntimeCache;
use GGrach\Writer\FileWriter;

/**
 * Логика за логирование в файлы
 *
 * @author ggrachdev
 */
class LogFileDebugger extends BarDebugger {

    public function logRaw($type, ...$item) {

        if (empty($item)) {
            return;
        }

        $pathLogFile = $this->configuratorDebugger->getLogPath($type);

        if ($pathLogFile) {
            $keyCache = $type . '_log_file_descriptor';

            $fileLogDescriptor = null;

            if (RuntimeCache::has($keyCache)) {
                $fileLogDescriptor = RuntimeCache::get($keyCache);
            } else {
                $fileLogDescriptor = \fopen($pathLogFile, 'a+');
                RuntimeCache::set($keyCache, $fileLogDescriptor);
            }

            if ($fileLogDescriptor) {
                foreach ($item as $logItem) {
                    // @todo возможность вывести через var_export
                    FileWriter::write(
                        print_r($logItem, true),
                        $fileLogDescriptor,
                        $this->configuratorDebugger->getLogChunkDelimeter()
                    );
                }
            }
        }

        return $this;
    }

    public function noticeLog(...$item) {
        return $this->logRaw('notice', $item);
    }

    public function errorLog(...$item) {
        return $this->logRaw('error', $item);
    }

    public function warningLog(...$item) {
        return $this->logRaw('warning', $item);
    }

    public function successLog(...$item) {
        return $this->logRaw('success', $item);
    }

}
