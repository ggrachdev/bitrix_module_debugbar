<?php

namespace GGrach\Filtrator;

use \GGrach\Filtrator\IFiltrator;

/**
 * @author ggrachdev
 */
class Filtrator implements IFiltrator {

    private $customFilters = [];

    /**
     * Очередь фильтров с параметрами
     * 
     * @var array
     */
    protected $sequenceFilters;

    public function clearFilters(): void {
        $this->sequenceFilters = [];
    }

    public function filtrate($data) {
        if (!empty($this->sequenceFilters) && !empty($data)) {
            foreach ($this->sequenceFilters as $arFilter) {
                $data = $this->filtrateItem($arFilter['type'], $arFilter['params'], $data);
            }
        }

        return $data;
    }

    public function addFilterInSequence(string $filterType, array $filterParams = []): bool {
        if ($this->hasFilter($filterType)) {
            $this->sequenceFilters[] = [
                'type' => $filterType,
                'params' => $filterParams
            ];
            return true;
        }
        
        return false;
    }

    public function hasFilter(string $filterType): bool {
        return \array_key_exists($filterType, $this->customFilters);
    }

    public function addCustomFilter(string $filterName, callable $callback): IFiltrator {
        if (!$this->hasFilter($filterName)) {
            $this->customFilters[$filterName] = $callback;
        }

        return $this;
    }

    public function filtrateItem(string $filterType, array $filterParams, $data) {
        return $this->customFilters[$filterType]($data, $filterParams);
    }

}
