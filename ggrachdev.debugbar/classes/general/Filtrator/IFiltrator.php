<?php

namespace GGrach\Filtrator;

interface IFiltrator {
    public function filtrate($data);
    
    public function hasFilter(string $filterType): bool;
    
    public function addCustomFilter(string $filterName, callable $callback): self;
    
    public function addFilterInSequence(string $filterType, array $filterParams = []): bool;
    
    public function filtrateItem(string $filterType, array $filterParams, $data);
    
    public function clearFilters(): void;
}