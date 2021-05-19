<?php

namespace GGrach\BitrixDebugger\Configurator;

/**
 * Description of DebugConfigurator
 *
 * @author ggrachdev
 */
class DebugBarConfigurator {

    /**
     * Цветовая схема дебаг-бара
     * 
     * @var string 
     */
    protected $colorTheme = 'light';

    public function getColorTheme(): string {
        return $this->colorTheme;
    }

    public function setColorTheme(string $theme): void {
        $this->colorTheme = $theme;
    }

}
