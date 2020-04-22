<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = DB::table('customers');
    }

    public function index()
    {
        $data = request()->all();

        $this->searchByData($data, 'created_at');
        $this->searchByData($data, 'updated_at');
        $this->getOffset($data);
        $this->getLimit($data);

        return $this->model->get();
    }

    private function searchByData($data, $type)
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

    private function getOffset($data)
    {
        if (!isset($data['offset'])) {
            return;
        }

        $this->model->offset($data['offset']);
    }

    private function getLimit($data)
    {
        if (!isset($data['limit'])) {
            return;
        }

        $this->model->limit($data['limit']);
    }
}
