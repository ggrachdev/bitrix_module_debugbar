<?php

// Need include this file in init.php

use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

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

global $GD;
$GD = new \GGrach\BitrixDebugger\Debugger\Debugger($ggrachDebuggerConfigurator, $ggrachDebugBarConfigurator);

/*
 * code - отображать дебаг-данные в коде
 * debug_bar - отображать дебаг-данные в debug_bar
 */
$GD->setShowModes(['code', 'debug_bar']);

global $USER;

if ($USER && $USER->IsAdmin()) {
    Asset::getInstance()->addJs($ggrachDebuggerRootPath . "/assets/DebugBar/js/initializer.js");
    Asset::getInstance()->addCss($ggrachDebuggerRootPath . "/assets/DebugBar/themes/${$ggrachDebugBarConfigurator->getColorTheme()}/fix.css");
}

/**
 * Пример дебага:
 * 
 * $GD->notice("Моя переменная', 'Моя переменная 2');
 * $GD->error('Моя переменная', 'Моя переменная 2');
 * $GD->warning('Моя переменная', 'Моя переменная 2');
 * $GD->success('Моя переменная', 'Моя переменная 2');
 * 
 * Залогировать в файлы
 * $GD->noticeLog("Моя переменная', 'Моя переменная 2');
 * $GD->errorLog('Моя переменная', 'Моя переменная 2');
 * $GD->warningLog('Моя переменная', 'Моя переменная 2');
 * $GD->successLog('Моя переменная', 'Моя переменная 2');
 * 
 */
include 'inizializer_alias.php';
