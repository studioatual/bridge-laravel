<?php

namespace App\Repositories\Standard;

use App\Models\Standard\Group;
use Illuminate\Support\Facades\DB;

class GroupRepository
{
    use SearchTrait;

    protected $model;

    public function __construct()
    {
        $this->model = DB::table('standard_groups');
    }

    public function index($request)
    {
        $data = array_filter($request->all());

        $this->searchByField($data, 'cnpj');
        $this->searchByField($data, 'code');
        $this->searchByField($data, 'active');
        $this->searchByData($data, 'created_at');
        $this->searchByData($data, 'updated_at');
        $this->getOffset($data);
        $this->getLimit($data);

        return $this->model->get();
    }

    public function store($request)
    {
        return Group::create($this->filterData($request->all()));
    }

    public function update($request, $model)
    {
        $model->update($this->filterData($request->all()));
        return $model;
    }

    public function destroy($model)
    {
        $model->delete();
        return json_encode(['result' => 'ok']);
    }

    public function filterData($data)
    {
        $data = array_filter($data);

        if (isset($data['cnpj'])) {
            $data['cnpj'] = preg_replace('/\D/', '', $data['cnpj']);
        }

        return $data;
    }
}
