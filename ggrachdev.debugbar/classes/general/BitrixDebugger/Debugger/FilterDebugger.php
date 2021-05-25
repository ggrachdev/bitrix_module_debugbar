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

    /**
     * Вызов добавленного пользователем фильтра
     * 
     * @param type $name
     * @param type $arguments
     * @return $this
     * @throws \BadMethodCallException
     */
    public function __call($name, $arguments) {
        
        if($this->getFiltrator()->hasFilter($name))
        {
            $this->getFiltrator()->addFilter($name, $arguments);
        }
        else
        {
            throw new \BadMethodCallException('Not found '.$name.' method');
        }
        
        return $this;
    }

    public function getFiltrator(): FiltratorContract {
        return $this->filtrator;
    }

    public function addFilter(string $nameMethod, callable $callback): self {
        $this->getFiltrator()->addFilterRule($nameMethod, $callback);
        return $this;
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

}
