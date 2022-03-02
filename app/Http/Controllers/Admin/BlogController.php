<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Blog;
use App\Models\CategorySliderImages;
use App\Models\FrequentlyAskedQuestion;
use App\Models\Recipe;

class BlogController extends Controller
{
    public function index()
    {
        return view('admin.blog.index');
    }

    public function create()
    {
        return view('admin.blog.add');
    }

    public function edit($id)
    {
        $blog = Blog::where('id',$id)->first();
        $action = 'edit';
        return view('admin.blog.add',compact('blog','action'));
    }

    public function store(Request $request)
    {
        // dump($request->all());
        $slider_url = $request->slider_url;
        $data = $request->except('_token','slider_url');

        // $data['banner_image']    = $data['banner_image'] ? $request->file('banner_image')->store('categories') : '';
        $data['thumbnail_image'] = $data['thumbnail_image'] ? $request->file('thumbnail_image')->store('blog') : '';
        // print_r($data);
        // exit;
        $check = Blog::create($data);
        if (!$check) {
            return back()->with('error', 'Failed');
        }

        return redirect()->route('admin.blog.list')->with('message', 'Created');
    }

    public function getList()
    {
        $categories = Blog::latest();

        return datatables()->of($categories)
            ->addIndexColumn()
            ->editColumn('thumbnail_image', function ($row) {
                return $row->thumbnail_image ? asset("storage/" . $row->thumbnail_image) : "";
            })
            ->addColumn('action', function ($row) {
                return [
                    'view_url' => route('admin.categories.show', ['category' => $row->id]),
                    'edit_url' =>  route('admin.blog.edit', ['id' => $row->id]),
                    'delete_url' =>  route('admin.blog.delete', ['id' => $row->id])
                ];
            })
            ->toJson();
    }

    public function update(Request $request)
    {
        // dump($request->all());
        $slider_url = $request->slider_url;
        $data = $request->except('_token', '_method', 'blog_id','slider_url','slider_images');

        if( ! empty( $data['thumbnail_image'] ) ) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('categories') ;
        }

        // if(! empty($data['banner_image'])) {
        //     $data['banner_image'] =  $request->file('banner_image')->store('categories');
        // }

        // if( !  Category::where('id', $request->category_id)->update($data) ) {
            // return back()->with('error', 'failed');
        // }
        $category_data = Blog::where('id',$request->blog_id)->first();
        $category_data->title = $request->title;
        $category_data->redirect_url = $request->redirect_url;
        $category_data->thumbnail_image = isset($data['thumbnail_image']) ? $data['thumbnail_image'] : $category_data->thumbnail_image;
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
        if (!Blog::where('id', $id)->delete()) {
            return back()->with('error', 'Failed');
        }

        return back()->with('message', 'Deleted');

    }

    public function distroy()
    {
    }
}
