<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Configurator\DebuggerConfigurator;
use GGrach\BitrixDebugger\Configurator\DebugBarConfigurator;
use GGrach\BitrixDebugger\Contract\ShowModableContract;


/**
 * Description of Debugger
 *
 * @author ggrachdev
 * @version 0.01
 */
class Debugger implements ShowModableContract {

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
     * everywhere - и в дебаг-баре и в коде и залогировать
     * code - в коде
     * debug_bar - в дебаг-баре
     * log - залогировать
     * no - не показывать нигде
     * 
     * @var array
     */
    protected $showModes = ['everywhere'];
    
    public function getShowModes()
    {
        return $this->showModes;
    }

    public function options($options) {
        
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

    public function noticeRaw(string $type, $items) {

        if ($this->needShowInDebugBar()) {
            $this->log[] = $items;
        }
    }

    public function getShowModesEnum(): array {
        // @todo
        return [];
    }

    public function setShowModes(array $showModes): bool {
        // @todo
        return true;
    }

}
