<?php

// Добавляем дебаг-бар
AddEventHandler("main", "OnEndBufferContent", "GgrachAddDebugBar");

function GgrachAddDebugBar(&$content)
{
    $logData = '<script> var GgrachDebuggerLogProvider = '.CUtil::PhpToJSObject(GD()->getLog()).'; </script>';
    $content = \str_replace('</body>', $logData.'</body>', $content);
}

