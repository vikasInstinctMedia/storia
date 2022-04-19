<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Blog;
use App\Models\BlogsTags;
use App\Models\CategorySliderImages;
use App\Models\FrequentlyAskedQuestion;
use App\Models\Recipe;
use App\Models\Tags;

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
        $home_feed_tags = BlogsTags::with(['tags'])->where('blog_id',$blog->id)->get();
        $action = 'edit';
        return view('admin.blog.add',compact('blog','action','home_feed_tags'));
    }

    public function store(Request $request)
    {
        // dump($request->all());
        $slider_url = $request->slider_url;
        $data = $request->except('_token','slider_url','homefeed_tags');

        $tags = $request->input('homefeed_tags');

        $tags_array = explode(',',$tags);


        // $data['banner_image']    = $data['banner_image'] ? $request->file('banner_image')->store('categories') : '';
        $data['thumbnail_image'] = $data['thumbnail_image'] ? $request->file('thumbnail_image')->store('blog') : '';
        $data['banner_image'] = $data['banner_image'] ? $request->file('banner_image')->store('blog') : '';

        $check = Blog::create($data);
        if (!$check) {
            return back()->with('error', 'Failed');
        }

        foreach ($tags_array as $key => $value) {
            $check_if_exists = Tags::where('tag', $value)->first();
            if(isset($check_if_exists->id)){
                $new_blog_tag = new BlogsTags();
                $new_blog_tag->tag_id = $check_if_exists->id;
                $new_blog_tag->blog_id = $check->id;
                $new_blog_tag->save();
            }else{
                $add_new_tag = new Tags();
                $add_new_tag->tag = $value;
                $add_new_tag->save();

                $new_blog_tag = new BlogsTags();
                $new_blog_tag->tag_id = $add_new_tag->id;
                $new_blog_tag->blog_id = $check->id;
                $new_blog_tag->save();

            }
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
        $data = $request->except('_token', '_method', 'blog_id','slider_url','slider_images','homefeed_tags','old_tags');

        $tags = $request->input('homefeed_tags');
        $old_tags = $request->input('old_tags');

        $tags_array = explode(',',$tags);
        $old_tags_array = explode(',',$old_tags);

        $remove_tags=array_diff($old_tags_array,$tags_array);

        if( ! empty( $data['thumbnail_image'] ) ) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('blog') ;
        }

        if( ! empty( $data['banner_image'] ) ) {
            $data['banner_image'] = $request->file('banner_image')->store('blog') ;
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
        $category_data->description = $request->description;
        $category_data->auther = $request->auther;
        $category_data->slug = $request->slug;
        $category_data->date = $request->date;
        $category_data->thumbnail_image = isset($data['thumbnail_image']) ? $data['thumbnail_image'] : $category_data->thumbnail_image;
        $category_data->banner_image = isset($data['banner_image']) ? $data['banner_image'] : $category_data->banner_image;
        // $category_data->banner_image = isset($data['banner_image']) ? $data['banner_image'] : $category_data->banner_image;
        $category_data->save();

        foreach ($tags_array as $key => $value) {
            $check_if_exists = Tags::where('tag', $value)->first();
            if(isset($check_if_exists->id)){

                $check_if_blog_tag_exists = BlogsTags::where('tag_id',$check_if_exists->id)->where('blog_id',$request->blog_id)->first();
                if(isset($check_if_blog_tag_exists->id)){
                    continue;
                }
                $new_blog_tag = new BlogsTags();
                $new_blog_tag->tag_id = $check_if_exists->id;
                $new_blog_tag->blog_id = $request->blog_id;
                $new_blog_tag->save();
            }else{
                $add_new_tag = new Tags();
                $add_new_tag->tag = $value;
                $add_new_tag->save();

                $new_blog_tag = new BlogsTags();
                $new_blog_tag->tag_id = $add_new_tag->id;
                $new_blog_tag->blog_id = $request->blog_id;
                $new_blog_tag->save();

            }
        }

        if(!empty($remove_tags)){
            foreach ($remove_tags as $key => $value) {
                $get_tag = Tags::where('tag',$value)->first();
                if(isset($get_tag->id)){
                    BlogsTags::where('tag_id', $get_tag->id)->where('blog_id', $request->blog_id)->delete();
                }

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
