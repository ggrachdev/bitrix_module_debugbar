Что это?
--------------------------  

BitrixDebugger - модуль для удобного дебага в 1с битрикс, которая позволяет выводить данные в дебаг-панель, логировать в файлы, выводить дебаг-данные на месте вызова соответствующей функции. Выводит количество SQL запросов на странице.

Зачем вам это?
--------------------------  

Из проекта в проект я видел картину, что каждый разработчик реализует свою дебаг-функцию, которая в целом делает то же самое - вывод код внутри тега \<pre\>. Согласитесь, было бы удобнее скачать библиотеку и настроить в IDE сниппеты для нее

Как установить?
--------------------------  
(Только для сайтов с кодировкой UTF-8) Скопируйте папку ggrachdev.debugbar и положите в /bitrix/modules или в /local/modules и выполните стандартную установку и подключите модуль в init.php:

```php
<?php

\Bitrix\Main\Loader::includeModule('ggrachdev.debugbar');
```
Теперь вам будут доступны все нижеописанные функции для дебага данных.

Как пользоваться?
--------------------------  
Чтобы получить дебаг-данные в дебаг-панели введите в любом месте в коде (данные будут отображены в разных вкладках панели):
```php
<?php

DD()->notice('Моя переменная', 'Моя переменная 2');
DD()->error('Моя переменная', 'Моя переменная 2');
DD()->warning('Моя переменная', 'Моя переменная 2');
DD()->success('Моя переменная', 'Моя переменная 2', 'Моя переменная 3', ['test' => [
    'testSubKey1' => [
        1,2,3
    ],
    'testSubKey2' => [
        1,2,3
    ],
    'testSubKey3' => [
        1,2,3
    ]
]]);

// Можно осуществлять цепочку вызовов
DD()->notice('Моя переменная', 'Моя переменная 2')->error(/*...*/)->notice(/*...*/)->...;

// Можно дебажить без вызова notice явно (просто передав параметры в DD() - идентично notice):
DD('Моя переменная', 'Моя переменная 2')->error(/*...*/)->...;
```

Так же можно логировать дебаг-данные в файлы (Эти данные не будут отображены в дебаг-панели и будут записываться в файлы при хите):
```php
<?php

DD()->noticeLog('Моя переменная', 'Моя переменная 2');
DD()->errorLog('Моя переменная', 'Моя переменная 2');
DD()->warningLog('Моя переменная', 'Моя переменная 2');
DD()->successLog('Моя переменная', 'Моя переменная 2', 'Моя переменная 3');
```

Имеется возможность выводить дебаг-данные не в дебаг-баре а на месте вызова, настроить можно в любом месте в коде, например в init.php:

```php
// Показывать дебаг на месте вызова
DD()->getConfiguratorDebugger()->showDebugInCode();

// Не gоказывать дебаг на месте вызова
DD()->getConfiguratorDebugger()->notShowDebugInCode();

// Не показывать дебаг-бар
DD()->getConfiguratorDebugger()->notShowDebugPanel();

// Показывать дебаг-бар
DD()->getConfiguratorDebugger()->showDebugPanel();

// Можно осуществлять цепочку вызовов:
DD()->getConfiguratorDebugger()->notShowDebugPanel()->showDebugInCode();
```

Настройте папку для логирования в файлы следующим образом куда вам удобно:
```php
<?php

DD()->getConfiguratorDebugger()->setLogPath('error', __DIR__ . '/error.log')
    ->setLogPath('warning', __DIR__ . '/warning.log')
    ->setLogPath('success', __DIR__ . '/success.log')
    ->setLogPath('notice', __DIR__ . '/notice.log');
```

Чтобы настроить разделитель между логами в файле как вам удобно сделайте следующее (указано значение по умолчанию):
```php
<?php

DD()->getConfiguratorDebugger()->setLogChunkDelimeter("\n======\n");
```

Фильтрация, отсечение элементов
-------------------------- 
```php
<?php
// Будет дебаг только переменной под 0 индексом (1)
DD()->first()->notice([1,2,3,4,5]);

// Будет дебаг только переменной под 0 индексом (1) и после чего 6,7,8
DD()->first()->notice([1,2,3,4,5])->notice([6,7,8]);

// Будет дебаг только переменной под 0 индексом всегда (1) и после чего только 6, так как "заморозили фильтр"
DD()->freezeFilter()->first()->notice([1,2,3,4,5])->notice([6,7,8]);

// Чтобы "разморозить" фильтр нужно:
DD()->unfreezeFilter();

// Фильтр можно сбросить:
DD()->limit(4)->last()->keys(['ALLOW_KEY_1', 'ALLOW_KEY_2'])->resetFilter();

// Будут браться всегда (так как freezeFilter) только первые 2 элемента данных, т.е [1,2] и [6,7]
DD()->freezeFilter()->limit(2)->notice([1,2,3,4,5])->notice([6,7,8]);

DD()->keys(['key1'])->error(['key1' => 123, 'key2' => 456]);

// Доступные фильтры:
DD()->first(); // Взять первый элемент
DD()->last(); // Взять последний элемент
DD()->limit(10); // Брать первые N элементов
DD()->keys(['key1', 'key2'/*...*/]); // Взять только определенные ключи
DD()->methods()->warning($USER); // Получить публичные методы объекта $USER
DD()->classPath()->warning($USER); // Получить массив с путем до файла класса $USER и линии начала класса (через рефлексию), можно передать <YOUR_CLASS>::class
DD()->props()->warning($USER); // Получить публичные свойства переданного объекта
DD()->filter(function ($item) {
    return sizeof($item); // 3
})->warning([1, 2, 3); // Профильтровать передаваемые данные через callable
DD()->name('Получить ITEMS в arResult')->bxItems()->notice($arResult);
DD()->name('Получить PROPERTIES в arResult')->bxProps()->notice($arResult);
DD()->name('Получить DISPLAY PROPERTIES в arResult')->bxDisplayProps()->notice($arResult);
DD()->name('Получить DISPLAY PROPERTIES в ITEMS arResult')->bxItems()->bxDisplayProps()->notice($arResult);
```
Именованный дебаг
-------------------------- 
Чтобы выделить блок с данными можно дать ему имя:
```php
DD()->name('Методы объекта USER')->methods()->warning($USER);
DD()->name('Свойства объекта USER')->props()->warning($USER)->name('arResult шаблона компонента')->warning($arResult);
```
Добавление собственных фильтров
-------------------------- 
```php
// Пример добавления двух фильтров
DD()->addFilter('random', function ($data, $filterParams) {
    if(\is_array($data))
    {
        return $data[\array_rand($data)];
    }
    else
    {
        return $data;
    }
});

DD()->addFilter('values', function ($data, $filterParams) {
    if(\is_array($data))
    {
        return \array_values($data);
    }
    else
    {
        return $data;
    }
});

DD()->random()->notice([
    1, 2, 3, 4
])->values()->warning(['key' => 222, 'key2' => 666]);

// Если хотите получить массив входных параметров внутри callable $filterParams, то передавайте параметры так:
DD()->random(['my_param' => 123, 'test', 'example_param'], 'param_2', 'param_3' /*...*/);

// Выведет в первом случае одно случайное число 1,2,3 или 4 при каждом хите
// При второй фильтрации выведет массив со сбросом ключей [222, 666]
// Если фильтр не найден, то получим BadMethodCallException

```

Прочая информация
-------------------------- 
Дебаг-панель видна только пользователям, которые являются администраторами.

Данные в дебаг-панели можно скрывать, раскрывать по ключам массива. Если присутствует переменная-строка и она больше 200 символов, то будет замена на [Очень длинный текст], так же у строк удаляются все html теги, чтобы исключить ошибки в отображении.

Тестировалась скорость формирования страницы с библиотекой и без, при ее наличии скорость дольше примерно на 0,01 сек., что не значительно замедляет проект.

Дебаг-панель:
![Image alt](https://github.com/ggrachdev/BitrixDebugger/raw/master/ggrachdev.debugbar/assets/images/git/example.png)
