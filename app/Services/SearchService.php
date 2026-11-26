<?php

namespace App\Services;

class SearchService
{
    /**
     * Common search and pagination for different models.
     */
    public function search(
        string $model,
        array $columns,
        ?string $search = null,
        int $perPage = 5,
        string $orderBy = 'id',
        string $direction = 'desc',
        ?string $status = null
    ) {
        $query = $model::query();
        if (!empty($search)) {
            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $index => $column) {
                    if ($index === 0) {
                        $q->where($column, 'LIKE', "%{$search}%");
                    } else {
                        $q->orWhere($column, 'LIKE', "%{$search}%");
                    }
                }
            });
        }
        if (in_array($status, ['Active', 'Inactive'], true)) {
            $query->where('status', $status);
        }

        return $query
            ->orderBy($orderBy, $direction)
            ->paginate($perPage)
            ->withQueryString();
    }
}