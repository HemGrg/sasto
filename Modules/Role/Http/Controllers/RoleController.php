<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Role\Entities\Role;
use DB, Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('role::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('role::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    public function getRoles()
    {
        // $details = DB::table('roles')->skip(10)->take(5)->get();
        $details = Role::orderBy('created_at', 'desc')->get();
        $view = \View::make("role::rolesTable")->with('details', $details)->render();
        return response()->json(['html' => $view, 'status' => 'successful', 'data' => $details]);
    }

    public function createrole(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:255',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
            exit;
        }
        DB::beginTransaction();
        try{
            $value = $request->except('publish');
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            // dd($value['publish']);
        $name = $request->name;
        $value = [
            'name'=> $name,
            'publish' => $value['publish']
        ];
        $data = Role::create($value);
        DB::commit();

        return response()->json(['status' => 'successful', 'message' => 'Role Created Successfully.','data' => $data]);

        }  catch(\Exception $exception){
            DB::rollback();
              return response([
                  'message' => $exception->getMessage()
              ],400);
          }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */

    public function view($id)
    {
        return view('role::view', compact('id'));
    }
    public function deleterole(Request $request)
    {
        try{
            $role = Role::findorFail($request->id);
            $role->delete();

      return response()->json([
        'status' => 'successful',
        "message" => "Role deleted successfully!"
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function editrole(Request $request)
    {
        try{
            $role = Role::findorFail($request->id);

      return response()->json([
        "data" => $role
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function updateRole(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
            ]);
    
            if($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            $role = Role::findorFail($request->id);
            $value = $request->except('publish','_token');
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            $success = $role->update($value);
      return response()->json([
        'status' => 'successful',
          "data" => $value,
        "message" => "Roles updated successfully"
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    public function viewRole(Request $request)
    {
        try{
            $role = Role::findorFail($request->id);
            // dd($role);

      return response()->json([
        "message" => "Role view!",
        'data' => $role
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }


    public function show($id)
    {
        return view('role::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('role::edit',compact('id'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
