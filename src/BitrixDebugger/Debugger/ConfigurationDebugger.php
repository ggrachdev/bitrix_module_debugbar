<?php

namespace GGrach\BitrixDebugger\Debugger;

/**
 * Ответвтенность: за установку конфигураций для дебагера
 *
 * @author ggrachdev
 */
class ConfigurationDebugger {

    /**
     * @var DebuggerConfigurator 
     */
    protected $configuratorDebugger;

    /**
     * @var DebugBarConfigurator 
     */
    protected $configuratorDebugBar;

    public function getConfiguratorDebugger(): DebuggerConfigurator {
        return $this->configuratorDebugger;
    }

    public function getConfiguratorDebugBar(): DebugBarConfigurator {
        return $this->configuratorDebugBar;
    }

    public function setConfiguratorDebugger(DebuggerConfigurator $configuratorDebugger): void {
        $this->configuratorDebugger = $configuratorDebugger;
    }

    public function setConfiguratorDebugBar(DebugBarConfigurator $configuratorDebugBar): void {
        $this->configuratorDebugBar = $configuratorDebugBar;
    }

}
