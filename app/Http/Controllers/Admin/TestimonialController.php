<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {  
        $testimonials = Testimonial::all();         
        return view('admin.setting.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.setting.testimonial.add');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        if(! empty($data['image'])) {
            $data['image'] = $request->file('image')->store('testimonials') ;
        }

        if( ! Testimonial::create($data) )
        {
            return back()->with('error', 'failed to create');
        }

        return redirect()->route('admin.settings.testimonials.index')->with('message', "created successfully");
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.setting.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->except('_token', '_method');

        if(! empty($data['image'])) {
            $data['image'] = $request->file('image')->store('testimonials') ;
        }

        if( ! $testimonial->update($data) )
        {
            return back()->with('error', 'failed to create');
        }

        return redirect()->route('admin.settings.testimonials.index')->with('message', "created successfully");
    }

    public function destroy(Testimonial $testimonial)
    {
        if( ! $testimonial->delete() ) {
            return back()->with('error', 'failed to delete');
        }
        return back()->with('message', 'deleted successfully');
    }

}
