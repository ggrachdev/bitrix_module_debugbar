<?php

use GGrach\BitrixDebugger\Configurator\DebuggerConfigurator;
use GGrach\BitrixDebugger\Configurator\DebugBarConfigurator;

namespace GGrach\BitrixDebugger\Debugger;

/**
 * Description of Debugger
 *
 * @author ggrachdev
 * @version 0.01
 */
class Debugger {

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

    /**
     *
     * @var DebuggerConfigurator 
     */
    private $configuratorDebugger;

    /**
     *
     * @var DebugBarConfigurator 
     */
    private $configuratorDebugBar;

    /**
     * Лог
     * 
     * @var array
     */
    private $log = [];

    /**
     * a - показывать только для администратора
     * d - показывать только в дебаг-баре
     * 
     * @var string
     */
    private $options = 'ad';

    /**
     * Где показывать
     * 
     * everywhere - и в дебаг-баре и в коде
     * code - в коде
     * debug_bar - в дебаг-баре
     * no - не показывать нигде
     * 
     * @var string
     */
    private $showMode = 'everywhere';

    public function options($options) {
        
    }

    public function notice(...$item) {
        self::rawNotice('notice', ...$item);
    }

    public function warning(...$item) {
        self::rawNotice('warning', ...$item);
    }

    public function success(...$item) {
        self::rawNotice('success', ...$item);
    }

    public function rawNotice(string $type, ...$item) {
        
    }

}
