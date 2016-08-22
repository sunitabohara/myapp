<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Role;
use Illuminate\Support\Facades\Mail;
use Input;
use Session;
use File;


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
    {
        $per_page = 10;
    	$data = $this->user_management->index($per_page);
        return view('admin.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Create User";
        $roles = Role::lists('display_name','id');
//        return $roles;
        return view('admin.users.create',compact('roles','pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {

        $inputs = $request->all();
        $user = $this->user_management->store($inputs);
        return redirect()->route('admin.users.index')
            ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = $this->user_management->find($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user_management->find($id);
        $roles = Role::lists('display_name','id');
        $userRole = $user->roles->lists('id','id')->toArray();
        return view('admin.users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $this->user_management->update($request->all(), $id);

        return redirect()->route('admin.users.index')
            ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user_management->delete($id);
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }

    public function upload($id)
    {
        $page_title = "Upload Profile Picture";
        setupFolderFromId('user', $id);
        return view('admin.users.upload',compact('id','page_title') );
    }

    public function storeImage(Request $request)
    {
        $id = $request->get("id");
        $file = \Illuminate\Support\Facades\Input::file('image');

        if(!is_null($file)) {
            //create appropriate folder according to entity_type and ID
            $folder_setup = setupFolderFromId('users', $id);

            //get full folder path
            $folder_path = getFullFolderDirPathFromId('users', $id);

            $rules = array('file' => 'mimes:png,gif,jpeg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
            $extension = $file->getClientOriginalExtension();
            //call this functiion to save image
            saveImageWithThumb($file, $folder_path . '/profile/', ['name' => 'image', 'ext' => $extension, 'resize_w' => 140, 'resize_h' => 140]);


            $path = getFullFolderDirPathFromId('users',$id);
            getFullFolderDirPathFromId('users', $id, false);
            Session::push('imgPath' , getFullFolderDirPathFromId('users', $id, false));

            return redirect()->route('admin.users.upload', ['id' => $id])
                ->with('success','User image uploaded  successfully');
        }
    }
}
