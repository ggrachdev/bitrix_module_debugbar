<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Cache\RuntimeCache;
use GGrach\Writer\FileWriter;

/**
 * Ответственность: логирование в файлы
 *
 * @author ggrachdev
 */
class LogFileDebugger extends NoticeDebugger {

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
        $this->logRaw('notice', $item);
        $this->resetFilter();
        return $this;
    }

    public function errorLog(...$item) {
        $this->logRaw('error', $item);
        $this->resetFilter();
        return $this;
    }

    public function warningLog(...$item) {
        $this->logRaw('warning', $item);
        $this->resetFilter();
        return $this;
    }

    public function successLog(...$item) {
        $this->logRaw('success', $item);
        $this->resetFilter();
        return $this;
    }

}
