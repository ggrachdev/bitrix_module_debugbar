<?php

namespace GGrach\BitrixDebugger\Validator;

use GGrach\BitrixDebugger\Contract\IShowModable;

/**
 * Проверка допустимых действий для режимов отображения
 *
 * @author ggrachdev
 */
class ShowModeDebuggerValidator {

    public static function needShowInDebugBar(IShowModable $showModable) {
        return in_array('debug_bar', $showModable->getShowModes());
    }

    public static function needShowInCode(IShowModable $showModable) {
        global $USER;
        return in_array('code', $showModable->getShowModes()) && \is_object($USER) && $USER->IsAdmin();
    }
    
}
