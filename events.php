<?php
// Добавляем дебаг-бар
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "main",
    "OnEndBufferContent",
    [
        "\\GGrach\\Writer\Events\\OnEndBufferContent",
        "addDebugBar"
    ]
);
