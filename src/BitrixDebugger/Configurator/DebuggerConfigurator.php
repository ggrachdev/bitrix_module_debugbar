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
    protected $logChunkDelimeter = "======\n";

    public function setLogPath(string $logType, string $pathFile): self {
        if (\array_key_exists($logType, $this->getLogPaths())) {
            $this->logPaths[$logType] = $pathFile;
        }

        return $this;
    }

    /**
     * Получить пути всех-лог файлов
     * 
     * @return type
     */
    public function getLogPaths() {
        return $this->logPaths;
    }

    public function getLogChunkDelimeter() {
        return $this->logChunkDelimeter;
    }

    public function setLogChunkDelimeter(string $logChunkDelimeter): self {
        $this->logChunkDelimeter = $logChunkDelimeter;

        return $this;
    }

    public function addLogType(string $keyLog, string $pathLogFile): self {
        $this->logPaths[$keyLog] = $pathLogFile;

        return $this;
    }

}
