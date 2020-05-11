<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\SearchTrait;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RankingProductsController extends Controller
{
    use SearchTrait;

    protected $model;

    public function __construct()
    {
        $this->model = DB::table('ranking_products');
    }

    public function index()
    {
        $data = $this->filterData();

        $this->getFields($data, '*');
        $this->searchByField($data, 'id');
        $this->searchByField($data, 'code');
        $this->searchLikeField($data, 'description');
        $this->searchByField($data, 'type');
        $this->searchByValue($data, 'total');
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
            return response()->json(['message' => 'É necessário enviar as empresas'], 422);
        }

        $errors = [];
        foreach ($params['companies'] as $data) {
            $data['company'] = preg_replace('/\D/', '', $data['company']);

            $validator = Validator::make($data, [
                'company' => 'required|exists:companies,cnpj',
            ], $this->getMessages());

            if ($validator->fails()) {
                $errors[] = [
                    'fields' => $data,
                    'errors' => $validator->errors()
                ];
            } else {
                $check = false;
                foreach ($data['products'] as $product) {
                    $validator = Validator::make($product, [
                        'code' => 'required',
                        'description' => 'required|max:100',
                    ], $this->getMessages());

                    if ($validator->fails()) {
                        $check = true;
                    }
                }

                if ($check) {
                    $errors[] = [
                        'fields' => $data,
                        'errors' => $validator->errors()
                    ];
                }
            }
        }

        if (count($errors)) {
            return response()->json($errors, 422);
        }

        foreach ($params['companies'] as $data) {
            $data['company'] = preg_replace('/\D/', '', $data['company']);
            $company = Company::where('cnpj', $data['company'])->first();

            foreach ($data['products'] as $product) {
                $company->rankingProducts()->create($product);
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
                foreach ($company->rankingProducts as $product) {
                    $product->delete();
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
            'max' => 'Máximo de :max caracteres!',
            'exists' => 'Não existe essa Empresa!',
        ];
    }
}
