<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ModelSearchTrait
{
    public function searchParams()
    {
        return [];
    }

    public function searchQuery($query, $request)
    {
        return $query;
    }

    protected function searchQueryDefault($query, $request)
    {
        return $query;
    }

    public function scopeSearch($query, $request = null)
    {
        $request = $this->searchParamsDefault($request);
        $query = $this->searchQueryDefault($query, $request);
        return $this->searchQuery($query, $request);
    }

    public function scopeSearchPaginated($query, $request = null)
    {
        $request = $this->searchParamsDefault($request);
        $query = $this->searchQuery($query, $request);
        $pagination = (array) $query->paginate($request->per_page)->toArray();

        return [
            'pagination' => [
                'current_page' => $pagination['current_page'],
                'from' => $pagination['from'],
                'last_page' => $pagination['last_page'],
                'per_page' => $pagination['per_page'],
                'to' => $pagination['to'],
                'total' => $pagination['total'],
            ],
            'data' => $pagination['data'],
            // 'sql' => $query->toSql(),
        ];
    }

    protected function searchParamsDefault($request = null)
    {
        if ($request === null) {
            $request = new Request;
        }

        if (is_array($request)) {
            $request = new Request($request);
        }

        $request->merge([
            'page' => 1,
            'per_page' => 20,
            'order_by' => 'id',
            'order' => 'desc',
        ]);

        $request->merge($this->searchParams());

        return $request;
    }
}
