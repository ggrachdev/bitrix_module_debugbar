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

        global $DBDebug, $APPLICATION;

        $debugIsOn = false;

        $bxSettingsDebug = \Bitrix\Main\Config\Configuration::getValue("exception_handling")['debug'];

        $log = $debugger->getLog();

        $view = '<section class="ggrach__overlay" style="display: none;"></section><section class="ggrach__debug_bar">';

        if ($DBDebug || $bxSettingsDebug) {
            $debugIsOn = true;
        } else {
            $debugIsOn = false;
        }

        if (!empty($_GET)) {
            $log['GET'] = [
                [
                    'file' => '',
                    'line' => '',
                    'data' => [
                        $_GET
                    ]
                ]
            ];
        }

        if (!empty($_POST)) {
            $log['POST'] = [
                [
                    'file' => '',
                    'line' => '',
                    'data' => [
                        $_POST
                    ]
                ]
            ];
        }

        if (!empty($_COOKIE)) {
            $log['COOKIE'] = [
                [
                    'file' => '',
                    'line' => '',
                    'data' => [
                        $_COOKIE
                    ]
                ]
            ];
        }

        if (!empty($_SERVER)) {
            $log['SERVER'] = [
                [
                    'file' => '',
                    'line' => '',
                    'data' => [
                        $_SERVER
                    ]
                ]
            ];
        }

        if (!empty($APPLICATION->GetPagePropertyList())) {
            $log['BX'] = [
                [
                    'file' => '',
                    'line' => '',
                    'data' => [
                        [
                            'PAGE_PROPERTIES' => $APPLICATION->GetPagePropertyList(),
                            'DIR_PROPERTIES' => $APPLICATION->GetDirPropertyList()
                        ]
                    ]
                ]
            ];
        }

        if (!empty($log)) {
            foreach ($log as $typeLog => $arLogs) {
                $view .= '<div class="ggrach__debug_bar__item type-notice-' . strtolower($typeLog) . '" data-type-notice="' . $typeLog . '" data-click="show_notice_panel">';

                if (in_array($typeLog, ['POST', 'GET', 'COOKIE', 'BX', 'SERVER'])) {
                    $count = $typeLog;
                } else {

                    $count = 0;

                    foreach ($arLogs as $arLogType) {
                        $count += \sizeof($arLogType['data']);
                    }
                }

                $view .= $count;
                $view .= '</div>';

                $view .= '<div class="ggrach__debug_bar__log" data-type-notice="' . $typeLog . '" style="display: none;">';

                foreach ($arLogs as $arLogType) {

                    foreach ($arLogType['data'] as $logValue) {
                        if (!in_array($typeLog, ['POST', 'GET', 'COOKIE', 'BX', 'SERVER'])) {
                            $lineView = '<a class="ggrach__debug_bar__log__line" target="_blank" href="/bitrix/admin/fileman_file_edit.php?path=' . str_replace($_SERVER['DOCUMENT_ROOT'], '', $arLogType['file']) . '&full_src=Y">' . $arLogType['file'] . ' on line ' . $arLogType['line'] . '</a>';
                        } else {
                            $lineView = '';
                        }

                        $needHideBlocks = !(in_array($typeLog, ['POST', 'GET', 'COOKIE', 'BX', 'SERVER']));

                        $view .= str_replace(['<span style="color: #0000BB">&lt;?</span>', '<span style="color: #0000BB">?&gt;</span>', '&lt;?', '?&gt;', '&lt;?php'], ['', '', '', ''], '<pre>' . \ggrach_highlight_data($logValue, $needHideBlocks) . $lineView . '</pre>');
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

        return $view;
    }

}
