<?php

use \Bitrix\Main\Page\Asset;

// Корневая папка модуля
$ggrachDebuggerRootPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__ . '/..');

// Папка для логов по умолчанию
$ggrachPathLogFolder = \realpath('.' . $ggrachDebuggerRootPath . '/logs');

// Папка где хранятся js
$ggrachDirJs = "/bitrix/js/ggrachdev.debugbar";

// Папка где хранятся css
$ggrachDirCss = "/bitrix/css/ggrachdev.debugbar";

Bitrix\Main\Loader::registerAutoLoadClasses('ggrachdev.debugbar', [
    // BitrixDebugger
    "\\GGrach\\BitrixDebugger\\Debugger\\Debugger" => "classes/general/BitrixDebugger/Debugger/Debugger.php",
    "\\GGrach\\BitrixDebugger\\Debugger\\NoticeDebugger" => "classes/general/BitrixDebugger/Debugger/NoticeDebugger.php",
    "\\GGrach\\BitrixDebugger\\Debugger\\LogFileDebugger" => "classes/general/BitrixDebugger/Debugger/LogFileDebugger.php",
    "\\GGrach\\BitrixDebugger\\Debugger\\ConfigurationDebugger" => "classes/general/BitrixDebugger/Debugger/ConfigurationDebugger.php",
    "\\GGrach\\BitrixDebugger\\Debugger\\FilterDebugger" => "classes/general/BitrixDebugger/Debugger/FilterDebugger.php",
    "\\GGrach\\BitrixDebugger\\Contract\\ShowModableContract" => "classes/general/BitrixDebugger/Contract/ShowModableContract.php",
    "\\GGrach\\BitrixDebugger\\Configurator\\DebuggerConfigurator" => "classes/general/BitrixDebugger/Configurator/DebuggerConfigurator.php",
    "\\GGrach\\BitrixDebugger\\Configurator\\DebugBarConfigurator" => "classes/general/BitrixDebugger/Configurator/DebugBarConfigurator.php",    
    "\\GGrach\\BitrixDebugger\\Cache\\RuntimeCache" => "classes/general/BitrixDebugger/Cache/RuntimeCache.php",    
    "\\GGrach\\BitrixDebugger\\Validator\\ShowModeDebuggerValidator" => "classes/general/BitrixDebugger/Validator/ShowModeDebuggerValidator.php",
    "\\GGrach\\BitrixDebugger\\Representer\\DebugBarRepresenter" => "classes/general/BitrixDebugger/Representer/DebugBarRepresenter.php",
    "\\GGrach\\BitrixDebugger\\Events\\OnEndBufferContent" => "classes/general/BitrixDebugger/Events/OnEndBufferContent.php",
    // Writer
    "\\GGrach\\Writer\\FileWriter" => "classes/general/Writer/FileWriter.php",
    "\\GGrach\\Writer\\Contract\\WritableContract" => "classes/general/Writer/Contract/WritableContract.php",
    // Filtrator
    "\\GGrach\\Filtrator\\Filtrator" => "classes/general/Filtrator/Filtrator.php",
    "\\GGrach\\Filtrator\\FiltratorContract" => "classes/general/Filtrator/FiltratorContract.php"
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