<?php

// Need include this file in init.php

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(null, [
    "\GGrach\BitrixDebugger\Debugger\Debugger" => __DIR__ . "/src/BitrixDebugger/Debugger/Debugger.php",
    "\GGrach\BitrixDebugger\Debugger\DebuggerShowModable" => __DIR__ . "/src/BitrixDebugger/Debugger/DebuggerShowModable.php",
    "\GGrach\BitrixDebugger\Contract\ShowModableContract" => __DIR__ . "/src/BitrixDebugger/Contract/ShowModableContract.php",
    "\GGrach\BitrixDebugger\Configurator\DebuggerConfigurator" => __DIR__ . "/src/BitrixDebugger/Configurator/DebuggerConfigurator.php",
    "\GGrach\BitrixDebugger\Configurator\DebugBarConfigurator" => __DIR__ . "/src/BitrixDebugger/Configurator/DebugBarConfigurator.php",
    "\GGrach\BitrixDebugger\Cache\RuntimeCache" => __DIR__ . "/src/BitrixDebugger/Cache/RuntimeCache.php",
    "\GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator" => __DIR__ . "/src/BitrixDebugger/Validator/ShowModeDebuggerValidator.php",
    "\GGrach\Writer\FileWriter" => __DIR__ . "/src/Writer/FileWriter.php",
    "\GGrach\Writer\Contract\WritableContract" => __DIR__ . "/src/Writer/Contract/WritableContract.php"
]);

$ggrachDebuggerConfigurator = new \GGrach\BitrixDebugger\Configurator\DebuggerConfigurator();
$ggrachDebugBarConfigurator = new \GGrach\BitrixDebugger\Configurator\DebugBarConfigurator();

$ggrachDebuggerConfigurator->setLogPath('error', __DIR__ . '/logs/error.log');
$ggrachDebuggerConfigurator->setLogPath('warning', __DIR__ . '/logs/warning.log');
$ggrachDebuggerConfigurator->setLogPath('success', __DIR__ . '/logs/success.log');
$ggrachDebuggerConfigurator->setLogPath('notice', __DIR__ . '/logs/notice.log');

global $GD;
$GD = new \GGrach\BitrixDebugger\Debugger\Debugger($ggrachDebuggerConfigurator, $ggrachDebugBarConfigurator);

include 'inizializer_alias.php';
