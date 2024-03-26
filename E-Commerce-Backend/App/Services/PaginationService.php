<?php

namespace App\Services;

class PaginationService
{

    public static function getPaginationLine(int $currentPage, int $itemsPerPage): string
    {
        $offset = ($currentPage - 1) * $itemsPerPage;
        return "OFFSET {$offset} ROWS FETCH NEXT {$itemsPerPage} ROWS ONLY";
    }

}