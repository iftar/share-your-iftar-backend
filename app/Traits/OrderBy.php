<?php

namespace App\Traits;

trait OrderBy
{
    protected $orderBySeparator = ',';

    public function setOrderBySeparator($separator)
    {
        $this->orderBySeparator = $separator;
    }

    public function getOrderByFromRequest($request)
    {
        $orderByFields = [];

        if ($request->has('orderBy')) {
            $fields = $this->getFields();

            foreach ($request->get('orderBy') as $orderBy) {
                $orderBy = explode($this->orderBySeparator, $orderBy);

                if (in_array($orderBy[0], $fields)) {
                    $orderByFields[] = [
                        'field' => $orderBy[0],
                        'order' => count($orderBy) == 2 ? $orderBy[1] : 'ASC'
                    ];
                }
            }
        }

        return $orderByFields;
    }

    public function applyOrderBy($query, $orderByFields)
    {
        if ( ! $orderByFields) {
            return $query->latest('required_date');
        }

        foreach ($orderByFields as $orderBy) {
            $query->orderBy($orderBy['field'], $orderBy['order']);
        }

        return $query;
    }
}
