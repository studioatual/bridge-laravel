<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\SearchTrait;
use App\Models\Company;
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
        $data = $this->filterData();

        $this->getFields($data);
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
        $data = $this->filterData();
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
        $data = $this->filterData();
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

    private function filterData()
    {
        $data = [];

        foreach (array_filter(request()->all()) as $key => $value) {
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
                'name' => 'max:100',
                'cnpj' => ['cnpj', Rule::unique('companies')->ignore($company)],
            ];
        } else {
            $rules = [
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
            'cnpj' => 'CNPJ é inválido!',
            'max' => 'Máximo de :max caracteres!',
            'unique' => ':input já em uso!'
        ];
    }
}
