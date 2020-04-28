<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait SearchTrait
{
    protected function searchLikeField($data, $type)
    {
        if (!isset($data[$type])) {
            return;
        }

        $list = explode(",", $data[$type]);
        $this->model->where($type, 'like', '%' . $list . '%');
    }

    protected function searchByField($data, $type)
    {
        if (!isset($data[$type])) {
            return;
        }

        $list = explode(",", $data[$type]);
        $this->model->whereIn($type, $list);
    }

    protected function searchByValue($data, $type)
    {
        if (!isset($data[$type])) {
            return;
        }

        $list = explode(",", $data[$type]);

        if (count($list) > 1) {
            if ($list[0]) {
                $this->model->whereBetween($type, [$list[0], $list[1]]);
                return;
            }
            $this->model->where($type, '<=', $list[1]);
            return;
        }

        return $this->model->where($type, '>=', $list[0]);
    }

    protected function searchByData($data, $type)
    {
        if (!isset($data[$type])) {
            return;
        }

        $list = explode(",", $data[$type]);
        if ($list[0]) {
            $dateIn = Carbon::createFromFormat('Y-m-d H:i:s', $list[0])->format('Y-m-d H:i:s');
        }

        if (count($list) > 1) {
            $dateOut = Carbon::createFromFormat('Y-m-d H:i:s', $list[1])->format('Y-m-d H:i:s');
            if (isset($dateIn)) {
                return $this->model->whereBetween($type, [$dateIn, $dateOut]);
            }
            return $this->model->where($type, '<=', $dateOut);
        }
        return $this->model->where($type, '>=', $dateIn);
    }

    protected function getOffset($data)
    {
        if (!isset($data['offset'])) {
            return;
        }

        $this->model->offset($data['offset']);
    }

    protected function getLimit($data)
    {
        if (!isset($data['limit'])) {
            $data['limit'] = 10000;
        }

        $this->model->limit($data['limit']);
    }

    protected function getFields($data, $fields = '*')
    {
        if (!isset($data['fields'])) {
            $this->model->select($fields);
            return;
        }

        $list = explode(",", $data['fields']);
        $this->model->select($list);
    }
}
