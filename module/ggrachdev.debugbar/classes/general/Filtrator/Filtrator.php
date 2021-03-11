<?php

namespace GGrach\Filtrator;

use \GGrach\Filtrator\FiltratorContract;

/**
 * Фильтратор данных
 *
 * @author ggrachdev
 */
class Filtrator implements FiltratorContract {

    public const FILTERS_NAME = [
        'limit', 'first', 'last'
    ];

    protected array $filters;

    public function addFilter(string $filterType, array $filterParams = []): void {
        if ($this->hasFilter($filterType)) {
            $this->filters[] = [
                'type' => $filterType,
                'params' => $filterParams
            ];
        }
    }

    protected function filtrateItem(string $filterType, array $filterParams, array $data): array {
        switch ($filterType) {
            case 'limit':
                if (empty($filterParams['count'])) {
                    $filterParams['count'] = 10;
                }
                $data = array_slice($data, 0, $filterParams['count'], true);
                break;
            case 'first':
                if (!empty($data[0])) {
                    $data = $data[0];
                }
                break;
            case 'last':
                if (!empty($data)) {
                    $data = $data[sizeof($data) - 1];
                }
                break;
        }

        return $data;
    }

    public function clearFilters(): void {
        $this->filters = [];
    }

    public function filtrate(array $data): array {
        if (!empty($this->filters)) {
            foreach ($this->filters as $arFilter) {
                $data = $this->filtrateItem($arFilter['type'], $arFilter['params'], $data);
            }
        }

        return $data;
    }

    public function hasFilter(string $filterType): bool {
        return \in_array($filterType, self::FILTERS_NAME);
    }

}
