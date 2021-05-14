<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\Filtrator\FiltratorContract;

/**
 * Ответственность: фильтрация входящих данных для дебага
 *
 * @author ggrachdev
 */
class FilterDebugger extends ConfigurationDebugger {

    /**
     * @var FiltratorContract
     */
    protected $filtrator;

    /**
     * @var bool Не нужно сбрасывать фильтр после каждой операции логирования?
     */
    protected $isFreezedFilter = false;

    public function getFiltrator(): FiltratorContract {
        return $this->filtrator;
    }

    public function setFiltrator(FiltratorContract $filtrator): self {
        $this->filtrator = $filtrator;
        return $this;
    }

    public function resetFilter(): self {
        if (!$this->isFreezedFilter()) {
            $this->getFiltrator()->clearFilters();
        }
        return $this;
    }

    public function isFreezedFilter(): bool {
        return $this->isFreezedFilter === true;
    }

    public function unfreezeFilter(): self {
        $this->isFreezedFilter = false;
        return $this;
    }

    public function freezeFilter(): self {
        $this->isFreezedFilter = true;
        return $this;
    }

    public function filtrateItem($itemData) {
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

    public function keys(array $availableKeys): self {
        $this->getFiltrator()->addFilter('keys', [
            'keys' => $availableKeys
        ]);
        return $this;
    }

    public function limit(int $limit = 10): self {
        $this->getFiltrator()->addFilter('limit', [
            'count' => $limit
        ]);
        return $this;
    }

}
