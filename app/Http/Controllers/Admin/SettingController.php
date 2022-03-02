<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Setting;
use DB;
use App\Models\Category;
use App\Models\ImageLibrary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public function bannerIndex()
    {
        $banners = Banner::orderBy('sequence', 'ASC')->get();
        return view('admin.setting.banner_index', compact('banners'));
    }

    public function bannerStore(Request $request)
    {
        $request->validate([
            'image'        => [
                'required', 'mimes:jpeg,jpg,png', 'max:2024',
                Rule::dimensions()->maxWidth(1940)
            ]
        ]);
        $data = $request->only('image', 'redirect_url');
        $data['image'] = $request->file('image')->store('banner');

        Banner::insert($data);

        return redirect()->route('admin.settings.banner.index')->with('message', 'created successfully');
    }

    public function bannerSeqStore(Request $request)
    {
        $seq = $request->input('seq');
        $i = 1;
        foreach ($seq as $key => $value) {
            // $banner = Banner::where('id',$value)->first();
            // print_r($banner);
            // $banner->sequence = $i;
            // $banner->save();
            DB::table('banners')
                ->where('id', $value)
                ->update(['sequence' => $i]);
            $i++;
        }
        return redirect()->route('admin.settings.banner.index')->with('message', 'Sequence Updated');
        // exit;
    }

    public function bannerDelete(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.settings.banner.index')->with('message', 'Deleted');
    }

    public function about_us()
    {
        $about_us = Setting::where('key', 'about_us')->first();
        $about_us_data = json_decode($about_us->value, true);
        // print_r($about_us_data);
        // exit;
        return view('admin.setting.about_index', compact('about_us', 'about_us_data'));
    }

    public function about_us_store(Request $request)
    {
        $request->validate([
            'image'        => [
                'required', 'mimes:jpeg,jpg,png', 'max:2024',
                Rule::dimensions()->maxWidth(1940)
            ]
        ]);
        $data = $request->only('image', 'redirect_url', 'title', 'description');
        $data['image'] = $request->file('image')->store('banner');

        // Banner::insert($data);


        $about_data = Setting::where('key', 'about_us')->first();

        $get_data = json_decode($about_data->value, true);

        if (isset($get_data['slider_1'])) {
            $cnt = count($get_data['slider_1']);
            // $save_data['slider_1'][$cnt+1] = $data;
            // $save_data = $get_data['slider_1'];
            array_push($get_data['slider_1'], $data);
        } else {
            $get_data['slider_1'][0] = $data;
        }

        // print_r($get_data);
        // exit;
        $about_data->value = json_encode($get_data);
        $about_data->save();

        return redirect()->route('admin.about-us')->with('message', 'Updated successfully');
    }


    public function about_us2_store(Request $request)
    {
        $request->validate([
            'image'        => [
                'required', 'mimes:jpeg,jpg,png', 'max:2024',
                Rule::dimensions()->maxWidth(1940)
            ]
        ]);
        $data = $request->only('image', 'redirect_url', 'title');
        $data['image'] = $request->file('image')->store('banner');

        // Banner::insert($data);


        $about_data = Setting::where('key', 'about_us')->first();

        $get_data = json_decode($about_data->value, true);

        if (isset($get_data['slider_2'])) {
            $cnt = count($get_data['slider_2']);
            // $save_data['slider_2'][$cnt+1] = $data;
            // $save_data = $get_data['slider_2'];
            array_push($get_data['slider_2'], $data);
        } else {
            $get_data['slider_2'][0] = $data;
        }

        // print_r($get_data);
        // exit;
        $about_data->value = json_encode($get_data);
        $about_data->save();

        return redirect()->route('admin.about-us')->with('message', 'Updated successfully');
    }

    public function about_us3_store(Request $request){
        $request->validate([
            'image1'        => [
                 'mimes:jpeg,jpg,png', 'max:2024',
                Rule::dimensions()->maxWidth(1940)
            ],
            'image2'        => [
                'mimes:jpeg,jpg,png', 'max:2024',
                Rule::dimensions()->maxWidth(1940)
            ]
        ]);
        $data = $request->only('image1','image2', 'redirect_url1','redirect_url2', 'title1', 'title2');


        // $data['image2'] = $request->file('image2')->store('banner');

        // $newd['images_new'] =  $data;
        $about_data = Setting::where('key', 'about_us')->first();

        $get_data = json_decode($about_data->value, true);

        if(isset($data['image1']) && $data['image1'] != ''){
            $data['image1'] = $request->file('image1')->store('banner');
        }else{
            $data['image1'] = $get_data['images_new']['image1'];
        }

        if(isset($data['image2']) && $data['image2'] != ''){
            $data['image2'] = $request->file('image2')->store('banner');
        }else{
            $data['image2'] = $get_data['images_new']['image2'];
        }

        $get_data['images_new'] = $data;
        // array_push($get_data,$newd);
        // print_r($get_data);
        // exit;
        $about_data->value = json_encode($get_data);
        $about_data->save();

        return redirect()->route('admin.about-us')->with('message', 'Updated successfully');
    }

    public function about_us4_store(Request $request)
    {
        $request->validate([
            'image'        => [
                'required', 'mimes:jpeg,jpg,png', 'max:2024',
                Rule::dimensions()->maxWidth(1940)
            ]
        ]);
        $data = $request->only('image', 'redirect_url', 'title');
        $data['image'] = $request->file('image')->store('banner');

        // Banner::insert($data);


        $about_data = Setting::where('key', 'about_us')->first();

        $get_data = json_decode($about_data->value, true);

        if (isset($get_data['instagram_slider'])) {
            $cnt = count($get_data['instagram_slider']);
            // $save_data['instagram_slider'][$cnt+1] = $data;
            // $save_data = $get_data['instagram_slider'];
            array_push($get_data['instagram_slider'], $data);
        } else {
            $get_data['instagram_slider'][0] = $data;
        }

        // print_r($get_data);
        // exit;
        $about_data->value = json_encode($get_data);
        $about_data->save();

        return redirect()->route('admin.about-us')->with('message', 'Updated successfully');
    }

    public function about_us5_store(Request $request)
    {
        $request->validate([
            'image'        => [
                'required', 'mimes:jpeg,jpg,png', 'max:2024',
                Rule::dimensions()->maxWidth(1940)
            ]
        ]);
        $data = $request->only('image', 'title', 'description');
        $data['image'] = $request->file('image')->store('banner');

        // Banner::insert($data);


        $about_data = Setting::where('key', 'about_us')->first();

        $get_data = json_decode($about_data->value, true);

        if (isset($get_data['client_slider'])) {
            $cnt = count($get_data['client_slider']);
            // $save_data['client_slider'][$cnt+1] = $data;
            // $save_data = $get_data['client_slider'];
            array_push($get_data['client_slider'], $data);
        } else {
            $get_data['client_slider'][0] = $data;
        }

        // print_r($get_data);
        // exit;
        $about_data->value = json_encode($get_data);
        $about_data->save();

        return redirect()->route('admin.about-us')->with('message', 'Updated successfully');
    }

    public function about_us_delete(Request $request)
    {
        $reqdata = $request->input();
        // print_r($reqdata);
        $id = $reqdata['banner'];
        $about_us = Setting::where('key', 'about_us')->first();
        $about_us_data = json_decode($about_us->value, true);

        $i = 1;
        $j = 0;
        foreach ($about_us_data['slider_1'] as $key => $value) {
            if ($id == $i) {
                if (Storage::exists('storage/' . $value['image'])) {
                    unlink('storage/' . $value['image']);
                }
                unset($about_us_data['slider_1'][$j]);
                echo $j;
            }
            $i++;
            $j++;
        }

        $about_us->value = json_encode($about_us_data);
        $about_us->save();
        return redirect()->route('admin.about-us')->with('message', 'Deleted successfully');
    }

    public function about_us2_delete(Request $request)
    {
        $reqdata = $request->input();
        // print_r($reqdata);
        $id = $reqdata['banner'];
        $about_us = Setting::where('key', 'about_us')->first();
        $about_us_data = json_decode($about_us->value, true);

        $i = 1;
        $j = 0;
        foreach ($about_us_data['slider_2'] as $key => $value) {
            if ($id == $i) {
                if (Storage::exists('storage/' . $value['image'])) {
                    unlink('storage/' . $value['image']);
                }
                unset($about_us_data['slider_2'][$j]);
                echo $j;
            }
            $i++;
            $j++;
        }

        $about_us->value = json_encode($about_us_data);
        $about_us->save();
        return redirect()->route('admin.about-us')->with('message', 'Deleted successfully');
    }

    public function about_us4_delete(Request $request)
    {
        $reqdata = $request->input();
        // print_r($reqdata);
        $id = $reqdata['banner'];
        $about_us = Setting::where('key', 'about_us')->first();
        $about_us_data = json_decode($about_us->value, true);

        $i = 1;
        $j = 0;
        foreach ($about_us_data['instagram_slider'] as $key => $value) {
            if ($id == $i) {
                if (Storage::exists('storage/' . $value['image'])) {
                    unlink('storage/' . $value['image']);
                }
                unset($about_us_data['instagram_slider'][$j]);
                echo $j;
            }
            $i++;
            $j++;
        }

        $about_us->value = json_encode($about_us_data);
        $about_us->save();
        return redirect()->route('admin.about-us')->with('message', 'Deleted successfully');
    }

    public function about_us5_delete(Request $request)
    {
        $reqdata = $request->input();
        // print_r($reqdata);
        $id = $reqdata['banner'];
        $about_us = Setting::where('key', 'about_us')->first();
        $about_us_data = json_decode($about_us->value, true);

        $i = 1;
        $j = 0;
        foreach ($about_us_data['client_slider'] as $key => $value) {
            if ($id == $i) {
                if (Storage::exists('storage/' . $value['image'])) {
                    unlink('storage/' . $value['image']);
                }
                unset($about_us_data['client_slider'][$j]);
                echo $j;
            }
            $i++;
            $j++;
        }

        $about_us->value = json_encode($about_us_data);
        $about_us->save();
        return redirect()->route('admin.about-us')->with('message', 'Deleted successfully');
    }

    public function pages_show(){
        $get_pages = Setting::where('is_custom_page',1)->get();
        return view('admin.setting.pages_index', compact('get_pages'));
    }

    public function page_create(){
        return view('admin.setting.pages_form');
    }

    public function page_store(Request $request){
        $reqdata = $request->input();
        $title = isset($reqdata['title']) ? $reqdata['title'] : '';
        $slug = isset($reqdata['slug']) ? $reqdata['slug'] : '';
        $description = isset($reqdata['description']) ? $reqdata['description'] : '';

        $new_page = new Setting();
        $new_page->key = $title;
        $new_page->slug = $slug;
        $new_page->value = '<div class="container" style="margin-top: 35px;margin-bottom: 35px;">'.$description.'</div>';
        $new_page->is_custom_page = 1;
        $new_page->save();

        return redirect()->route('admin.pages_show')->with('message', 'Added successfully');
    }

    public function page_edit(Request $request){
        $reqdata = $request->input();
        $id = isset($reqdata['id']) ? $reqdata['id'] : '';

        $get_page_data = Setting::where('id',$id)->first();
        $action = 'edit';
        return view('admin.setting.pages_form',compact('get_page_data','action'));

    }

    public function page_update(Request $request){
        $reqdata = $request->input();
        $id = isset($reqdata['id']) ? $reqdata['id'] : '';
        $title = isset($reqdata['title']) ? $reqdata['title'] : '';
        $slug = isset($reqdata['slug']) ? $reqdata['slug'] : '';
        $description = isset($reqdata['description']) ? $reqdata['description'] : '';
        $get_page_data = Setting::where('id',$id)->first();
        $get_page_data->key = $title;
        $get_page_data->slug = $slug;
        $get_page_data->value = '<div class="container" style="margin-top: 35px;margin-bottom: 35px;">'.$description."</div>";
        $get_page_data->save();
        return redirect()->route('admin.pages_show')->with('message', 'Updated successfully');

    }

    public function page_delete(Request $request){
        $reqdata = $request->input();
        $id = isset($reqdata['id']) ? $reqdata['id'] : '';

        if (!Setting::where('id', $id)->delete()) {
            return back()->with('error', 'Failed');
        }

        return back()->with('message', 'Deleted');
    }
    public function page_change_status(Request $request){
        $reqdata = $request->input();
        $id = isset($reqdata['id']) ? $reqdata['id'] : '';
        $status = isset($reqdata['status']) ? $reqdata['status'] : '';

        if($status == 1){
            $change = 2;
        }else{
            $change = 1;
        }

        $admindata = Setting::where('id',$id)->first();
        $admindata->status = $change;
        $admindata->save();

        echo $change;
        // print_r($reqdata);
    }

    public function image_library(){
        $image_data = ImageLibrary::get();
        return view('admin.setting.image_library',compact('image_data'));
    }

    public function image_library_store(Request $request){

        $reqdata = request()->input();


        if($files=$request->file('galary_images')){
            foreach($files as $file){
                // $name='gallery_image-'.time().rand(1000000,9999999).$file->getClientOriginalName();
                $image_name  = $file->hashName();
                $image_path  = 'public/assets/image_library/';
                $file->store($image_path);
                ImageLibrary::insert(
                    ['image'=>$image_name,
                    'created_at' => date('Y-m-d  H:i:s'),
                    'created_by' => 1,
                    ]
                );
            }
            return back()->with('message', 'Images Added');
            exit;
        }
    }

    public function image_library_delete(){
        $reqdata = request()->input();
         $get_id = $reqdata['id'];
        $project_data = ImageLibrary::where('id', $get_id)->where('status', 1)->first();
         $image = $project_data->image;
        if($image != ''){
            $image_path  = 'public/assets/image_library/';
            Storage::delete($image_path.$image);
        }
        ImageLibrary::where('id',$get_id)->delete();
        return back()->with('message', 'Images Deleted');
            exit;
    }
}
