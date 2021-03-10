<?php
// Добавляем дебаг-бар
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "main",
    "OnEndBufferContent",
    [
        "\\GGrach\\BitrixDebugger\\Events\\OnEndBufferContent",
        "addDebugBar"
    ]
);
