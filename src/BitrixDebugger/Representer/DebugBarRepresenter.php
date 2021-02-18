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

        $log = $debugger->getLog();

        if (empty($log))
            return '';

        $view = '<section class="ggrach__overlay" style="display: none;"></section><section class="ggrach__debug_bar">';

        if (!empty($log)) {
            foreach ($log as $typeLog => $arLogs) {
                $view .= '<div class="ggrach__debug_bar__item type-notice-' . $typeLog . '" data-type-notice="' . $typeLog . '" data-click="show_notice_panel">';
                $view .= \sizeof($arLogs['data']);
                $view .= '</div>';

                $view .= '<div class="ggrach__debug_bar__log" data-type-notice="' . $typeLog . '" style="display: none;">';
                foreach ($arLogs['data'] as $logValue) {

                    $lineView = '<a class="ggrach__debug_bar__log__line" target="_blank" href="/bitrix/admin/fileman_file_edit.php?path=' . str_replace($_SERVER['DOCUMENT_ROOT'], '', $arLogs['file']) . '&full_src=Y">' . $arLogs['file'] . ' on line ' . $arLogs['line'] . '</a>';

                    $view .= str_replace(['<span style="color: #0000BB">&lt;?</span>', '<span style="color: #0000BB">?&gt;</span>', '&lt;?', '?&gt;', '&lt;?php'], ['', '', '', ''], '<pre>' . \ggrach_highlight_data($logValue) . $lineView . '</pre>');
                }
                $view .= '</div>';
            }
        }

        $view .= '</section>';

        // $view .= '<script> var GgrachDebuggerLogProvider = ' . \CUtil::PhpToJSObject(GD()->getLog()) . '; </script>';

        return $view;
    }

}
