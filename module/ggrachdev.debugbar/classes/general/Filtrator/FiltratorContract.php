<?php

namespace GGrach\Filtrator;

/**
 *
 * @author ggrachdev
 */
interface FiltratorContract {
    public function filtrate(array $data): array;
    
    public function filtrateItem(string $filterType,array $data): array;
    
    public function addFilter(string $filterType, array $filterParams): void;
    
    public function hasFilter(string $filterType): bool;
    
    public function clearFilters(): void;
}