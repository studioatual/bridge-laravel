<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Repositories\Standard\SearchTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    use SearchTrait;

    protected $model;

    public function __construct()
    {
        $this->model = DB::table('customers');
    }

    public function index()
    {
        $data = $this->filterData();

        $this->getFields($data);
        $this->searchByField($data, 'id');
        $this->searchByField($data, 'user_id');
        $this->searchLikeField($data, 'name');
        $this->searchByField($data, 'cnpj');
        $this->searchByField($data, 'email');
        $this->searchByField($data, 'active');
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

        return Customer::create($data);
    }

    public function show(Customer $customer)
    {
        return $customer;
    }

    public function update(Customer $customer)
    {
        $data = $this->filterData();
        $validator = Validator::make($data, $this->getRules($customer), $this->getMessages());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$data) {
            return response()->json(['message' => 'É necessário enviar parametros!'], 422);
        }

        $customer->update($data);
        return $customer;
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
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

    public function getRules(Customer $customer = null)
    {
        if ($customer) {
            $rules = [
                'user_id' => 'exists:users,id',
                'name' => 'max:100',
                'cnpj' => ['cnpj', Rule::unique('customers')->ignore($customer)],
                'email' => ['email', Rule::unique('customers')->ignore($customer)],
            ];
        } else {
            $rules = [
                'user_id' => 'required|exists:users,id',
                'name' => 'required|max:100',
                'cnpj' => 'required|cnpj|unique:customers',
                'email' => 'required|email|unique:customers',
            ];
        }

        return $rules;
    }

    public function getMessages()
    {
        return [
            'required' => 'O campo é obrigatório!',
            'exists' => 'Não existe esse usuário.',
            'cnpj' => 'CNPJ é inválido!',
            'max' => 'Máximo de :max caracteres!',
            'unique' => ':input já em uso!',
            'email' => 'E-mail inválido!'
        ];
    }
}
