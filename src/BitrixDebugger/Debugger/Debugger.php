<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Configurator\DebuggerConfigurator;
use GGrach\BitrixDebugger\Configurator\DebugBarConfigurator;
use GGrach\BitrixDebugger\Contract\ShowModableContract;
use GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator;
use GGrach\BitrixDebugger\Debugger\DebuggerShowModable;

/**
 * Description of Debugger
 *
 * @author ggrachdev
 * @version 0.01
 */
class Debugger extends DebuggerShowModable implements ShowModableContract {

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

    public function warning(...$item) {
        $this->noticeRaw('warning', $item);
    }

    public function success(...$item) {
        $this->noticeRaw('success', $item);
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

    protected function noticeRaw(string $type, $items) {

        if (ShowModeDebuggerValidator::needShowInDebugBar($this)) {
            $this->log = array_merge($this->log, $items);
        }

        if (ShowModeDebuggerValidator::needShowInCode($this)) {
            
        }

        if (ShowModeDebuggerValidator::needWriteInLog($this)) {
            $logFile = $this->configuratorDebugger->getLogPath($type);
            
            if ($logFile) {
                
            }
        }
    }

}
