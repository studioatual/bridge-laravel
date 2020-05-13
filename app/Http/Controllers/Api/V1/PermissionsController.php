<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\SearchTrait;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{
    use SearchTrait;

    protected $model;

    public function __construct()
    {
        $this->model = DB::table('permissions');
    }

    public function index()
    {
        $data = $this->filterData();

        $this->getFields($data, '*');
        $this->searchByField($data, 'id');
        $this->searchByField($data, 'name');
        $this->searchByField($data, 'code');
        $this->searchLikeField($data, 'description');
        $this->searchByField($data, 'active');
        $this->searchByData($data, 'created_at');
        $this->searchByData($data, 'updated_at');
        $this->getOffset($data);
        $this->getLimit($data);

        return $this->model->get();
    }

    public function storeBatches()
    {
        $params = request()->all();

        if (!$params['permissions']) {
            return response()->json(['É necessário enviar as permissões'], 422);
        }

        $errors = [];
        foreach ($params['permissions'] as $item) {
            $data = $this->filterData($item);
            $validator = Validator::make($data, $this->getRules(), $this->getMessages());

            if ($validator->fails()) {
                $errors[] = [
                    'fields' => $item,
                    'errors' => $validator->errors()
                ];
            }
        }

        if (count($errors)) {
            return response()->json($errors, 422);
        }

        foreach ($params['permissions'] as $item) {
            $data = $this->filterData($item);
            Permission::create($data);
        }

        return response()->json(['result' => 'ok']);
    }

    public function destroyAll()
    {
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $permission->delete();
        }
        return response()->json(['result' => 'ok']);
    }

    private function filterData($item)
    {
        $data = [];

        foreach (array_filter($item) as $key => $value) {
            $data[$key] = trim(strip_tags($value));
        }

        return $data;
    }

    public function getRules()
    {
        $rules = [
            'name' => 'required|max:30',
            'description' => 'required|max:100',
        ];

        return $rules;
    }

    public function getMessages()
    {
        return [
            'required' => 'O campo é obrigatório!',
            'max' => 'Máximo de :max caracteres!'
        ];
    }
}
