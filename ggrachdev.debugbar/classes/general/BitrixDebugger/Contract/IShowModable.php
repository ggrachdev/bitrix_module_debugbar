<?php

namespace GGrach\BitrixDebugger\Contract;

/**
 * Имеет режимы отображения
 * 
 * @author ggrachdev
 */
interface IShowModable {

    /**
     * Получить режимы отображения установленные
     * 
     * @return array Режимы отображения
     */
    public function getShowModes(): array;
    
    /**
     * Установить режимы отображения
     * 
     * @param array $showModes
     * @return bool Результат
     */
    public function setShowModes(array $showModes): bool;
    
    /**
     * Установить один режим отображения
     * 
     * @param string $showMode
     * @return bool Результат
     */
    public function setShowMode(string $showMode): bool;
}
