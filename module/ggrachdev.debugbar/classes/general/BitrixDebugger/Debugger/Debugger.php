<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Configurator\DebuggerConfigurator;
use GGrach\BitrixDebugger\Configurator\DebugBarConfigurator;

/**
 * Ответственность: создание полноценного объекта, который позволит осуществлять все возможные операции через текучий интерфейс
 *
 * @author ggrachdev
 */
class Debugger extends LogFileDebugger {

    public function __construct($debuggerConfigurator = null, $debugBarConfigurator = null) {
        if ($debuggerConfigurator === null) {
            $this->setConfiguratorDebugger(new DebuggerConfigurator());
        } elseif ($debuggerConfigurator instanceof DebuggerConfigurator) {
            $this->setConfiguratorDebugger($debuggerConfigurator);
        }

        if ($debugBarConfigurator === null) {
            $this->setConfiguratorDebugBar(new DebugBarConfigurator());
        } elseif ($debugBarConfigurator instanceof DebugBarConfigurator) {
            $this->setConfiguratorDebugBar($debugBarConfigurator);
        }
    }

}
