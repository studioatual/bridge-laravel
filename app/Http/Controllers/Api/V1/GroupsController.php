<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\SearchTrait;
use App\Models\Group;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GroupsController extends Controller
{
    use SearchTrait;

    protected $model;

    public function __construct()
    {
        $this->model = DB::table('groups');
    }

    public function index()
    {
        $data = $this->filterData(request()->all());

        $this->getFields($data, '*');
        $this->searchByField($data, 'id');
        $this->searchLikeField($data, 'name');
        $this->searchByField($data, 'code');
        $this->searchByField($data, 'cnpj');
        $this->searchByField($data, 'type');
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
        if (!isset($params['groups'])) {
            return response()->json(['message' => 'É necessário enviar os grupos!']);
        }

        $errors = [];
        foreach ($params['groups'] as $item) {
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

        foreach ($params as $item) {
            $data = $this->filterData($item);
            Group::create($data);
        }

        return response()->json(['result' => 'ok']);
    }

    public function destroyAll()
    {
        $groups = Group::all();
        foreach ($groups as $group) {
            if ($group->id != 1) {
                $group->delete();
            }
        }
        return response()->json(['result' => 'ok']);
    }

    private function filterData($inputs)
    {
        $data = [];
        $list = array_filter((array) $inputs, 'strlen');

        foreach ($list as $key => $value) {
            $data[$key] = trim(strip_tags($value));
        }

        if (isset($data['cnpj'])) {
            $data['cnpj'] = preg_replace('/[^\d\,]/', '', $data['cnpj']);
        }

        return $data;
    }

    public function getRules(Group $group = null)
    {
        return [
            'name' => 'required|max:100',
            'cnpj' => 'required|cnpj|unique:groups',
        ];
    }

    public function getMessages()
    {
        return [
            'required' => 'O campo é obrigatório!',
            'cnpj' => 'CNPJ é inválido!',
            'max' => 'Máximo de :max caracteres!',
            'unique' => ':input já em uso!'
        ];
    }
}
