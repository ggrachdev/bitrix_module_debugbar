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
    });
