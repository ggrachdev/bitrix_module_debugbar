<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Configurator\DebuggerConfigurator;
use GGrach\BitrixDebugger\Configurator\DebugBarConfigurator;
use GGrach\BitrixDebugger\Contract\ShowModableContract;
use GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator;
use GGrach\BitrixDebugger\Debugger\DebuggerShowModable;
use GGrach\BitrixDebugger\Cache\RuntimeCache;
use GGrach\Writer\FileWriter;

/**
 * Description of Debugger
 *
 * @author ggrachdev
 * @version 0.01
 */
class Debugger extends DebuggerShowModable {

    /**
     *
     * @var DebuggerConfigurator 
     */
    protected $configuratorDebugger;

    /**
     *
     * @var DebugBarConfigurator 
     */
    protected $configuratorDebugBar;

    /**
     * Лог
     * 
     * @var array
     */
    protected $log = [];

    /**
     * a - показывать только для администратора
     * d - показывать только в дебаг-баре
     * 
     * @var string
     */
    protected $options = 'ad';

    public function __construct($debuggerConfigurator = null, $debugBarConfigurator = null) {
        if ($debuggerConfigurator === null) {
            $this->configuratorDebugger = new DebuggerConfigurator();
        } elseif ($debuggerConfigurator instanceof DebuggerConfigurator) {
            $this->configuratorDebugger = $debuggerConfigurator;
        }

        if ($debugBarConfigurator === null) {
            $this->configuratorDebugBar = new DebugBarConfigurator();
        } elseif ($debugBarConfigurator instanceof DebugBarConfigurator) {
            $this->configuratorDebugBar = $debugBarConfigurator;
        }
    }

    public function options(array $options) {
        $this->options = $options;
    }

    public function notice(...$item) {
        $this->noticeRaw('notice', $item);
    }

    public function error(...$item) {
        $this->noticeRaw('error', $item);
    }

    public function warning(...$item) {
        $this->noticeRaw('warning', $item);
    }

    public function success(...$item) {
        $this->noticeRaw('success', $item);
    }

    public function noticeLog(...$item) {
        $this->logRaw('notice', $item);
    }

    public function errorLog(...$item) {
        $this->logRaw('error', $item);
    }

    public function warningLog(...$item) {
        $this->logRaw('warning', $item);
    }

    public function successLog(...$item) {
        $this->logRaw('success', $item);
    }

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
                    // @todo возможность вывести через var_dump, var_export
                    FileWriter::write(
                        print_r($logItem, true),
                        $fileLogDescriptor,
                        $this->configuratorDebugger->getLogChunkDelimeter()
                    );
                }
            }
        }
    }

    public function getLog(): array {
        return $this->log;
    }

    /**
     * Кастомизированное уведомление
     * 
     * @param type $typeNotice
     * @param type $item
     */
    public function debug($typeNotice, ...$item) {
        $this->noticeRaw($typeNotice, $item);
    }

    protected function noticeRaw(string $type, $arLogItems) {

        if (ShowModeDebuggerValidator::needShowInDebugBar($this)) {
            $this->log = array_merge($this->log, $arLogItems);
        }

        if (ShowModeDebuggerValidator::needShowInCode($this)) {
            
        }
    }

}
