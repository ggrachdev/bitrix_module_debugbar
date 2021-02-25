<?php

// Добавляем дебаг-бар
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "main",
    "OnEndBufferContent",
    "GgrachAddDebugBar"
);

function GgrachAddDebugBar(&$content) {

    global $USER, $APPLICATION;

    if (
        strpos($APPLICATION->GetCurDir(), "/bitrix/") !== false) {
        return;
    }
    
    if ($APPLICATION->GetProperty("save_kernel") == "Y") {
        return;
    }
    
    if(!\is_object($USER))
    {
        return;
    }
    
    if(!$USER->IsAdmin())
    {
        return;
    }

    $logData = \GGrach\BitrixDebugger\Representer\DebugBarRepresenter::render(DD());
    $content = \str_replace('</body>', $logData . '</body>', $content);
}
