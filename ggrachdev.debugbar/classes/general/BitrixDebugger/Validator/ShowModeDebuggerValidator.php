<?php

namespace GGrach\BitrixDebugger\Validator;

use GGrach\BitrixDebugger\Contract\ShowModableContract;

/**
 * Проверка допустимых действий для режимов отображения
 *
 * @author ggrachdev
 */
class ShowModeDebuggerValidator {

    public static function needShowInDebugBar(ShowModableContract $showModable) {
        return in_array('debug_bar', $showModable->getShowModes());
    }

    public static function needShowInCode(ShowModableContract $showModable) {
        global $USER;
        return in_array('code', $showModable->getShowModes()) && \is_object($USER) && $USER->IsAdmin();
    }
    
}
