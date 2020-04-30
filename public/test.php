<?php

$fields = [
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

$data['fields'] = 'id,cpf_cnpj,password';

$list = explode(",", $data['fields']);

var_dump($list);
var_dump($fields);

$result = array_intersect($list, $fields);

var_dump($result);
