<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BranchDeliverablePincode;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Product;
use App\Models\ProductPackMap;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use App\Models\EmailSubscription;
use App\Models\Setting;
use Session;
use DB;


class HomeController extends Controller
{
    public function index()
    {
        // Session::forget('pincode');
        // Session::forget('top_bar_message');

       // Session::forget('cart');
    //    dd(Session::get('branch_id'));
        //print_r(count(Session::get('cart')));die;
        // $banners = cache()->remember( Banner::CACHE_KEY, 60*60 ,function() {
        //     return Banner::all();
        // });
        $about_us_data = Setting::where('key','about_us')->first();
        $about_us_data_array = json_decode($about_us_data->value,true);
        $banners = Banner::orderBy('sequence','ASC')->get();
        $categories =  Category::active()->get();

        $metadata['meta_title'] = 'Storia Foods - Home';
        $metadata['meta_description'] = 'Storia Foods - Home';

        return view('front.index',compact('categories', 'banners','about_us_data_array','metadata'));
    }

    public function blog()
    {
        $blogs = Blog::get();
        $metadata['meta_title'] = 'Storia Foods - Blogs';
        $metadata['meta_description'] = 'Storia Foods - Blogs';

        return view('front.blog', compact('blogs','metadata'));
    }

    public function blog_details($slug){

        //$Products =Products::find(1);
        $blogDetails =Blog::select('*')->where('slug',$slug)->first();
        $blogs = Blog::where('id', '!=', $blogDetails->id)->orderBy('id','desc')->get();
        return view('front.blog_details', ['blogs' => $blogs,'blogDetails'=>$blogDetails]);
    }

    public function recipes($slug = null)
    {
        $recipeCategories = RecipeCategory::all();
        if($slug) {
            $category = $recipeCategories->where('slug', $slug)->first();
            abort_if(!$category, 404 );
            $category->load('recipes');
        } else {
            $category = $recipeCategories->first()->load('recipes');
        }

        $metadata['meta_title'] = 'Storia Foods - recipes';
        $metadata['meta_description'] = 'Storia Foods - recipes';

        return view('front.recipes', compact('recipeCategories', 'category','metadata'));
    }

    public function aboutus()
    {
        $about_us_data = Setting::where('key','about_us')->first();
        $about_us_data_array = json_decode($about_us_data->value,true);

        $metadata['meta_title'] = 'Storia Foods - About Us';
        $metadata['meta_description'] = 'Storia Foods - About Us';

        return view('front.aboutus',compact('about_us_data','about_us_data_array','metadata'));
    }

    public function contactus()
    {
        $metadata['meta_title'] = 'Storia Foods - Contact Us';
        $metadata['meta_description'] = 'Storia Foods - Contact Us';

        return view('front.contactus',compact('metadata'));
    }

    public function products()
    {
        return view('front.products');
    }

    public function storePincode(Request $request)
    {
        // check if deliverable
        $deliverablePincode= DB::table('branch_deliverable_pincodes')
                            ->select('id', 'branch_id', 'pincode')
                            ->where('pincode', $request->pincode)
                            ->first();

        if( ! $deliverablePincode ) {
            Session::put('top_bar_message', "<strong>Oops!</strong>  We currently do no service this location");
            return back();
        } else {
            Session::put('top_bar_message', "<strong>Yay!</strong>  We are servicing to this location");
        }
        Session::put('pincode', $request->pincode);
        $branchId = $deliverablePincode->branch_id;
        // dd($branch);
        Session::put('branch_id',$branchId);
        return back();
    }

    public function pincodeDeclined()
    {
        Session::put('pincode_declined', 1);
    }

    public function recipeShow(Recipe $recipe)
    {
        $recipe->load('category');
        return view('front.show_recipe', compact('recipe') );
    }

    public function getPriceForProductPack(Request $request)
    {
        $pack = ProductPackMap::where(['id' => $request->pack_id, 'product_id' => $request->product_id ])->with('product', 'details')->first();
        // dump($request->pack_id );
        // dd($pack);

        $productPrice = $pack->product->price;
        $packSize     = $pack->details->quantity;

        $price = $productPrice * $packSize;

        $priceWithoutDiscount = $price;

        if($pack->discount) {
            $price = $price - $pack->discount;
        }

        return $this->successJsonResponse([
            'price' => $price,
            'pack_title' => $pack->details->title,
            'price_without_discount' => $priceWithoutDiscount,
            'discount' => $pack->discount,
            'is_product_in_stock' => $pack->is_product_in_stock
        ]);
    }

    public function contactInfoSave(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required',
            'contact_no' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        ContactUs::create($request->all());

        return back()->with('success', 'Thanks for your message');
    }


    public function subscribeToEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:email_subscriptions'
        ]);
        // dd($request->email);
        if( ! EmailSubscription::create(['email' => $request->email]) ) {
            return back()->with('error', 'Failed');
        }
        return back()->with('message', "You have been subscribed successfully");
    }

    public function terms()
    {
        $metadata['meta_title'] = 'Storia Foods - Terms And Conditions';
        $metadata['meta_description'] = 'Storia Foods -Terms And Conditions';

        return view('front.terms',compact('metadata'));
    }

    public function privacyPolicy()
    {
        $metadata['meta_title'] = 'Storia Foods - Privacy Policy';
        $metadata['meta_description'] = 'Storia Foods -Privacy Policy';

        return view('front.privacy_policy',compact('metadata'));
    }

    public function refundPolicy()
    {
        $metadata['meta_title'] = 'Storia Foods - Refund Policy';
        $metadata['meta_description'] = 'Storia Foods - Refund Policy';

        return view('front.refund_policy',compact('metadata'));
    }

    public function getCitiesByState(Request $request)
    {
        // dd($request->all());

        $cities = BranchDeliverablePincode::cities($request->state);


        return $this->successJsonResponse([ 'cities' => $cities ]);
    }

    public function show_page($slug){
        // print_r($slug);
        $get_page_data = Setting::where('is_custom_page',1)->where('status',1)->where('slug',$slug)->first();
        return view('front.show_page',compact('get_page_data'));
    }

}
