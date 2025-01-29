<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;
class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('blog-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    public function index()
    {
        $blog = Blog::latest()->get();
        return view('admin.pages.blog.index', compact('blog'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'details' => 'required',
            ]);

            $blog = new Blog();
            $blog->title = $request->title;
            $blog->details = $request->details;
        
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext=$file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $path = 'blog';
                $file->move(public_path($path), $filename);
                 $fullPath = $path . '/' . $filename;
    
            }
            else {
                $fullPath = null;
            }
            $blog->image = $fullPath;
            $blog->save();
            
            Toastr::success('Blog Added Successfully', 'Success');
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
            ]);
            
            $blog = Blog::find($id);
            $blog->title = $request->title;
            $blog->details = $request->details;
           
            
            if ($request->hasFile('image')) {
                $file = $request->file('image');

                if ($blog->image && file_exists(public_path($blog->image))) {
                    unlink(public_path($blog->image));
                }

                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'images/blog';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;
            }
            else{
                $fullpath = $blog->image;
            }
            $blog->image = $fullpath;
            $blog->status = $request->status;
            $blog->save();
            Toastr::success('Blog Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $blog = Blog::find($id);
            $imagePath = public_path('images/blog/' . $blog->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Delete the Team member
            $blog->delete();
            Toastr::success('Blog Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
