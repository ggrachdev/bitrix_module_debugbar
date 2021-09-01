<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator;

/**
 * Ответственность: добавление логов для дебаг-бара
 *
 * @author ggrachdev
 */
class NoticeDebugger extends FilterDebugger {

    protected $log = [];

    /*
     * Заголовок для дебага
     */
    protected $nameDebug = null;

    public function name(string $name, $items = [], ...$moreItems) {
        
        static $replacePlaceholder = null;
        
        if($replacePlaceholder === null)
        {
            $replacePlaceholder = function ($string, $replaced, $placeholder = '?') {
                $pos = strpos($string, $placeholder);
                if ($pos !== false) {
                    $string = substr_replace($string, $replaced, $pos, strlen($placeholder));
                }

                return $string;
            };
        }
        
        if(!empty($items) && \is_array($items)) {
            foreach ($items as $item) {
                if(\is_string($item) || \is_numeric($item))
                {
                    $name = $replacePlaceholder($name, $item);
                }
            }
        }
        else if(\is_string($items) || \is_numeric($items))
        {
            echo '<pre>';
            print_r($items);
            echo '</pre>';
            $name = $replacePlaceholder($name, $items);
        }
        
        if(!empty($moreItems)) {
            foreach ($moreItems as $item) {
                if(\is_string($item) || \is_numeric($item))
                {
                    $name = $replacePlaceholder($name, $item);
                }
            }
        }
        
        $this->nameDebug = $name;
        return $this;
    }

    public function notice(...$item) {
        $this->noticeRaw('notice', $item);
        return $this;
    }

    public function error(...$item) {
        $this->noticeRaw('error', $item);
        return $this;
    }

    public function warning(...$item) {
        $this->noticeRaw('warning', $item);
        return $this;
    }

    public function success(...$item) {
        $this->noticeRaw('success', $item);
        return $this;
    }

    /**
     * Получить лог
     * 
     * @global type $APPLICATION
     * @param bool $needAddSystemData - Нужно ли вернуть так же системные поля
     * @return array
     */
    public function getLog(bool $needAddSystemData = false): array {

        if ($needAddSystemData) {
            global $APPLICATION;

            $log = $this->log;

            if (!empty($_GET)) {
                $log['GET'] = [
                    [
                        'file' => '',
                        'line' => '',
                        'data' => [
                            $_GET
                        ]
                    ]
                ];
            }

            if (!empty($_POST)) {
                $log['POST'] = [
                    [
                        'file' => '',
                        'line' => '',
                        'data' => [
                            $_POST
                        ]
                    ]
                ];
            }

            if (!empty($_COOKIE)) {
                $log['COOKIE'] = [
                    [
                        'file' => '',
                        'line' => '',
                        'data' => [
                            $_COOKIE
                        ]
                    ]
                ];
            }

            if (!empty($_SERVER)) {
                $log['SERVER'] = [
                    [
                        'file' => '',
                        'line' => '',
                        'data' => [
                            $_SERVER
                        ]
                    ]
                ];
            }

            if (!empty($APPLICATION->GetPagePropertyList())) {
                $log['BX'] = [
                    [
                        'file' => '',
                        'line' => '',
                        'data' => [
                            [
                                'PAGE_PROPERTIES' => $APPLICATION->GetPagePropertyList(),
                                'DIR_PROPERTIES' => $APPLICATION->GetDirPropertyList()
                            ]
                        ]
                    ]
                ];
            }

            return $log;
        } else {
            return $this->log;
        }
    }

    /**
     * Кастомизированное уведомление
     * 
     * @param string $typeNotice
     * @param type $item
     */
    public function debug(string $typeNotice, ...$item) {
        $this->noticeRaw($typeNotice, $item);
        return $this;
    }

    public function noticeRaw(string $type, array $arLogItems) {

        if (!empty($arLogItems)) {
            foreach ($arLogItems as &$item) {
                $item = $this->filtrateItem($item);
            }
        }

        if (ShowModeDebuggerValidator::needShowInDebugBar($this->getConfiguratorDebugger())) {

            if (!\array_key_exists($type, $this->getLog())) {
                $this->log[$type] = [];
            }

            $db = debug_backtrace();

            $this->log[$type][] = [
                'name' => $this->nameDebug,
                'file' => $db[1]['file'],
                'line' => $db[1]['line'],
                'data' => $arLogItems
            ];
        }

        if (ShowModeDebuggerValidator::needShowInCode($this->getConfiguratorDebugger())) {

            foreach ($arLogItems as $item) {
                echo \ggrach_highlight_data($item, true, $this->nameDebug);
            }
        }

        // Сбрасываем имя
        $this->nameDebug = null;
        $this->resetFilter();

        return $this;
    }

}
