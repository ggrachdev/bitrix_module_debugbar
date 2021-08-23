<?php

namespace GGrach\BitrixDebugger\Validator;

use GGrach\BitrixDebugger\Contract\IShowModable;
use GGrach\BitrixDebugger\Configurator\DebuggerConfigurator;

/**
 * Проверка допустимых действий для режимов отображения
 *
 * @author ggrachdev
 */
class ShowModeDebuggerValidator {

    public static function needShowInDebugBar(IShowModable $showModable) {
        return in_array(DebuggerConfigurator::SHOW_MODE_IN_DEBUG_BAR, $showModable->getShowModes());
    }

    public static function needShowInCode(IShowModable $showModable) {
        global $USER;
        return in_array(DebuggerConfigurator::SHOW_MODE_IN_CODE, $showModable->getShowModes()) && \is_object($USER) && $USER->IsAdmin();
    }
    
}
