<?php

namespace GGrach\BitrixDebugger\Contract;

/**
 * Имеет режимы отображения
 * 
 * @author ggrachdev
 */
interface ShowModableContract {

    /**
     * Получить режимы отображения установленные
     * 
     * @return array Режимы отображения
     */
    public function getShowModes(): array;

    /**
     * Получить допустимые режимы отображения
     * 
     * @return array Режимы отображения
     */
    public function getShowModesEnum(): array;
    
    /**
     * Установить режимы отображения
     * 
     * @param array $showModes
     * @return bool Результат
     */
    public function setShowModes(array $showModes): bool;
}
