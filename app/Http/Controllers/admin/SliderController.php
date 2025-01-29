<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('slider-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }


        public function index()
        {
            $sliders = Slider::all();
            return view('admin.pages.slider.index', compact('sliders'));
        }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);

            $slider = new Slider();
            $slider->company_id = auth()->user()->id;
            $slider->title = $request->title;
            $slider->description = $request->description;
        
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext=$file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $path = 'slider';
                $file->move(public_path($path), $filename);
                 $fullPath = $path . '/' . $filename;
    
            }
            else {
                $fullPath = null;
            }
            $slider->image = $fullPath;
            $slider->save();
            
            Toastr::success('Slider Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);
            
            $slider = Slider::find($id);
            $slider->company_id = auth()->user()->id;
            $slider->title = $request->title;
            $slider->description = $request->description;
           
            
            if ($request->hasFile('image')) {
                $file = $request->file('image');

                if ($slider->image && file_exists(public_path($slider->image))) {
                    unlink(public_path($slider->image));
                }

                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'slider';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;
            }
            else{
                $fullpath = $slider->image;
            }
            $slider->image = $fullpath;
            $slider->status = $request->status;
            $slider->save();
            Toastr::success('Slider Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $slider = Slider::find($id);

            if ($slider->image && file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }
            $slider->delete();
            Toastr::success('Slider Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}

