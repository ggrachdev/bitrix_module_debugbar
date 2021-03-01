<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Configurator\DebuggerConfigurator;
use GGrach\BitrixDebugger\Configurator\DebugBarConfigurator;

/**
 * Description of Debugger
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
