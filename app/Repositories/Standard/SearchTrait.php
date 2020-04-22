<?php

namespace App\Repositories\Standard;

use Carbon\Carbon;

trait SearchTrait
{
    protected function searchByField($data, $type)
    {
        if (!isset($data[$type])) {
            return;
        }

        $list = explode(",", $data[$type]);
        $this->model->whereIn($type, $list);
    }

    protected function searchByData($data, $type)
    {
        if (!isset($data[$type])) {
            return;
        }

        $list = explode(",", $data[$type]);
        $dateIn = Carbon::createFromFormat('Y-m-d H:i:s', $list[0])->format('Y-m-d H:i:s');

        if (count($list) > 1) {
            $dateOut = Carbon::createFromFormat('Y-m-d H:i:s', $list[1])->format('Y-m-d H:i:s');
            $this->model->whereBetween($type, [$dateIn, $dateOut]);
            return;
        }

        $this->model->where($type, '>=', $dateIn);
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
            return;
        }

        $this->model->limit($data['limit']);
    }
}
