<?php

namespace GGrach\BitrixDebugger\Validator;

use GGrach\BitrixDebugger\Contract\ShowModableContract;

/**
 * Description of ShowModeValidator
 *
 * @author ggrachdev
 */
class ShowModeValidator {

    public static function needShowInDebugBar(ShowModableContract $debugger) {
        return in_array('debug_bar', $debugger->getShowModes()) || in_array('everywhere', $debugger->getShowModes());
    }

    public static function needShowInCode(ShowModableContract $debugger) {
        return in_array('code', $debugger->getShowModes()) || in_array('everywhere', $debugger->getShowModes());
    }

    public static function needWriteInLog(ShowModableContract $debugger) {
        return in_array('code', $debugger->getShowModes()) || in_array('everywhere', $debugger->getShowModes());
    }

}
