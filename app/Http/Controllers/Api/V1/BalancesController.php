<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\SearchTrait;
use App\Models\Balance;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BalancesController extends Controller
{
    use SearchTrait;

    protected $model;

    public function __construct()
    {
        $this->model = DB::table('balances');
    }

    public function index()
    {
        $data = $this->filterData();

        $this->getFields($data);
        $this->searchByField($data, 'id');
        $this->searchLikeField($data, 'description');
        $this->searchByField($data, 'company_id');
        $this->searchByField($data, 'type');
        $this->searchByValue($data, 'value');
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

        $company = Company::where('cnpj', $data['cnpj'])->first();

        return $company->balances()->create($data);
    }

    public function show(Balance $balance)
    {
        return $balance;
    }

    public function update(Balance $balance)
    {
        $data = $this->filterData();
        $validator = Validator::make($data, $this->getRules(), $this->getMessages());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$data) {
            return response()->json(['message' => 'É necessário enviar parametros!'], 422);
        }

        $balance->update($data);
        return $balance;
    }

    public function destroy(Balance $balance)
    {
        $balance->delete();
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

    public function getRules()
    {
        $rules = [
            'cnpj' => 'required|cnpj|exists:companies,cnpj',
            'description' => 'required|max:100',
            'type' => 'required',
            'value' => 'required'
        ];

        return $rules;
    }

    public function getMessages()
    {
        return [
            'required' => 'O campo é obrigatório!',
            'cnpj' => 'CNPJ é inválido!',
            'max' => 'Máximo de :max caracteres!',
            'exists' => 'Não existe essa Empresa!',
        ];
    }
}
