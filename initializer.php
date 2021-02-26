<?php

/**
 * https://github.com/ggrachdev/BitrixDebugger
 * @author ggrachdev@yandex.ru
 * @version 0.03 beta
 * 
 * Пример дебага:
 * 
 * DD()->notice('Моя переменная', 'Моя переменная 2');
 * DD()->error('Моя переменная', 'Моя переменная 2');
 * DD()->warning('Моя переменная', 'Моя переменная 2');
 * DD()->success('Моя переменная', 'Моя переменная 2');
 * 
 * Залогировать в файлы
 * DD()->noticeLog('Моя переменная', 'Моя переменная 2');
 * DD()->errorLog('Моя переменная', 'Моя переменная 2');
 * DD()->warningLog('Моя переменная', 'Моя переменная 2');
 * DD()->successLog('Моя переменная', 'Моя переменная 2');
 * 
 * Нужно подключить этот файл в init.php
 * include 'BitrixDebugger/initializer.php';
 * 
 */
if (\php_sapi_name() === 'cli') {
    include 'initializers/cli.php';
} else {
    include 'initializers/server.php';
}