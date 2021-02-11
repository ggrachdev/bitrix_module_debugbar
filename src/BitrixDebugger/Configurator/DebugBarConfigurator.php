<?php

namespace GGrach\BitrixDebugger\Configurator;

/**
 * Description of DebugConfigurator
 *
 * @author ggrachdev
 */
class DebuggerConfigurator {

    /**
     * Цветовая схема дебаг-бара
     * 
     * @var string 
     */
    protected $colorTheme = 'dark';
    
    public function getColorTheme(): type {
        return $this->theme;
    }

    public function setColorTheme(string $theme): void {
        $this->theme = $theme;
    }

}
