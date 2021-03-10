<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator;

/**
 * Ответственность: добавление логов для дебаг-бара
 *
 * @author ggrachdev
 */
class NoticeDebugger extends ConfigurationDebugger {

    protected $log = [];

    public function notice(...$item) {
        return $this->noticeRaw('notice', $item);
    }

    public function error(...$item) {
        return $this->noticeRaw('error', $item);
    }

    public function warning(...$item) {
        return $this->noticeRaw('warning', $item);
    }

    public function success(...$item) {
        return $this->noticeRaw('success', $item);
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
     * @param type $typeNotice
     * @param type $item
     */
    public function debug($typeNotice, ...$item) {
        return $this->noticeRaw($typeNotice, $item);
    }

    protected function noticeRaw(string $type, $arLogItems) {

        if (ShowModeDebuggerValidator::needShowInDebugBar($this->getConfiguratorDebugger())) {

            if (!\array_key_exists($type, $this->getLog())) {
                $this->log[$type] = [];
            }

            $db = debug_backtrace();

            $this->log[$type][] = [
                'file' => $db[1]['file'],
                'line' => $db[1]['line'],
                'data' => $arLogItems
            ];
        }

        if (ShowModeDebuggerValidator::needShowInCode($this->getConfiguratorDebugger())) {

            foreach ($arLogItems as $item) {
                echo \ggrach_highlight_data($item);
            }
        }

        return $this;
    }

}
