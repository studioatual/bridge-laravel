<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\SearchTrait;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CashiersController extends Controller
{
    use SearchTrait;

    protected $model;

    public function __construct()
    {
        $this->model = DB::table('cashiers');
    }

    public function index()
    {
        $data = $this->filterData();

        $this->getFields($data, '*');
        $this->searchByField($data, 'id');
        $this->searchByField($data, 'company_id');
        $this->searchByValue($data, 'amount_payable');
        $this->searchByValue($data, 'amount_receivable');
        $this->searchByValue($data, 'day_balance');
        $this->searchByValue($data, 'accumalated_balance');
        $this->searchByValue($data, 'accumulated_pending');
        $this->searchByData($data, 'cashflow_date');
        $this->searchByData($data, 'created_at');
        $this->searchByData($data, 'updated_at');
        $this->getOffset($data);
        $this->getLimit($data);

        return $this->model->get();
    }

    public function storeBatches()
    {
        $params = request()->all();

        if (!$params['companies']) {
            return response()->json(['message' => 'É necessário enviar as empresas'], 422);
        }

        $errors = [];
        foreach ($params['companies'] as $item) {
            $item['company'] = preg_replace('/\D/', '', $item['company']);

            $validator = Validator::make($item, [
                'company' => 'required|exists:companies,cnpj',
            ], $this->getMessages());

            if ($validator->fails()) {
                $errors[] = [
                    'fields' => $item,
                    'errors' => $validator->errors()
                ];
            } else {
                $check = false;
                foreach ($item['cashier'] as $cashier) {
                    $validator = Validator::make($cashier, [
                        'cashier_date' => 'required',
                    ], $this->getMessages());

                    if ($validator->fails()) {
                        $check = true;
                    }
                }

                if ($check) {
                    $errors[] = [
                        'fields' => $item,
                        'errors' => $validator->errors()
                    ];
                }
            }
        }

        if (count($errors)) {
            return response()->json($errors, 422);
        }

        foreach ($params['companies'] as $item) {
            $item['company'] = preg_replace('/\D/', '', $item['company']);
            $company = Company::where('cnpj', $item['company'])->first();

            foreach ($params['cashiers'] as $cashier) {
                $company->cashiers()->create($cashier);
            }
        }

        return response()->json(['result' => 'ok']);
    }

    public function destroyAll()
    {
        $data = request()->all();

        if (!isset($data['companies'])) {
            return response()->json(['message' => 'É necessário enviar as empresas'], 422);
        }

        foreach ($data['companies'] as $cnpj) {
            $cnpj = preg_replace('/\D/', '', $cnpj);
            $company = Company::where('cnpj', $cnpj)->first();

            if ($company) {
                foreach ($company->cashiers as $cashier) {
                    $cashier->delete();
                }
            }
        }

        return response()->json(['result' => 'ok']);
    }

    public function getMessages()
    {
        return [
            'required' => 'O campo é obrigatório!',
            'cnpj' => 'CNPJ é inválido!',
            'exists' => 'Não existe essa Empresa!',
        ];
    }
}
