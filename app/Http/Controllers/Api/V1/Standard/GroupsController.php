<?php

namespace App\Http\Controllers\Api\V1\Standard;

use App\Http\Controllers\Controller;
use App\Models\Standard\Group;
use App\Http\Requests\Standard\GroupRequest as Request;
use App\Repositories\Standard\GroupRepository;

class GroupsController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new GroupRepository();
    }

    public function index()
    {
        return $this->repository->index(request());
    }

    public function store(Request $request)
    {
        return $this->repository->store($request);
    }

    public function show(Group $group)
    {
        return $group;
    }

    public function update(Request $request, Group $group)
    {
        return $this->repository->update($request, $group);
    }

    public function destroy(Group $group)
    {
        return $this->repository->destroy($group);
    }
}
