<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\SearchTrait;
use App\Models\Company;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    use SearchTrait;

    protected $model;
    protected $fields = [
        'id',
        'group_id',
        'name',
        'code',
        'cpf_cnpj',
        'username',
        'email',
        'active',
        'admin',
        'created_at',
        'updated_at',
    ];

    public function __construct()
    {
        $this->model = DB::table('users');
    }

    public function index()
    {
        $data = $this->filterData(request()->all());

        $this->getFields($data, $this->fields);
        $this->searchByField($data, 'id');
        $this->searchByField($data, 'group_id');
        $this->searchLikeField($data, 'name');
        $this->searchByField($data, 'cpf_cnpj');
        $this->searchByField($data, 'email');
        $this->searchByField($data, 'username');
        $this->searchByField($data, 'admin');
        $this->searchByField($data, 'active');
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

        return User::create($data);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(User $user)
    {
        $data = $this->filterData(request()->all());
        $validator = Validator::make($data, $this->getRules($user), $this->getMessages());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$data) {
            return response()->json(['message' => 'É necessário enviar parametros!'], 422);
        }

        $user->update($data);
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['result' => 'ok']);
    }

    private function filterData($inputs)
    {
        $data = [];
        $list = array_filter((array) $inputs, 'strlen');

        foreach ($list as $key => $value) {
            $data[$key] = trim(strip_tags($value));
        }

        if (isset($data['cpf_cnpj'])) {
            $data['cpf_cnpj'] = preg_replace('/[^\d\,]/', '', $data['cpf_cnpj']);
        }

        if (isset($data['group'])) {
            $data['group'] = preg_replace('/[^\d\,]/', '', $data['group']);
        }

        return $data;
    }

    public function getRules(User $user = null)
    {
        if ($user) {
            $rules = [
                'group_id' => 'exists:groups,id',
                'name' => 'max:100',
                'cpf_cnpj' => ['cpf_cnpj', Rule::unique('users')->ignore($user)],
                'email' => ['email', Rule::unique('users')->ignore($user)],
                'username' => 'max:100',
            ];
        } else {
            $rules = [
                'group_id' => 'required|exists:groups,id',
                'name' => 'required|max:100',
                'cpf_cnpj' => 'required|cpf_cnpj|unique:users',
                'email' => 'required|email|unique:users',
                'username' => 'required|max:100',
                'password' => 'required',
            ];
        }

        return $rules;
    }

    public function getMessages()
    {
        return [
            'required' => 'O campo é obrigatório!',
            'exists' => 'Não existe esse grupo.',
            'cpf_cnpj' => 'CPF/CNPJ é inválido!',
            'max' => 'Máximo de :max caracteres!',
            'unique' => ':input já em uso!',
            'email' => 'E-mail inválido!'
        ];
    }

    public function storeBatches()
    {
        $inputs = request()->input('users');

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
            $group->users()->create($data);
            /*
            User::create(array_merge($data, ['group_id' => $group->id]));
            */
        }

        return response()->json(['result' => 'ok']);
    }

    public function updateBatches()
    {
        $inputs = request()->input('users');

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
            $user = User::where('cpf_cnpj', $data['cpf_cnpj'])->first();
            $user->update($data);
        }

        return response()->json(['result' => 'ok']);
    }

    public function destroyBatches()
    {
        $inputs = request()->input('users');

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
            $user = User::where('cpf_cnpj', $data['cpf_cnpj'])->first();
            $user->delete();
        }

        return response()->json(['result' => 'ok']);
    }

    public function destroyAll()
    {
        $cnpj = request()->input('group');
        $group = Group::where('cnpj', $cnpj)->first();
        foreach ($group->users as $user) {
            $user->delete();
        }
        return response()->json(['result' => 'ok']);
    }

    public function getRulesStoreBatches()
    {
        return [
            'group' => 'required|exists:groups,cnpj',
            'name' => 'required|max:100',
            'cpf_cnpj' => 'required|cpf_cnpj|unique:users',
            'email' => 'required|email|unique:users',
            'username' => 'required|max:100',
            'password' => 'required',
        ];
    }

    public function getRulesUpdateAndDestroyBatches($destroy = false)
    {
        $rules = $destroy ? [
            'group' => 'required|exists:groups,cnpj',
        ] : [
            'group' => 'required|exists:groups,cnpj',
            'name' => 'required|max:100',
            'cpf_cnpj' => 'required|cpf_cnpj|exists:users,cpf_cnpj',
            'email' => 'required|email|exists:users,email',
            'username' => 'required|max:100',
            'password' => 'required',
        ];
        return $rules;
    }
}
