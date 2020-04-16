<?php

namespace App\Traits;

trait Filter
{
    protected $filterSeparator = ',';

    public function setFilterSeparator($separator)
    {
        $this->filterSeparator = $separator;
    }

    public function getFiltersFromRequest($request)
    {
        $filters = [];

        if ($request->has('filter')) {
            $fields = $this->getFields();

            foreach ($request->get('filter') as $filter) {
                $filter = explode($this->filterSeparator, $filter);

                if (in_array($filter[0], $fields)) {
                    $filters[] = [
                        'field'    => $filter[0],
                        'value'    => $filter[1],
                        'operator' => count($filter) == 3 ? $filter[2] : '='
                    ];
                }
            }
        }

        return $filters;
    }

    public function applyFilters($query, $filters)
    {
        if ( ! $filters) {
            return $query;
        }

        foreach ($filters as $filter) {
            $query->where($filter['field'], $filter['operator'], $filter['value']);
        }

        return $query;
    }
}
