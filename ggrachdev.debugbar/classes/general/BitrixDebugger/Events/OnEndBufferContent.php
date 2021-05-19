<?php

namespace GGrach\BitrixDebugger\Events;

/**
 * Description of OnEndBufferContent
 *
 * @author ggrachdev
 */
class OnEndBufferContent {

    public function addDebugBar(&$content) {
        global $USER, $APPLICATION;

        if (
            strpos($APPLICATION->GetCurDir(), "/bitrix/") !== false ||
            $APPLICATION->GetProperty("save_kernel") == "Y" ||
            !\is_object($USER) ||
            !$USER->IsAdmin()
        ) {
            return;
        }

        $logData = \GGrach\BitrixDebugger\Representer\DebugBarRepresenter::render(DD());
        $content = \preg_replace("~<\s*\t*/\s*\t*body\s*\t*>~", $logData . '</body>', $content);
    }

}