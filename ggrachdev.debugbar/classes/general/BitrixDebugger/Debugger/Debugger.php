<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Configurator\DebuggerConfigurator;
use GGrach\BitrixDebugger\Configurator\DebugBarConfigurator;
use GGrach\Filtrator\IFiltrator;
use GGrach\Filtrator\Filtrator;

/**
 * Создание полноценного объекта, который позволит осуществлять все возможные операции через текучий интерфейс
 *
 * @author ggrachdev
 */
class Debugger extends LogFileDebugger {

    public function __construct($debuggerConfigurator = null, $debugBarConfigurator = null, $filtrator = null) {
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

        if ($filtrator === null) {
            $this->setFiltrator(new Filtrator());
        } elseif ($filtrator instanceof IFiltrator) {
            $this->setFiltrator($filtrator);
        }
    }

}
