<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\AuthorFilter;
use App\Http\Requests\Api\V1\ReplaceUserRequest;
use App\Models\User;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Policies\V1\UserPolicy;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends ApiController
{
    protected $policyClass = UserPolicy::class;

    /**
     * Get all users
     *
     * @group Managing Users
     *
     * @queryParam sort string Data field(s) to sort by. Separate multiple fields with commas. Denote descending sort with a minus sign. Example: sort=name
     * @queryParam filter[name] Filter by status name. Wildcards are supported. No-example
     * @queryParam filter[email] Filter by email. Wildcards are supported. No-example
     *
     */
    public function index(AuthorFilter $filters)
    {
        return UserResource::collection(
            User::filter($filters)->paginate()
        );
    }

    /**
     * Create a user
     *
     * @group Managing Users
     *
     * @response 200 {"data":{"type":"user","id":16,"attributes":{"name":"My User","email":"user@user.com","isManager":false},"links":{"self":"http:\/\/localhost:8000\/api\/v1\/authors\/16"}}}
     */
    public function store(StoreUserRequest $request)
    {
        if ($this->isAble('store', User::class)) {
            return new UserResource(User::create($request->mappedAttributes()));
        }

        return $this->error('You are not authorized to create that resource', 401);
    }

    /**
     * Display a user
     *
     * @group Managing Users
     */
    public function show(User $user)
    {
        if ($this->include('tickets')) {
            return new UserResource($user->load('tickets'));
        }

        return new UserResource($user);
    }

    /**
     * Update a user
     *
     * @group Managing Users
     *
     * @response 200 {"data":{"type":"user","id":16,"attributes":{"name":"My User","email":"user@user.com","isManager":false},"links":{"self":"http:\/\/localhost:8000\/api\/v1\/authors\/16"}}}
     */
    public function update(UpdateUserRequest $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            if ($this->isAble('update', $user)) {
                $user->update($request->mappedAttributes());

                return new UserResource($user);
            }

            return $this->error('You are not authorized to update that resource', 401);

        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        }
    }

    /**
     * Replace a user
     *
     * @group Managing Users
     *
     * @response 200 {"data":{"type":"user","id":16,"attributes":{"name":"My User","email":"user@user.com","isManager":false},"links":{"self":"http:\/\/localhost:8000\/api\/v1\/authors\/16"}}}
     */
    public function replace(ReplaceUserRequest $request, $user_id)
    {
        // PUT
        try {
            $user = User::findOrFail($user_id);

            if ($this->isAble('replace', $user)) {
                $user->update($request->mappedAttributes());

                return new UserResource($user);
            }

            return $this->error('You are not authorized to update that resource', 401);

        } catch (ModelNotFoundException $exception) {
            return $this->error('User cannot be found.', 404);
        }
    }

    /**
     * Delete a user
     *
     * @group Managing Users
     *
     * @response 200 {}
     */
    public function destroy($user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            if ($this->isAble('delete', $user)) {
                $user->delete();

                return $this->ok('User successfully deleted');
            }

            return $this->error('You are not authorized to delete that resource', 401);

        } catch (ModelNotFoundException $exception) {
            return $this->error('User cannot found.', 404);
        }
    }
}
