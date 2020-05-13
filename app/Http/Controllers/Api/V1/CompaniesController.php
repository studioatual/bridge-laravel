<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\SearchTrait;
use App\Models\Company;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompaniesController extends Controller
{
    use SearchTrait;

    protected $model;

    public function __construct()
    {
        $this->model = DB::table('companies');
    }

    public function index()
    {
        $data = $this->filterData(request()->all());

        $this->getFields($data, '*');
        $this->searchByField($data, 'id');
        $this->searchByField($data, 'group_id');
        $this->searchLikeField($data, 'company');
        $this->searchLikeField($data, 'name');
        $this->searchByField($data, 'code');
        $this->searchByField($data, 'cnpj');
        $this->searchByField($data, 'ie');
        $this->searchByData($data, 'created_at');
        $this->searchByData($data, 'updated_at');
        $this->getOffset($data);
        $this->getLimit($data);

        return $this->model->get();
    }

    public function storeBatches()
    {
        $params = request()->all();

        if (!isset($params['companies'])) {
            return response()->json(['message' => 'É necessário enviar as empresas!'], 422);
        }

        $errors = [];
        foreach ($params['companies'] as $item) {
            $data = $this->filterData($item);

            $validator = Validator::make($data, $this->getRulesStoreBatches(), $this->getMessages());

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

        foreach ($params['companies'] as $item) {
            $data = $this->filterData($item);
            $group = Group::where('cnpj', $data['group'])->first();
            $group->companies()->create($data);
        }

        return response()->json(['result' => 'ok']);
    }

    public function destroyAll()
    {
        $params = request()->all();

        if (!isset($params['groups'])) {
            return response()->json(['message' => 'É necessário o CNPJ do Grupo'], 422);
        }

        foreach ($params['groups'] as $group) {
            $group = Group::where('cnpj', preg_replace('/\D/', '', $group))->first();

            if ($group) {
                foreach ($group->companies as $company) {
                    $company->delete();
                }
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

        if (isset($data['group'])) {
            $data['group'] = preg_replace('/[^\d\,]/', '', $data['cnpj']);
        }

        return $data;
    }

    public function getRulesStoreBatches()
    {
        return [
            'group' => 'required|exists:groups,cnpj',
            'company' => 'required|max:100',
            'name' => 'required|max:100',
            'cnpj' => 'required|cpf_cnpj|unique:companies',
        ];
    }

    public function getMessages()
    {
        return [
            'required' => 'O campo é obrigatório!',
            'exists' => 'Não existe esse grupo.',
            'cnpj' => 'CNPJ é inválido!',
            'max' => 'Máximo de :max caracteres!',
            'unique' => ':input já em uso!'
        ];
    }
}
