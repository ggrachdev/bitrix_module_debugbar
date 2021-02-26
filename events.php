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
        strpos($APPLICATION->GetCurDir(), "/bitrix/") !== false ||
        $APPLICATION->GetProperty("save_kernel") == "Y" ||
        !\is_object($USER) || 
        !$USER->IsAdmin()
    ) {
        return;
    }

    $logData = \GGrach\BitrixDebugger\Representer\DebugBarRepresenter::render(DD());
    $content = \str_replace(['</body>', '</ body>', '</ body >', '</body >'], $logData . '</body>', $content);
}
