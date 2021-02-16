<?php

namespace GGrach\BitrixDebugger\Validator;

use GGrach\BitrixDebugger\Contract\ShowModableContract;

/**
 * Description of ShowModeDebuggerValidator
 *
 * @author ggrachdev
 */
class ShowModeDebuggerValidator {

    public static function needShowInDebugBar(ShowModableContract $debugger) {
        return in_array('debug_bar', $debugger->getShowModes());
    }

    public static function needShowInCode(ShowModableContract $debugger) {
        return in_array('code', $debugger->getShowModes());
    }

    public static function needWriteInLog(ShowModableContract $debugger) {
        return in_array('log', $debugger->getShowModes());
    }

}
