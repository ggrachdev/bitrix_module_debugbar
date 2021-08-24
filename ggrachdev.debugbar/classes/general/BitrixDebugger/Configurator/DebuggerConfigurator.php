<?php

namespace GGrach\BitrixDebugger\Configurator;

/**
 * Description of DebugConfigurator
 *
 * @author ggrachdev
 */
class DebuggerConfigurator {

    /**
     * Путь до лог файлов разного уровня
     * 
     * @var string
     */
    protected $logPaths = [
        'error' => null,
        'warning' => null,
        'success' => null,
        'notice' => null
    ];

    /**
     * Разделитель между записями в лог-файле
     * 
     * @var string
     */
    protected $logChunkDelimeter = "\n======\n";
    
    public const SHOW_MODE_IN_CODE = 'code';
    public const SHOW_MODE_IN_DEBUG_BAR = 'debug_bar';

    /**
     * Текущие режимы отображения
     * 
     * code - в коде
     * debug_bar - в дебаг-баре
     * 
     * @var array
     */
    protected $showModes = [self::SHOW_MODE_IN_CODE, self::SHOW_MODE_IN_DEBUG_BAR];

    public function getShowModes(): array {
        return $this->showModes;
    }

    public function notShowDebugPanel() {
        $nowModes = $this->getShowModes();
        if (\in_array(self::SHOW_MODE_IN_DEBUG_BAR, $nowModes)) {
            unset($nowModes[\array_search(self::SHOW_MODE_IN_DEBUG_BAR, $nowModes)]);
            $this->setShowModes(\array_unique($nowModes));
        }
        return $this;
    }

    public function notShowDebugInCode() {
        $nowModes = $this->getShowModes();
        if (\in_array(self::SHOW_MODE_IN_CODE, $nowModes)) {
            unset($nowModes[\array_search(self::SHOW_MODE_IN_CODE, $nowModes)]);
            $this->setShowModes(\array_unique($nowModes));
        }
        return $this;
    }

    public function showDebugPanel() {
        $nowModes = $this->getShowModes();
        $nowModes[] = self::SHOW_MODE_IN_DEBUG_BAR;
        $this->setShowModes(\array_unique($nowModes));
        return $this;
    }

    public function showDebugInCode() {
        $nowModes = $this->getShowModes();
        $nowModes[] = self::SHOW_MODE_IN_CODE;
        $this->setShowModes(\array_unique($nowModes));
        return $this;
    }

    public function setShowModes(array $showModes): bool {
        $result = true;

        $this->showModes = $showModes;

        return $result;
    }

    public function setShowMode(string $showMode): bool {
        return $this->setShowModes([$showMode]);
    }

    public function setLogPath(string $logType, string $pathFile): self {
        $this->logPaths[$logType] = $pathFile;
        return $this;
    }

    /**
     * Получить пути всех лог-типов
     * 
     * @return array
     */
    public function getLogPaths(): array {
        return $this->logPaths;
    }

    /**
     * Получить путь лог-типа
     * 
     * @return string | null
     */
    public function getLogPath(string $typeLog) {
        if (\array_key_exists($typeLog, $this->getLogPaths())) {
            return $this->getLogPaths()[$typeLog];
        } else {
            return null;
        }
    }

    /**
     * Получить разделитель при записи в лог-файл
     * 
     * @return type
     */
    public function getLogChunkDelimeter() {
        return $this->logChunkDelimeter;
    }

    public function setLogChunkDelimeter(string $logChunkDelimeter): self {
        $this->logChunkDelimeter = $logChunkDelimeter;
        return $this;
    }

}
