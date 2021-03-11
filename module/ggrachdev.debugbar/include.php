<?php

use \Bitrix\Main\Page\Asset;

if (!\defined('GGRACH_DEBUG_BAR_TYPE_INCLUDE')) {
    define('GGRACH_DEBUG_BAR_TYPE_INCLUDE', 'module');
}

if (GGRACH_DEBUG_BAR_TYPE_INCLUDE === 'module') {

    // Корневая папка модуля
    $ggrachDebuggerRootPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__ . '/..');

    // Папка для логов по умолчанию
    $ggrachPathLogFolder = \realpath('.' . $ggrachDebuggerRootPath . '/logs');

    // Папка для автозагрузки классов
    $ggrachRootpathClassAutoload = "classes/general";

    // Папка где хранятся js
    $ggrachDirJs = "/bitrix/js/ggrachdev.debugbar";

    // Папка где хранятся css
    $ggrachDirCss = "/bitrix/css/ggrachdev.debugbar";
} else {
    // Корневая папка модуля
    $ggrachDebuggerRootPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__ . '/../..');

    // Папка для логов по умолчанию
    $ggrachPathLogFolder = \realpath('.' . $ggrachDebuggerRootPath . '/logs');

    // Папка для автозагрузки классов
    $ggrachRootpathClassAutoload = $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general";

    // Папка где хранятся js
    $ggrachDirJs = $ggrachDebuggerRootPath . '/module/ggrachdev.debugbar/install/js';

    // Папка где хранятся css
    $ggrachDirCss = $ggrachDebuggerRootPath . '/module/ggrachdev.debugbar/install/css';
}

Bitrix\Main\Loader::registerAutoLoadClasses('ggrachdev.debugbar', [
    // BitrixDebugger
    "\GGrach\BitrixDebugger\Debugger\Debugger" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Debugger/Debugger.php",
    "\GGrach\BitrixDebugger\Debugger\NoticeDebugger" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Debugger/NoticeDebugger.php",
    "\GGrach\BitrixDebugger\Debugger\LogFileDebugger" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Debugger/LogFileDebugger.php",
    "\GGrach\BitrixDebugger\Debugger\ConfigurationDebugger" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Debugger/ConfigurationDebugger.php",
    "\GGrach\BitrixDebugger\Debugger\FilterDebugger" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Debugger/FilterDebugger.php",
    "\GGrach\BitrixDebugger\Contract\ShowModableContract" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Contract/ShowModableContract.php",
    "\GGrach\BitrixDebugger\Configurator\DebuggerConfigurator" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Configurator/DebuggerConfigurator.php",
    "\GGrach\BitrixDebugger\Configurator\DebugBarConfigurator" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Configurator/DebugBarConfigurator.php",    
    "\GGrach\BitrixDebugger\Cache\RuntimeCache" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Cache/RuntimeCache.php",    
    "\GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Validator/ShowModeDebuggerValidator.php",
    "\GGrach\BitrixDebugger\Representer\DebugBarRepresenter" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Representer/DebugBarRepresenter.php",
    "\GGrach\BitrixDebugger\Events\OnEndBufferContent" => $ggrachRootpathClassAutoload . "/BitrixDebugger/Events/OnEndBufferContent.php",
    // Writer
    "\GGrach\Writer\FileWriter" => $ggrachRootpathClassAutoload . "/Writer/FileWriter.php",
    "\GGrach\Writer\Contract\WritableContract" => $ggrachRootpathClassAutoload . "/Writer/Contract/WritableContract.php",
    // Filtrator
    "\GGrach\Filtrator\Filtrator" => $ggrachRootpathClassAutoload . "/Filtrator/Filtrator.php",
    "\GGrach\Filtrator\FiltratorContract" => $ggrachRootpathClassAutoload . "/Filtrator/FiltratorContract.php"
]);
$ggrachDebuggerConfigurator = new \GGrach\BitrixDebugger\Configurator\DebuggerConfigurator();
$ggrachDebugBarConfigurator = new \GGrach\BitrixDebugger\Configurator\DebugBarConfigurator();

$ggrachDebuggerConfigurator->setLogPath('error', $ggrachPathLogFolder . '/error.log')
    ->setLogPath('warning', $ggrachPathLogFolder . '/warning.log')
    ->setLogPath('success', $ggrachPathLogFolder . '/success.log')
    ->setLogPath('notice', $ggrachPathLogFolder . '/notice.log');

$GLOBALS["DD"] = new \GGrach\BitrixDebugger\Debugger\Debugger($ggrachDebuggerConfigurator, $ggrachDebugBarConfigurator);

/*
 * code - отображать дебаг-данные в коде
 * debug_bar - отображать дебаг-данные в debug_bar
 */
$GLOBALS["DD"]->getConfiguratorDebugger()->setShowModes(['debug_bar']);

function DD(...$data) {
    
    $GLOBALS["DD"]->resetFilter();
    
    if (!empty($data)) {
        foreach ($data as $item) {
            $GLOBALS["DD"]->notice($item);
        }
    }

    return $GLOBALS["DD"];
}

if (\GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator::needShowInDebugBar(DD()->getConfiguratorDebugger())) {

    Asset::getInstance()->addJs($ggrachDirJs . "/initializer.js");
    Asset::getInstance()->addCss($ggrachDirCss . '/general.css');
    Asset::getInstance()->addCss($ggrachDirCss . '/' . $ggrachDebugBarConfigurator->getColorTheme() . '/theme.css');

    include 'functions.php';
    include 'events.php';
}