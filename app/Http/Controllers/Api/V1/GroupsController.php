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

    public function store()
    {
        $groups = request()->input('groups');
        foreach ($groups as $group) {
            $data = $this->filterData($group);

            $validator = Validator::make($data, $this->getRules(), $this->getMessages());

            if ($validator->fails()) {
                return response()->json([
                    'fields' => $group,
                    'errors' => $validator->errors()
                ], 422);
            }
        }

        foreach ($groups as $group) {
            $data = $this->filterData($group);
            Group::create($data);
        }

        return response()->json(['result' => 'ok']);
    }

    /*
    public function store()
    {
        $data = $this->filterData();
        $validator = Validator::make($data, $this->getRules(), $this->getMessages());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return Group::create($data);
    }
    */

    public function show(Group $group)
    {
        return $group;
    }

    public function update(Group $group)
    {
        $data = $this->filterData(request()->all());
        $validator = Validator::make($data, $this->getRules($group), $this->getMessages());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$data) {
            return response()->json(['message' => 'É necessário enviar parametros!'], 422);
        }

        $group->update($data);
        return $group;
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return response()->json(['result' => 'ok']);
    }

    private function filterData($group)
    {
        $data = [];
        $list = array_filter((array) $group);

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
        if ($group) {
            $rules = [
                'name' => 'max:100',
                'cnpj' => ['cnpj', Rule::unique('groups')->ignore($group)],
            ];
        } else {
            $rules = [
                'name' => 'required|max:100',
                'cnpj' => 'required|cnpj|unique:groups',
            ];
        }

        return $rules;
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
