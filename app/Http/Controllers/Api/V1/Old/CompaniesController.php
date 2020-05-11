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

    public function store()
    {
        $data = $this->filterData(request()->all());
        $validator = Validator::make($data, $this->getRules(), $this->getMessages());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return Company::create($data);
    }

    public function show(Company $company)
    {
        return $company;
    }

    public function update(Company $company)
    {
        $data = $this->filterData(request()->all());
        $validator = Validator::make($data, $this->getRules($company), $this->getMessages());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$data) {
            return response()->json(['message' => 'É necessário enviar parametros!'], 422);
        }

        $company->update($data);
        return $company;
    }

    public function destroy(Company $company)
    {
        $company->delete();
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

    public function getRules(Company $company = null)
    {
        if ($company) {
            $rules = [
                'group_id' => 'exists:groups,id',
                'company' => 'max:100',
                'name' => 'max:100',
                'cnpj' => ['cnpj', Rule::unique('companies')->ignore($company)],
            ];
        } else {
            $rules = [
                'group_id' => 'required|exists:groups,id',
                'company' => 'required|max:100',
                'name' => 'required|max:100',
                'cnpj' => 'required|cnpj|unique:companies',
            ];
        }

        return $rules;
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

    public function storeBatches()
    {
        $inputs = request()->input('companies');

        $errors = [];
        foreach ($inputs as $input) {
            $data = $this->filterData($input);

            $validator = Validator::make($data, $this->getRulesStoreBatches(), $this->getMessages());

            if ($validator->fails()) {
                $errors[] = [
                    'fields' => $input,
                    'errors' => $validator->errors()
                ];
            }
        }

        if (count($errors)) {
            return response()->json($errors, 422);
        }

        foreach ($inputs as $input) {
            $data = $this->filterData($input);
            $group = Group::where('cnpj', $data['group'])->first();
            $group->companies()->create($data);
        }

        return response()->json(['result' => 'ok']);
    }

    public function updateBatches()
    {
        $inputs = request()->input('companies');

        $errors = [];
        foreach ($inputs as $input) {
            $data = $this->filterData($input);

            $validator = Validator::make($data, $this->getRulesUpdateAndDestroyBatches(), $this->getMessages());

            if ($validator->fails()) {
                $errors[] = [
                    'fields' => $input,
                    'errors' => $validator->errors()
                ];
            }
        }

        if (count($errors)) {
            return response()->json($errors, 422);
        }

        foreach ($inputs as $input) {
            $data = $this->filterData($input);
            $company = Company::where('cnpj', $data['cnpj'])->first();
            $company->update($data);
        }

        return response()->json(['result' => 'ok']);
    }

    public function destroyBatches()
    {
        $inputs = request()->input('companies');

        $errors = [];
        foreach ($inputs as $input) {
            $data = $this->filterData($input);

            $validator = Validator::make($data, $this->getRulesUpdateAndDestroyBatches(true), $this->getMessages());

            if ($validator->fails()) {
                $errors[] = [
                    'fields' => $input,
                    'errors' => $validator->errors()
                ];
            }
        }

        if (count($errors)) {
            return response()->json($errors, 422);
        }

        foreach ($inputs as $input) {
            $data = $this->filterData($input);
            $company = Company::where('cnpj', $data['cnpj'])->first();
            $company->delete();
        }

        return response()->json(['result' => 'ok']);
    }

    public function destroyAll()
    {
        $cnpj = request()->input('group');
        if (!$cnpj) {
            return response()->json(['message' => 'É necessário o CNPJ do Grupo'], 422);
        }
        $cnpj = preg_replace('/[^\d\,]/', '', $cnpj);
        $group = Group::where('cnpj', $cnpj)->first();
        if (!$group) {
            return response()->json(['message' => 'Grupo não encontrado!'], 422);
        }
        foreach ($group->companies as $company) {
            $company->delete();
        }
        return response()->json(['result' => 'ok']);
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

    public function getRulesUpdateAndDestroyBatches($destroy = false)
    {
        $rules = $destroy ? [
            'group' => 'required|exists:groups,cnpj',
        ] : [
            'group' => 'required|exists:groups,cnpj',
            'company' => 'required|max:100',
            'name' => 'required|max:100',
            'cnpj' => 'required|cnpj|exists:companies,cnpj',
            'email' => 'required|email|exists:companies,email',
            'username' => 'required|max:100',
            'password' => 'required',
        ];
        return $rules;
    }
}
