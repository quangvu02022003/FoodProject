<?php
namespace App\Helper;

class Pagination {
    private $totalItems;
    private $itemsPerPage;
    private $currentPage;
    private $totalPages;

    public function __construct($totalItems, $itemsPerPage = 6, $currentPage = 1) {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = max(1, $currentPage);
        $this->totalPages = ceil($totalItems / $itemsPerPage);
    }

    public function getOffset() {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    public function getLimit() {
        return $this->itemsPerPage;
    }

    public function getTotalPages() {
        return $this->totalPages;
    }

    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function hasNextPage() {
        return $this->currentPage < $this->totalPages;
    }

    public function hasPreviousPage() {
        return $this->currentPage > 1;
    }
} 