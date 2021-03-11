<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\Filtrator\FiltratorContract;

/**
 * Ответственность: фильтрация входящих данных для дебага
 *
 * @author ggrachdev
 */
class FilterDebugger extends ConfigurationDebugger {

    protected FiltratorContract $filtrator;

    public function getFiltrator(): FiltratorContract {
        return $this->filtrator;
    }

    public function setFiltrator(FiltratorContract $filtrator): self {
        $this->filtrator = $filtrator;
        return $this;
    }

    public function resetFilter(): self {
        $this->getFiltrator()->clearFilters();
        return $this;
    }

    public function filtrateItem(array $itemData): array {
        return $this->getFiltrator()->filtrate($itemData);
    }

    public function first(): self {
        $this->getFiltrator()->addFilter('first');
        return $this;
    }

    public function last(): self {
        $this->getFiltrator()->addFilter('last');
        return $this;
    }

    public function limit(int $limit = 10): self {
        $this->getFiltrator()->addFilter('limit', [
            'count' => $limit
        ]);
        return $this;
    }

}
