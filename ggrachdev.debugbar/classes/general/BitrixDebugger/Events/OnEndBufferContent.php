<?php

namespace GGrach\BitrixDebugger\Events;

use \Bitrix\Main\Application;
    
/**
 * Description of OnEndBufferContent
 *
 * @author ggrachdev
 */
class OnEndBufferContent {
    
    public function addDebugBar(&$content) {
        global $USER, $APPLICATION;

        $request = Application::getInstance()->getContext()->getRequest();

        if (
            strpos($APPLICATION->GetCurDir(), "/bitrix/") !== false ||
            $APPLICATION->GetProperty("save_kernel") == "Y" ||
            !\is_object($USER) ||
            !$USER->IsAdmin() ||
            $request->isAjaxRequest()
        ) {
            return;
        }

        $logData = \GGrach\BitrixDebugger\View\DebugBarView::render(DD());
        $content = \preg_replace("~<\s*\t*/\s*\t*body\s*\t*>~", $logData . '</body>', $content);
    }

}
