<?php

namespace App\Traits;

trait Filter
{
    protected $filterSeparator = ',';

    protected $filters;

    public function setFilterSeparator($separator)
    {
        $this->filterSeparator = $separator;
    }

    public function getFilterable()
    {
        $model = $this->getModel();

        return property_exists($model, 'filterable')
            ? $model::$filterable
            : $this->getFields();
    }

    public function getFilters($filters)
    {
        $this->filters = [];

        if ( ! $filters) {
            return $this;
        }

        $fields = $this->getFilterable();

        foreach ($filters as $filter) {
            $filter = explode($this->filterSeparator, $filter);

            if (in_array($filter[0], $fields)) {
                $this->filters[] = [
                    'field'    => $filter[0],
                    'value'    => $filter[1],
                    'operator' => count($filter) == 3 ? $filter[2] : '='
                ];
            }
        }

        return $this;
    }

    public function applyFilters($query)
    {
        if ( ! count($this->filters)) {
            return $query;
        }

        foreach ($this->filters as $filter) {
            $query->where($filter['field'], $filter['operator'], $filter['value']);
        }

        return $query;
    }
}
