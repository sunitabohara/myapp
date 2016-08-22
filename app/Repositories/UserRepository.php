<?php

namespace App\Repositories;
use App\User;
use App\Permisson;
use App\Role;
use DB;
class UserRepository extends BaseRepository
{
    /**
     * The User instance.
     *
     * @var App\User
     */
    protected $user;

    /**
     * The Role instance.
     *
     * @var App\Role
     */
    protected $role;



    /**
     * Create a new UserRepository instance.
     * @param  App\User $user
     */
    public function __construct(
        User $user,
        Role $role
    )
    {
        $this->model = $user;
        $this->role  =$role;
    }

    /**
     * Get user collection.
     *
     * @param  int  $n
     * @return Illuminate\Support\Collection
     */
    public function index($n)
    {
        return $this->model
            ->latest()
            ->paginate($n);
    }

    /**
     * Create User
     *
     *@param  array  $inputs
     * @return App\Models\User
     */
    public function store($inputs)
    {
        $inputs['password'] = bcrypt($inputs['password']);

        try {
            DB::beginTransaction();
            $user =  $this->model->create($inputs);

            foreach ($inputs['roles'] as $key => $value) {
                $user->attachRole($value);
            }
            DB::commit();
            return $user;
        }catch (Exception $e) {
            DB::rollbackTransaction();
        }
    }

    public function find($id)
    {
        return $this->getById($id);
    }

    public function count()
    {

        return $this->model->count();
    }

    public function update($inputs,$id)
    {


        $inputs['password'] = bcrypt($inputs['password']);
        try {
            DB::beginTransaction();
            $user = $this->getById($id);
            $user->update($inputs);
            //delete older roles
            $roleIds = array();
            foreach($user->roles as $role){
                $roleIds[] = $role->id;
            }
            $user->roles()->detach($roleIds);
            //update new roles
            foreach ($inputs['roles'] as $key => $value) {
                $user->attachRole($value);
            }
            DB::commit();
            return $user;
        }catch (Exception $e) {
            DB::rollbackTransaction();
        }

    }


    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    
}

