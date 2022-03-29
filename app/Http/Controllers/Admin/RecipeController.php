<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\CategorySliderImages;
use App\Models\FrequentlyAskedQuestion;
use App\Models\Recipe;
use App\Models\RecipeCategory;

class RecipeController extends Controller
{
    public function category_index()
    {
        return view('admin.recipe.category_index');
    }

    public function recipe_index()
    {
        return view('admin.recipe.recipe_index');
    }

    public function category_create()
    {
        return view('admin.recipe.category_add');
    }

    public function recipe_create()
    {
        $rec_category = RecipeCategory::get();
        return view('admin.recipe.recipe_add',compact('rec_category'));
    }

    public function category_edit($id)
    {
        $category = RecipeCategory::where('id',$id)->first();
        $action = 'edit';
        return view('admin.recipe.category_add', compact('category','action'));
    }
    public function recipe_edit($id){
        $rec_category = RecipeCategory::get();
        $recipe = Recipe::where('id',$id)->first();
        $action = 'edit';
        return view('admin.recipe.recipe_add',compact('rec_category','recipe','action'));
    }

    public function category_store(Request $request)
    {
        // dd($request->all());
        $slider_url = $request->slider_url;
        $data = $request->except('_token','slider_url');

        $check = RecipeCategory::create($data);
        if (!$check) {
            return back()->with('error', 'Failed');
        }

        return redirect()->route('admin.recipes_category_list')->with('message', 'Created');
    }

    public function recipe_store(Request $request)
    {
        // dd($request->all());
        $slider_url = $request->slider_url;
        $data = $request->except('_token','slider_url');

        // $data['banner_image']    = $data['banner_image'] ? $request->file('banner_image')->store('categories') : '';
        $data['thumbnail_image'] = $data['thumbnail_image'] ? $request->file('thumbnail_image')->store('receipe') : '';
        $data['published_date'] = date('Y-m-d H:i:s');
        $check = Recipe::create($data);
        if (!$check) {
            return back()->with('error', 'Failed');
        }
        return redirect()->route('admin.recipes_list')->with('message', 'Created');
    }

    public function recipe_update(Request $request)
    {
        // dd($request->all());
        $slider_url = $request->slider_url;
        $data = $request->except('_token', '_method', 'recipe_id','slider_url','slider_images');

        if( ! empty( $data['thumbnail_image'] ) ) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('receipe') ;
        }

        $category_data = Recipe::where('id',$request->recipe_id)->first();
        $category_data->title = $request->title;
        $category_data->meta_title = $request->meta_title;
        $category_data->meta_description = $request->meta_description;
        $category_data->recipe_category_id = $request->recipe_category_id;
        $category_data->thumbnail_image = isset($data['thumbnail_image']) ? $data['thumbnail_image'] : $category_data->thumbnail_image;
        $category_data->published_date = $category_data->published_date;
        $category_data->description = $request->description;
        // $category_data->banner_image = isset($data['banner_image']) ? $data['banner_image'] : $category_data->banner_image;
        $category_data->save();

        return back()->with('message', 'success');
    }

    public function recipegetlist(){
        $categories = Recipe::latest();

        return datatables()->of($categories)
            ->addIndexColumn()
            ->editColumn('thumbnail_image', function ($row) {
                return $row->thumbnail_image ? asset("storage/" . $row->thumbnail_image) : "";
            })
            ->addColumn('action', function ($row) {
                return [
                    // 'view_url' => route('admin.categories.show', ['category' => $row->id]),
                    'edit_url' =>  route('admin.recipe.recipe_edit', ['id' => $row->id]),
                    'delete_url' =>  route('admin.recipe.recipe_delete', ['id' => $row->id])
                ];
            })
            ->toJson();
    }

    public function categorygetlist()
    {
        $categories = RecipeCategory::latest();

        return datatables()->of($categories)
            ->addIndexColumn()
            ->editColumn('banner_image', function ($row) {
                return $row->banner_image ? asset("storage/" . $row->banner_image) : "";
            })
            ->addColumn('action', function ($row) {
                return [
                    'view_url' => route('admin.categories.show', ['category' => $row->id]),
                    'edit_url' =>  route('admin.recipe.category_edit', ['id' => $row->id]),
                    'delete_url' =>  route('admin.recipe.categories_delete', ['id' => $row->id])
                ];
            })
            ->toJson();
    }

    public function category_update(Request $request)
    {
        // print_r($request->input());
        // exit;
        // $slider_url = $request->slider_url;
        $data = $request->except('_token', '_method', 'category_id','slider_url','slider_images');
        // if( !  Category::where('id', $request->category_id)->update($data) ) {
            // return back()->with('error', 'failed');
        // }
        $category_data = RecipeCategory::where('id',$request->category_id)->first();
        $category_data->name = $request->name;
        $category_data->slug = $request->slug;
        // $category_data->thumbnail_image = isset($data['thumbnail_image']) ? $data['thumbnail_image'] : $category_data->thumbnail_image;
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

        public function category_delete($id){
            if (!RecipeCategory::where('id', $id)->delete()) {
                return back()->with('error', 'Failed');
            }

            return back()->with('message', 'Deleted');

        }

        public function recipe_delete($id){
            if (!Recipe::where('id', $id)->delete()) {
                return back()->with('error', 'Failed');
            }

            return back()->with('message', 'Deleted');

        }

    public function distroy()
    {
    }
}
