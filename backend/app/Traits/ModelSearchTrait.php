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
        //
    }

    protected function searchQueryDefault($query, $request)
    {
        //
    }

    public function scopeSearch($query, $request = null)
    {
        $request = $this->searchParamsDefault($request);
        $this->searchQueryDefault($query, $request);
        $this->searchQuery($query, $request);
        return $query;
    }

    public function scopeSearchPaginated($query, $request = null)
    {
        $request = $this->searchParamsDefault($request);
        $this->searchQuery($query, $request);
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
