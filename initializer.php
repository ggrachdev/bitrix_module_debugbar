<?php

// Need include this file in init.php
// include 'BitrixDebugger/initializer.php';

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
    "\GGrach\BitrixDebugger\Representer\DebugBarRepresenter" => $ggrachDebuggerRootPath . "/src/BitrixDebugger/Representer/DebugBarRepresenter.php",
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

function GD() {
    global $GD;
    return $GD;
}

Asset::getInstance()->addJs($ggrachDebuggerRootPath . "/assets/DebugBar/js/initializer.js");
Asset::getInstance()->addCss($ggrachDebuggerRootPath . '/assets/DebugBar/themes/general.css');
Asset::getInstance()->addCss($ggrachDebuggerRootPath . '/assets/DebugBar/themes/' . $ggrachDebugBarConfigurator->getColorTheme() . '/theme.css');

/**
 * Пример дебага:
 * 
 * GD()->notice('Моя переменная', 'Моя переменная 2');
 * GD()->error('Моя переменная', 'Моя переменная 2');
 * GD()->warning('Моя переменная', 'Моя переменная 2');
 * GD()->success('Моя переменная', 'Моя переменная 2');
 * 
 * Залогировать в файлы
 * GD()->noticeLog('Моя переменная', 'Моя переменная 2');
 * GD()->errorLog('Моя переменная', 'Моя переменная 2');
 * GD()->warningLog('Моя переменная', 'Моя переменная 2');
 * GD()->successLog('Моя переменная', 'Моя переменная 2');
 * 
 */
include 'inizializer_alias.php';

if (\GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator::needShowInDebugBar($GD)) {

    function ggrach_highlight_data($data = []) {

        $viewResult = '';

        $need_hide_blocks = true;

        $ppr = function ($in, $opened, $margin = 5) use(&$ppr, $need_hide_blocks) {

            $viewRes = '';

            if (!\is_object($in) && !\is_array($in)) {
                return $in;
            }

            if ($need_hide_blocks == true)
                $opened = '';

            foreach ($in as $key => $value) {
                if (\is_object($value) || \is_array($value)) {
                    $viewRes .= '<details style="margin-left:' . $margin . 'px" ' . $opened . '>';
                    $viewRes .= '<summary style="cursor: pointer; margin-top: 5px; margin-bottom: 5px; text-decoration: underline;">';
                    $viewRes .= (is_object($value)) ? $key . ' {' . count((array) $value) . '}' : $key . ' [' . count($value) . ']';
                    $viewRes .= '</summary>';
                    $viewRes .= $ppr($value, $opened, $margin + 5);
                    $viewRes .= '</details>';
                } else {
                    switch (gettype($value)) {
                        case 'string':
                            $bgc = 'red';

                            if (\strlen($value) > 500) {
                                $value = '[Очень длинная строка]';
                            }

                            break;
                        case 'integer':
                            $bgc = 'green';
                            break;
                    }
                    $viewRes .= '<div style="margin-left:' . $margin . 'px">' . $key . ' : <span style="color:' . $bgc . '">' . $value . '</span>  <span style="color: blue;">(' . gettype($value) . ')</span></div>';
                }
            }

            return $viewRes;
        };

        $pp = function ($in, $opened = true) use ($ppr) {

            $view = '';

            if ($opened) {
                $opened = ' open';
            }


            $view .= '<div>';

            if (is_object($in) or is_array($in)) {
                $view .= '<details' . $opened . '>';
                $view .= '<summary style="cursor: pointer; margin-top: 5px; margin-bottom: 5px; text-decoration: underline;">';
                $view .= (is_object($in)) ? 'Object {' . count((array) $in) . '}' : 'Array [' . count($in) . ']';
                $view .= '</summary>';
                $view .= $ppr($in, $opened);
                $view .= '</details>';
            } else {
                switch (gettype($in)) {
                    case 'string':
                        $bgc = 'red';

                        if (\strlen($in) > 500) {
                            $in = '[Очень длинная строка]';
                        }

                        break;
                    case 'integer':
                        $bgc = 'green';
                        break;
                }

                $view .= '<div style="margin-left: 0px"><span style="color:' . $bgc . '">' . $in . '</span>  <span style="color: blue;">(' . gettype($in) . ')</span></div>';
            }


            $view .= '</div>';


            return $view;
        };

        $viewResult .= $pp($data, !$need_hide_blocks);

        return $viewResult;
    }

    include 'events.php';
}
