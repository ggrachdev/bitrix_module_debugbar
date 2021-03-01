<?php

namespace GGrach\BitrixDebugger\Representer;

use \GGrach\BitrixDebugger\Debugger\Debugger;

/**
 * Description of DebugBarRepresenter
 *
 * @author ggrachdev
 */
class DebugBarRepresenter {

    public static function render(Debugger $debugger): string {

        global $DBDebug;

        $debugIsOn = false;

//        $bxSettings = require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/.settings.php';
        $bxSettingsDebug = \Bitrix\Main\Config\Configuration::getValue("exception_handling")['debug'];

        $log = $debugger->getLog();

        $view = '<section class="ggrach__overlay" style="display: none;"></section><section class="ggrach__debug_bar">';

        if ($DBDebug || $bxSettingsDebug) {
            $debugIsOn = true;
        } else {
            $debugIsOn = false;
        }

        if (!empty($_GET)) {
            $log['$_GET'] = [
                'file' => 'global',
                'line' => '',
                'data' => $_GET
            ];
        }

        if (!empty($_POST)) {
            $log['$_POST'] = [
                'file' => 'global',
                'line' => '',
                'data' => $_POST
            ];
        }

        if (!empty($log)) {
            foreach ($log as $typeLog => $arLogs) {
                $view .= '<div class="ggrach__debug_bar__item type-notice-' . $typeLog . '" data-type-notice="' . $typeLog . '" data-click="show_notice_panel">';

                $count = 0;

                foreach ($arLogs as $arLogType) {
                    $count += \sizeof($arLogType['data']);
                }

                $view .= $count;
                $view .= '</div>';

                $view .= '<div class="ggrach__debug_bar__log" data-type-notice="' . $typeLog . '" style="display: none;">';

                foreach ($arLogs as $arLogType) {

                    foreach ($arLogType['data'] as $logValue) {
                        $lineView = '<a class="ggrach__debug_bar__log__line" target="_blank" href="/bitrix/admin/fileman_file_edit.php?path=' . str_replace($_SERVER['DOCUMENT_ROOT'], '', $arLogType['file']) . '&full_src=Y">' . $arLogType['file'] . ' on line ' . $arLogType['line'] . '</a>';

                        $view .= str_replace(['<span style="color: #0000BB">&lt;?</span>', '<span style="color: #0000BB">?&gt;</span>', '&lt;?', '?&gt;', '&lt;?php'], ['', '', '', ''], '<pre>' . \ggrach_highlight_data($logValue) . $lineView . '</pre>');
                    }
                }

                $view .= '</div>';
            }
        }

        $view .= '<div class="ggrach__debug_bar__right">';

        $view .= '<a target="_blank" href="/bitrix/admin/site_edit.php?LID=' . \SITE_ID . '&lang=ru" class="ggrach__debug_bar__right__item type-notice-notice" title="SITE ID - Идентификатор сайта">' . \SITE_ID . '</a>';

        $view .= '<a target="_blank" href="/bitrix/admin/site_edit.php?LID=' . \SITE_ID . '&lang=ru" class="ggrach__debug_bar__right__item type-notice-success" title="Текущая страница">' . SITE_CHARSET . '</a>';

        if ($debugIsOn) {
            $view .= '<a target="_blank" href="/bitrix/admin/fileman_file_edit.php?path=/bitrix/.settings.php&full_src=Y" class="ggrach__debug_bar__right__item type-notice-error" title="В битриксе включен дебаг-режим, он замедляет работу сайта!">D</a>';
        }

        $view .= '</div>';
        $view .= '</section>';

        // $view .= '<script> var GgrachDebuggerLogProvider = ' . \CUtil::PhpToJSObject(GD()->getLog()) . '; </script>';

        return $view;
    }

}
