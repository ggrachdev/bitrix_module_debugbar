<?php

namespace GGrach\Filtrator;

interface FiltratorContract {
    public function filtrate($data);
    
    public function hasFilter(string $filterType): bool;
    
    public function addFilterRule(string $filterName, callable $callback): self;
    
    public function addFilter(string $filterType, array $filterParams = []): void;
    
    public function filtrateItem(string $filterType, array $filterParams, $data);
    
    public function clearFilters(): void;
}