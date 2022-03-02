<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\Branch;
use App\Models\CategorySliderImages;
use App\Models\FrequentlyAskedQuestion;
use App\Models\Recipe;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.admin-user.index');
    }

    public function create()
    {
        $branch_data = Branch::get();
        return view('admin.admin-user.add',compact('branch_data'));
    }

    public function edit($id)
    {
        $branch_data = Branch::get();
        $admin_user = Admin::where('id',$id)->first();
        $action = 'edit';
        return view('admin.admin-user.add',compact('admin_user','action','branch_data'));
    }

    public function store(Request $request)
    {
        // dump($request->all());
        $reqdata = $request->input();
        $data = $request->except('_token','slider_url','password');

        // $data['banner_image']    = $data['banner_image'] ? $request->file('banner_image')->store('categories') : '';
        //$data['thumbnail_image'] = $data['thumbnail_image'] ? $request->file('thumbnail_image')->store('blog') : '';
       $data['password'] = isset($reqdata['password']) ? Hash::make($reqdata['password']) : Hash::make('admin123');
        // print_r($data);
        // exit;
        $check = Admin::create($data);
        if (!$check) {
            return back()->with('error', 'Failed');
        }

        return redirect()->route('admin.admin-user.list')->with('message', 'Created');
    }

    public function getList()
    {
        $categories = Admin::with(['branch'])->latest();

        return datatables()->of($categories)
            ->addIndexColumn()
            ->editColumn('branch_show', function ($row) {
                return isset($row->branch->name) ? $row->branch->name : "";
            })
            ->addColumn('action', function ($row) {
                return [
                    // 'view_url' => route('admin.admin-user.show', ['category' => $row->id]),
                    'edit_url' =>  route('admin.admin-user.edit', ['id' => $row->id]),
                    'delete_url' =>  route('admin.admin-user.delete', ['id' => $row->id])
                ];
            })
            ->addColumn('status_new', function ($row) {
                return [
                    // 'view_url' => route('admin.admin-user.show', ['category' => $row->id]),
                    'status' =>  $row->status,
                    'id' =>  $row->id
                ];
            })
            ->toJson();
    }

    public function update(Request $request)
    {
        // dump($request->all());
        $slider_url = $request->slider_url;
        $data = $request->except('_token', '_method', 'blog_id','slider_url','slider_images','password');

        // if( ! empty( $data['thumbnail_image'] ) ) {
        //     $data['thumbnail_image'] = $request->file('thumbnail_image')->store('categories') ;
        // }

        // if(! empty($data['banner_image'])) {
        //     $data['banner_image'] =  $request->file('banner_image')->store('categories');
        // }

        // if( !  Category::where('id', $request->category_id)->update($data) ) {
            // return back()->with('error', 'failed');
        // }
        $category_data = Admin::where('id',$request->admin_id)->first();
        $category_data->full_name = $request->full_name;
        $category_data->email = $request->email;
        if($request->password != ''){
            $category_data->password = Hash::make($request->password);    
        }
        $category_data->role_id = $request->role_id;
        $category_data->branch_id = $request->branch_id;
        //  $category_data->thumbnail_image = isset($data['thumbnail_image']) ? $data['thumbnail_image'] : $category_data->thumbnail_image;
        // $category_data->banner_image = isset($data['banner_image']) ? $data['banner_image'] : $category_data->banner_image;
        $category_data->save();

        return back()->with('message', 'success');
    }

    public function updateFaq(Request $request)
    {
        // dd($request->all());

        foreach ($request->question as $key => $question) {

            $data = [
                'question' => $request->question[$key],
                'answer'   => $request->answer[$key]
            ];

            if (is_numeric($key)) {
                FrequentlyAskedQuestion::where('id', $key)->update($data);
            } else {
                FrequentlyAskedQuestion::insert(array_merge(['category_id' => $request->category_id], $data));
            }
        }

        return back()->with('message', 'Successfully Updated');
    }

    public function deleteFaq($faq_id)
    {
        // dd($faq_id);
        if (!FrequentlyAskedQuestion::where('id', $faq_id)->delete()) {
            return back()->with('error', 'Failed');
        }

        return back()->with('message', 'Deleted');
    }

    public function delete($id){
        if (!Admin::where('id', $id)->delete()) {
            return back()->with('error', 'Failed');
        }

        return back()->with('message', 'Deleted');

    }

    public function change_status(Request $request){
        $reqdata = $request->input();
        $id = isset($reqdata['admin_id']) ? $reqdata['admin_id'] : '';
        $status = isset($reqdata['admin_status']) ? $reqdata['admin_status'] : '';

        if($status == 1){
            $change = 2;
        }else{
            $change = 1;
        }

        $admindata = Admin::where('id',$id)->first();
        $admindata->status = $change;
        $admindata->save();

        echo $change;
        // print_r($reqdata);
    }

    public function distroy()
    {
    }
}
