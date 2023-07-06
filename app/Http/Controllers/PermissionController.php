<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            return $this->getPermission();
        }
        return view('users.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        //validate name
        $this->validate($request, [
            'name' => 'required|unique:permissions,name'
        ]);
        $permission = Permission::create(["name" => strtolower($request->name)]);
        if($permission)
        {
            toast('New Permission Added Successfully!', 'success');
            return view('users.permissions.index');

        }
        toast('Error on saving data', 'error');
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('users.permissions.edit')->with(['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            "name" => 'required|unique:permissions,name,'.$permission->id
        ]);
       
        if($permission->update($request->only('name')))
        {
            // Alert::success('Saved Successfully!', 'Data Saved');
            toast('Permission Update Successfully!', 'success');
            return view('users.permissions.index');

        }
        toast('Error on updating permission', 'error');
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Permission $permission)
    {
        if($request->ajax() && $permission->delete())
        {
            return response(["Message" => "Permission Deleted Successfully"], 200);
        }
        return response(["Message" => "Data Delete Error"], 201);
    }

    private function getPermission()
    {
        $data = Permission::get();
        return DataTables::of($data)
            ->addColumn('chkBox', function($row){
                return "chkBox";
            })
            ->addColumn('action', function($row){
                $action = "";
                $action.="<a class='btn btn-xs btn-warning' id='btnEdit' href='".route('users.permissions.edit',$row->id)."'><i class='fas fa-edit'></i></a>";
                $action.=" <button class='btn btn-xs btn-outline-danger' id='btnDel' data-id='".$row->id."'><i class='fas fa-trash'></i></button>";
                return $action;
            })
            ->make(true);
    }
}
