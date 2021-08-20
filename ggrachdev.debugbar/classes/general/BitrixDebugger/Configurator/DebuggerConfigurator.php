<?php

namespace GGrach\BitrixDebugger\Configurator;

use \GGrach\BitrixDebugger\Contract\IShowModable;

/**
 * Description of DebugConfigurator
 *
 * @author ggrachdev
 */
class DebuggerConfigurator implements IShowModable {

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

    /**
     * Где показывать
     * 
     * code - в коде
     * debug_bar - в дебаг-баре
     * 
     * @var array
     */
    protected $showModes = ['code', 'debug_bar'];

    public function getShowModes(): array {
        return $this->showModes;
    }

    public function notShowDebugInPanel() {
        $nowModes = $this->getShowModes();
        if (\in_array('debug_bar', $nowModes)) {
            unset($nowModes[\array_search('debug_bar', $nowModes)]);
            $this->setShowModes(\array_unique($nowModes));
        }
        return $this;
    }

    public function notShowDebugInCode() {
        $nowModes = $this->getShowModes();
        if (\in_array('code', $nowModes)) {
            unset($nowModes[\array_search('code', $nowModes)]);
            $this->setShowModes(\array_unique($nowModes));
        }
        return $this;
    }

    public function showDebugInPanel() {
        $nowModes = $this->getShowModes();
        $nowModes[] = 'debug_bar';
        $this->setShowModes(\array_unique($nowModes));
        return $this;
    }

    public function showDebugInCode() {
        $nowModes = $this->getShowModes();
        $nowModes[] = 'code';
        $this->setShowModes(\array_unique($nowModes));
        return $this;
    }

    public function getShowModesEnum(): array {
        return ['code', 'debug_bar'];
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
