<?php

namespace GGrach\Filtrator;

/**
 *
 * @author ggrachdev
 */
interface FiltratorContract {
    public function filtrate($data);
    
    public function addCustomFilter(string $filterName, callable $callback);
    
    public function hasCustomFilter(string $filterName);
    
    public function customFiltrateItem(string $filterType, array $filterParams, $data);
    
    public function filtrateItem(string $filterType, array $filterParams, $data);
    
    public function addFilter(string $filterType, array $filterParams): void;
    
    public function hasFilter(string $filterType): bool;
    
    public function clearFilters(): void;
}