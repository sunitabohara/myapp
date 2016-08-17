<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Requests\UserCreateRequest;

class UserController extends Controller
{

    /**
     * The UserRepository instance.
     *
     * @var App\Repositories\UserRepository
     */
    protected $user_management;

    /**
     * Create a new UserController instance.
     *
     * @param  App\Repositories\UserRepository $user_management
     * @return void
     */
    public function __construct(
        UserRepository $user_management)
    {
        $this->user_management = $user_management;
    }

    public function index(Request $request)
    {	$per_page = 10;
    	$data = $this->user_management->index($per_page);
        return view('admin.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
}
