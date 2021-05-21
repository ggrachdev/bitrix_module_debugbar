<?php

namespace GGrach\BitrixDebugger\Representer;

use \GGrach\BitrixDebugger\Debugger\Debugger;

/**
 * Description of DebugBarRepresenter
 *
 * @author ggrachdev
 */
class DebugBarRepresenter {

    const SYSTEM_KEYS_LOG = ['POST', 'GET', 'COOKIE', 'BX', 'SERVER'];

    protected static $leftSlotChunks = [];
    protected static $rightSlotChunks = [];

    public static function addViewInLeftSlot($view) {
        self::$leftSlotChunks[] = $view;
    }

    public static function addViewInRightSlot($view) {
        self::$rightSlotChunks[] = $view;
    }

    protected static function renderLeftView(): string {
        $view = '';
        $view .= implode('', self::$leftSlotChunks);
        return $view;
    }

    protected static function renderRightView(): string {
        $view = '<div class="ggrach__debug-bar__right">';
        $view .= implode('', self::$rightSlotChunks);
        $view .= '</div>';

        return $view;
    }

    public static function render(Debugger $debugger): string {

        global $DBDebug, $ggrachTracker;
        
        $connection = \Bitrix\Main\Application::getConnection();
        $connection->stopTracker();

        // Включен ли дебаг-режим
        $bxSettingsDebug = \Bitrix\Main\Config\Configuration::getValue("exception_handling")['debug'];

        if ($DBDebug || $bxSettingsDebug) {
            self::addViewInRightSlot('<a target="_blank" href="/bitrix/admin/fileman_file_edit.php?path=/bitrix/.settings.php&full_src=Y" class="ggrach__debug-bar__right__item ggrach_background_error" title="В битриксе включен дебаг-режим, он замедляет работу сайта!">D</a>');
        }

        $log = $debugger->getLog(true);

        if (!empty($log)) {
            foreach ($log as $typeLog => $arLogs) {
                $viewLeft = '<div class="ggrach__debug-bar__item ggrach_background_' . strtolower($typeLog) . ' type-notice-' . strtolower($typeLog) . '" data-type-notice="' . $typeLog . '" data-click="show_notice_panel">';

                if (in_array($typeLog, self::SYSTEM_KEYS_LOG)) {
                    $count = $typeLog;
                } else {

                    $count = 0;

                    foreach ($arLogs as $arLogType) {
                        $count += \sizeof($arLogType['data']);
                    }
                }

                $viewLeft .= $count;
                $viewLeft .= '</div>';

                $viewLeft .= '<div class="ggrach__debug-bar__log" data-type-notice="' . $typeLog . '" style="display: none;">';

                foreach ($arLogs as $arLogType) {

                    foreach ($arLogType['data'] as $logValue) {
                        if (!in_array($typeLog, self::SYSTEM_KEYS_LOG)) {
                            $lineView = '<a class="ggrach__debug-bar__log__line" target="_blank" href="/bitrix/admin/fileman_file_edit.php?path=' . str_replace($_SERVER['DOCUMENT_ROOT'], '', $arLogType['file']) . '&full_src=Y">' . $arLogType['file'] . ' on line ' . $arLogType['line'] . '</a>';
                        } else {
                            $lineView = '';
                        }

                        $needHideBlocks = !(in_array($typeLog, self::SYSTEM_KEYS_LOG));

                        $viewLeft .= str_replace(['<span style="color: #0000BB">&lt;?</span>', '<span style="color: #0000BB">?&gt;</span>', '&lt;?', '?&gt;', '&lt;?php'], ['', '', '', ''], '<pre>' . \ggrach_highlight_data($logValue, $needHideBlocks) . $lineView . '</pre>');
                    }
                }

                $viewLeft .= '</div>';

                self::addViewInLeftSlot($viewLeft);
            }
        }

        self::addViewInRightSlot('<a target="_blank" href="/bitrix/admin/site_edit.php?LID=' . \SITE_ID . '&lang=ru" class="ggrach__debug-bar__right__item ggrach_background_notice" title="SITE ID - Идентификатор сайта">' . \SITE_ID . '</a>');

        self::addViewInRightSlot('<a target="_blank" href="/bitrix/admin/site_edit.php?LID=' . \SITE_ID . '&lang=ru" class="ggrach__debug-bar__right__item ggrach_background_success" title="Текущая страница">' . SITE_CHARSET . '</a>');

        $debugBarIsClosed = $_COOKIE['ggrach_debug_bar_is_close'] == 'true';
        
        $closeIcon = $debugBarIsClosed ? '&lt;' : '&#215;';
        
        self::addViewInRightSlot('<div class="ggrach__debug-bar__right__item ggrach_background_notice" title="Количество SQL запросов">SQL: ' . sizeof($ggrachTracker->getQueries()) . '</div>');
        
        self::addViewInRightSlot('<a target="_blank" href="/bitrix/admin/cache.php?lang=ru" class="ggrach__debug-bar__right__item ggrach_background_success" title="Управление кешем">C</a>');
        
        self::addViewInRightSlot('<a href="javascript:void(0);" data-click="toggle_debug_bar" class="ggrach__debug-bar__right__item ggrach__debug-bar__right__item_close ggrach_background_black" title="Скрыть / Раскрыть дебаг-бар">'.$closeIcon.'</a>');

        $view = '<section class="ggrach__overlay" style="display: none;"></section><section class="ggrach__debug-bar '.($debugBarIsClosed ? 'hide-debug-bar' : '').'">';

        $view .= self::renderLeftView();
        $view .= self::renderRightView();

        $view .= '</section>';

        return $view;
    }

}
