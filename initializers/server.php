<?

use Bitrix\Main\Page\Asset;

$ggrachDebuggerRootPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__ . '/..');
$ggrachPathLogFolder = \realpath('.' . $ggrachDebuggerRootPath . '/logs');

\Bitrix\Main\Loader::registerAutoLoadClasses(null, [
    "\GGrach\BitrixDebugger\Debugger\Debugger" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Debugger/Debugger.php",
    "\GGrach\BitrixDebugger\Debugger\NoticeDebugger" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Debugger/NoticeDebugger.php",
    "\GGrach\BitrixDebugger\Debugger\LogFileDebugger" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Debugger/LogFileDebugger.php",
    "\GGrach\BitrixDebugger\Debugger\ConfigurationDebugger" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Debugger/ConfigurationDebugger.php",
    "\GGrach\BitrixDebugger\Contract\ShowModableContract" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Contract/ShowModableContract.php",
    "\GGrach\BitrixDebugger\Configurator\DebuggerConfigurator" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Configurator/DebuggerConfigurator.php",
    "\GGrach\BitrixDebugger\Configurator\DebugBarConfigurator" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Configurator/DebugBarConfigurator.php",
    "\GGrach\BitrixDebugger\Cache\RuntimeCache" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Cache/RuntimeCache.php",
    "\GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Validator/ShowModeDebuggerValidator.php",
    "\GGrach\BitrixDebugger\Representer\DebugBarRepresenter" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Representer/DebugBarRepresenter.php",
    "\GGrach\Writer\FileWriter" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/Writer/FileWriter.php",
    "\GGrach\Writer\Contract\WritableContract" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/Writer/Contract/WritableContract.php",
    "\GGrach\BitrixDebugger\Events\OnEndBufferContent" => $ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/classes/general/BitrixDebugger/Events/OnEndBufferContent.php"
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

function DD() {
    return $GLOBALS["DD"];
}

if (\GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator::needShowInDebugBar(DD()->getConfiguratorDebugger())) {


    Asset::getInstance()->addJs($ggrachDebuggerRootPath . "/module/ggrachdev.debugbar/assets/DebugBar/js/initializer.js");
    Asset::getInstance()->addCss($ggrachDebuggerRootPath . '/module/ggrachdev.debugbar/assets/DebugBar/css/themes/general.css');
    Asset::getInstance()->addCss($ggrachDebuggerRootPath . '/module/ggrachdev.debugbar/assets/DebugBar/css/themes/' . $ggrachDebugBarConfigurator->getColorTheme() . '/theme.css');

    include __DIR__ . '/../functions.php';
    include __DIR__ . '/../events.php';
}