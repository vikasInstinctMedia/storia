<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\BranchRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Role;
use DB;

class BranchController extends Controller
{
    public function index()
    {   
        $branches = Branch::with('pincodes')->get();
        return view('admin.branch.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branch.add');
    }

    public function store(BranchRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            // 1. Create Branch
            $branch = Branch::create( $request->only(
                    'name', 
                    'city',
                    'state',
                    'prefix',
                    'address',
                    'pincode',
                    'contact_person_name',
                    'contact_person_phone'
            ));

            // 2. Create Branch Admin
            $branchAdmin = Admin::create([
                'full_name' => $branch->contact_person_name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
                'role_id'   => Role::BRANCH_ADMIN,
                'branch_id' => $branch->id
            ]);
            
            DB::commit();
        } catch(\Exception $e)  {
            dd($e->getMessage());
            DB::rollback();
            return back()->with('error', 'Failed');
        }

        return redirect()->route('admin.branches.index')->with('message', 'Successfully Added');
    }

    public function update(BranchRequest $request)
    {

    }

    public function distroy()
    {
         
    }

    public function show()
    {
        
    }

}
