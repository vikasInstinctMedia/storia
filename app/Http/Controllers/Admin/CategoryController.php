<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\CategorySliderImages;
use App\Models\FrequentlyAskedQuestion;
use App\Models\Recipe;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.add');
    }

    public function edit(Category $category)
    {
        $category->load('faqs');
        $category->load('category_images');
        return view('admin.category.edit', compact('category'));
    }

    public function store(CategoryRequest $request)
    {
        // dump($request->all());
        $slider_url = $request->slider_url;
        $data = $request->except('_token','slider_url');

        $data['banner_image']    = $data['banner_image'] ? $request->file('banner_image')->store('categories') : '';
        $data['thumbnail_image'] = $data['thumbnail_image'] ? $request->file('thumbnail_image')->store('categories') : '';

        $check = Category::create($data);
        if (!$check) {
            return back()->with('error', 'Failed');
        }

        $category_id = $check->id;
        if($files=$request->file('slider_images')){
            $i = 0;
            foreach($files as $file){
                // $name='gallery_image-'.time().rand(1000000,9999999).$file->getClientOriginalName();
                $image_name  = $file->hashName();
                $image_path  = 'categories/';
                $file->store($image_path);
                CategorySliderImages::insert(
                    ['image'=>$image_name,
                    'categorys_id'=>$category_id,
                    'slider_url'=>$slider_url[$i],
                    'created_at' => date('Y-m-d  H:i:s'),
                    ]
                );
                $i++;
            }
        }
        return redirect()->route('admin.categories.index')->with('message', 'Created');
    }

    public function getList()
    {
        $categories = Category::latest();

        return datatables()->of($categories)
            ->addIndexColumn()
            ->editColumn('banner_image', function ($row) {
                return $row->banner_image ? asset("storage/" . $row->banner_image) : "";
            })
            ->addColumn('action', function ($row) {
                return [
                    'view_url' => route('admin.categories.show', ['category' => $row->id]),
                    'edit_url' =>  route('admin.categories.edit', ['category' => $row->id])
                ];
            })
            ->toJson();
    }

    public function update(Request $request)
    {
        // dump($request->all());
        $slider_url = $request->slider_url;
        $data = $request->except('_token', '_method', 'category_id','slider_url','slider_images');

        if( ! empty( $data['thumbnail_image'] ) ) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('categories') ;
        }

        if(! empty($data['banner_image'])) {
            $data['banner_image'] =  $request->file('banner_image')->store('categories');
        }

        // if( !  Category::where('id', $request->category_id)->update($data) ) {
            // return back()->with('error', 'failed');
        // }
        $category_data = Category::where('id',$request->category_id)->first();
        $category_data->name = $request->name;
        $category_data->slug = $request->slug;
        $category_data->meta_title = $request->meta_title;
        $category_data->meta_description = $request->meta_description;
        $category_data->thumbnail_image = isset($data['thumbnail_image']) ? $data['thumbnail_image'] : $category_data->thumbnail_image;
        $category_data->banner_image = isset($data['banner_image']) ? $data['banner_image'] : $category_data->banner_image;
        $category_data->save();

        $category_id = $request->category_id;
        if($files=$request->file('slider_images')){
            $i = 0;
            foreach($files as $file){
                // $name='gallery_image-'.time().rand(1000000,9999999).$file->getClientOriginalName();
                $image_name  = $file->hashName();
                $image_path  = 'categories/';
                $file->store($image_path);
                CategorySliderImages::insert(
                    ['image'=>$image_name,
                    'categorys_id'=>$category_id,
                    'slider_url'=>$slider_url[$i],
                    'created_at' => date('Y-m-d  H:i:s'),
                    ]
                );
                $i++;
            }
        }

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

    public function distroy()
    {
    }
}
