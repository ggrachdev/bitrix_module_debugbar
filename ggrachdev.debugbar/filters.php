<?php

DD()->addFilter('values', function ($data, $filterParams) {
        if (\is_array($data)) {
            return \array_values($data);
        } else {
            return $data;
        }
    })
    ->addFilter('limit', function ($data, $filterParams) {
        if (\is_array($data) && !empty($data)) {
            if (empty($filterParams[0]) || !\is_numeric($filterParams[0]) || $filterParams[0] < 1) {
                $count = 10;
            } else {
                $count = $filterParams[0];
            }
            $data = array_slice($data, 0, $count, true);
        }

        return $data;
    })
    ->addFilter('first', function ($data, $filterParams) {
        if (\is_array($data) && !empty($data)) {
            $data = array_shift($data);
        }

        return $data;
    })
    ->addFilter('methods', function ($data, $filterParams) {
        if (\is_object($data)) {
            $data = \get_class_methods($data);
        }

        return $data;
    })
    ->addFilter('classPath', function ($data, $filterParams) {
        if (\is_object($data) || \class_exists($data)) {
            $reflectionClass = new \ReflectionClass($data);
            $data = [
                'file_name' => $reflectionClass->getFileName(),
                'start_line' => $reflectionClass->getStartLine()
            ];
        }

        return $data;
    })
    ->addFilter('props', function ($data, $filterParams) {
        if (\is_object($data)) {
            $data = \get_object_vars($data);
        }

        return $data;
    })
    ->addFilter('keys', function ($data, $filterParams) {
        if (
            !empty($data) &&
            is_array($data) &&
            !empty($filterParams[0]) &&
            \is_array($filterParams[0])
        ) {
            $newData = [];

            foreach ($data as $k => $v) {
                if (\in_array($k, $filterParams[0])) {
                    $newData[$k] = $v;
                }
            }

            $data = $newData;
        }

        return $data;
    })
    ->addFilter('last', function ($data, $filterParams) {
        if (\is_array($data) && !empty($data)) {
            $data = array_pop($data);
        }

        return $data;
    })
    ->addFilter('filter', function ($data, $filterParams) {
        if (!empty($filterParams[0]) && \is_callable($filterParams[0])) {
            $data = $filterParams[0]($data);
        }

        return $data;
    })
    // bitrix
    ->addFilter('bxDisplayProps', function ($data, $filterParams) {
        if (\is_array($data)) {
            $data = \array_key_exists('DISPLAY_PROPERTIES', $data) ? $data['DISPLAY_PROPERTIES'] : [];
        } else {
            $data = [];
        }

        return $data;
    })
    ->addFilter('bxProps', function ($data, $filterParams) {
        if (\is_array($data)) {
            $data = \array_key_exists('PROPERTIES', $data) ? $data['PROPERTIES'] : [];
        } else {
            $data = [];
        }

        return $data;
    })
    ->addFilter('bxItemsProps', function ($data, $filterParams) {
        if (\is_array($data)) {
            $data = \array_key_exists('ITEMS', $data) ? $data['ITEMS'] : [];

            if (!empty($data)) {
                $arProps = [];

                foreach ($data as $arItem) {
                    $arProps[$arItem['ID']] = [
                        'NAME' => $arItem['NAME'],
                        'PROPERTIES' => $arItem['PROPERTIES'],
                        'DISPLAY_PROPERTIES' => $arItem['DISPLAY_PROPERTIES']
                    ];
                }
            }
        } else {
            $data = [];
        }

        return $data;
    })
    ->addFilter('bxItemsIds', function ($data, $filterParams) {
        if (\is_array($data)) {
            $data = \array_key_exists('ITEMS', $data) ? $data['ITEMS'] : [];

            if (!empty($data)) {
                $data = array_column($data, 'ID');
            }
        } else {
            $data = [];
        }

        return $data;
    })
    ->addFilter('bxItems', function ($data, $filterParams) {
        if (\is_array($data)) {
            $data = \array_key_exists('ITEMS', $data) ? $data['ITEMS'] : [];
        } else {
            $data = [];
        }

        return $data;
    });
