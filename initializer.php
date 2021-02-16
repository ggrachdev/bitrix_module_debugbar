<?php

// Need include this file in init.php

use Bitrix\Main\Loader;

$ggrachDebuggerRootPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__);

Loader::registerAutoLoadClasses(null, [
    "\GGrach\BitrixDebugger\Debugger\Debugger" => $ggrachDebuggerRootPath . "/src/BitrixDebugger/Debugger/Debugger.php",
    "\GGrach\BitrixDebugger\Debugger\DebuggerShowModable" => $ggrachDebuggerRootPath . "/src/BitrixDebugger/Debugger/DebuggerShowModable.php",
    "\GGrach\BitrixDebugger\Contract\ShowModableContract" => $ggrachDebuggerRootPath . "/src/BitrixDebugger/Contract/ShowModableContract.php",
    "\GGrach\BitrixDebugger\Configurator\DebuggerConfigurator" => $ggrachDebuggerRootPath . "/src/BitrixDebugger/Configurator/DebuggerConfigurator.php",
    "\GGrach\BitrixDebugger\Configurator\DebugBarConfigurator" => $ggrachDebuggerRootPath . "/src/BitrixDebugger/Configurator/DebugBarConfigurator.php",
    "\GGrach\BitrixDebugger\Cache\RuntimeCache" => $ggrachDebuggerRootPath . "/src/BitrixDebugger/Cache/RuntimeCache.php",
    "\GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator" => $ggrachDebuggerRootPath . "/src/BitrixDebugger/Validator/ShowModeDebuggerValidator.php",
    "\GGrach\Writer\FileWriter" => $ggrachDebuggerRootPath . "/src/Writer/FileWriter.php",
    "\GGrach\Writer\Contract\WritableContract" => $ggrachDebuggerRootPath . "/src/Writer/Contract/WritableContract.php"
]);

$ggrachDebuggerConfigurator = new \GGrach\BitrixDebugger\Configurator\DebuggerConfigurator();
$ggrachDebugBarConfigurator = new \GGrach\BitrixDebugger\Configurator\DebugBarConfigurator();

$ggrachDebuggerConfigurator->setLogPath('error', __DIR__ . '/logs/error.log');
$ggrachDebuggerConfigurator->setLogPath('warning', __DIR__ . '/logs/warning.log');
$ggrachDebuggerConfigurator->setLogPath('success', __DIR__ . '/logs/success.log');
$ggrachDebuggerConfigurator->setLogPath('notice', __DIR__ . '/logs/notice.log');

/*
 * code - отображать дебаг-данные в коде
 * debug_bar - отображать дебаг-данные в debug_bar
 * log - отображать дебаг-данные в логе
 */
$ggrachDebuggerConfigurator->setShowModes(['code', 'debug_bar', 'log']);

global $GD;
$GD = new \GGrach\BitrixDebugger\Debugger\Debugger($ggrachDebuggerConfigurator, $ggrachDebugBarConfigurator);

include 'inizializer_alias.php';