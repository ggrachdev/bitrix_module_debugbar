<?php

namespace GGrach\BitrixDebugger\Validator;

use GGrach\BitrixDebugger\Configurator\DebuggerConfigurator;

/**
 * Проверка допустимых действий для режимов отображения
 */
class ShowModeDebuggerValidator {

    public static function needShowInDebugBar(DebuggerConfigurator $debuggerConfigurator) {
        return in_array(DebuggerConfigurator::SHOW_MODE_IN_DEBUG_BAR, $debuggerConfigurator->getShowModes());
    }

    public static function needShowInCode(DebuggerConfigurator $debuggerConfigurator) {
        global $USER;
        return in_array(DebuggerConfigurator::SHOW_MODE_IN_CODE, $debuggerConfigurator->getShowModes()) && \is_object($USER) && $USER->IsAdmin();
    }
    
}
