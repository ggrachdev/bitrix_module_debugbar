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
        
        if(empty($log)) return '';

        $view = '<section class="ggrach__debug_bar">';

        if (!empty($log)) {
            foreach ($log as $typeLog => $arLogs) {
                $view .= '<div class="ggrach__debug_bar__item type-notice-' . $typeLog . '" data-type-notice="' . $typeLog . '" data-click="show_notice_panel">';
                $view .= \sizeof($arLogs);
                $view .= '</div>';

                $view .= '<div class="ggrach__debug_bar__log" data-type-notice="' . $typeLog . '" style="display: none;">';
                foreach ($arLogs as $logValue) {

                    $logValue = \strip_tags($logValue);

                    if (is_string($logValue)) {
                        if (\strlen($logValue) > 200) {
                            $logValue = '[String]';
                        }
                    }

                    $view .= str_replace(['<span style="color: #0000BB">&lt;?</span>', '<span style="color: #0000BB">?&gt;</span>', '&lt;?', '?&gt;', '&lt;?php'], ['', '', '', ''], '<pre>' . \highlight_string('<?' . \var_export($logValue, true) . '?>', true) . '</pre>');
                }
                $view .= '</div>';
            }
        }

        $view .= '</section>';

        $view .= '<script> var GgrachDebuggerLogProvider = ' . \CUtil::PhpToJSObject(GD()->getLog()) . '; </script>';

        return $view;
    }

}
