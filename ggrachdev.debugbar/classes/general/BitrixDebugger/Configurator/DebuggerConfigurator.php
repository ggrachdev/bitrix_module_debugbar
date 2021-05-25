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

    public function getShowModesEnum(): array {
        return ['code', 'debug_bar'];
    }

    public function setShowModes(array $showModes): bool {
        $result = true;

        if (!empty($showModes)) {

            $avaliableModes = $this->getShowModesEnum();

            // @todo array_udiff
            foreach ($showModes as $mode) {
                if (!\in_array($mode, $avaliableModes)) {
                    $result = false;
                    break;
                }
            }

            if ($result) {
                $this->showModes = $showModes;
            }
        } else {
            $result = false;
        }

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
