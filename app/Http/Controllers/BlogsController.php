<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blogs;
use Illuminate\Support\Facades\File;
use DataTables;

class BlogsController extends Controller
{

    public function index()
    {
        return view('content/blogs/index')
            ->with('posts',Blogs::orderBy('updated_at','DESC')->get());
    }

    public function create()
    {
        return view('content/blogs/create');
    }

    public function store(Request $request)
    {
    	$newImageName = '';

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'in:1,2'
        ]);

        if (isset($request->thumbnail)) {

		    $request->validate([
		        'thumbnail' => 'required|mimes:jpg,jpeg,png|max:5048',
		    ]);

        	$newImageName = uniqid() . '-' . $request->title . '.' . $request->thumbnail->extension();
        	
        	$request->thumbnail->move(public_path('images/blogs'), $newImageName);
 
        } else {
            $newImageName = 'image-placeholder.png';
        }
        

        Blogs::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'thumbnail' => $newImageName,
            'status' => $request->status,
        ]);

        return redirect()->back()->with(['success' => 'تمت ألاضافة بنجاح']);

        
    }

    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Blogs::orderBy('updated_at','DESC')->get();
            return Datatables::of($blogs)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $action_btn = '<a href="'. route('blogs.edit', $row->id) .'" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a> <a href="'. route('blogs.destroy', $row->id) .'" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>';
                    return $action_btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return false;
    }


    public function edit($id)
    {
        if (Blogs::where('id', $id)->first()):
        	return view('content/blogs/edit')
                ->with('post', Blogs::where('id', $id)->first());
        else:
            return redirect()->back()->with(['error' => 'هذه التدوينة غير موجودة! ']);
        endif;
        
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'in:1,2'

        ]);
        
        $blog = Blogs::find($id);
        if (isset($request->thumbnail)):

		    $request->validate([
		        'thumbnail' => 'required|mimes:jpg,jpeg,png|max:5048',
		    ]);
		    
		    $oldimage = Blogs::find($id)->thumbnail;
		    
		    if ($oldimage !== 'image-placeholder.png' && $oldimage && File::exists(public_path('images/blogs/') . $oldimage)):
		    	File::delete(public_path('images/blogs/') . $oldimage);
		    endif;

        	$newImageName = uniqid() . '-' . $request->title . '.' . $request->thumbnail->extension();
        	
        	$request->thumbnail->move(public_path('images/blogs'), $newImageName);

            $blog->update([
				    'title' => $request->input('title'),
				    'description' => $request->input('description'),
				    'thumbnail' => $newImageName,
				    'status' => $request->status,
		    ]);
	 
        else:

            $blog->update([
				    'title' => $request->input('title'),
				    'description' => $request->input('description'),
                'status' => $request->status,

            ]);
        
        endif;
        
        return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);

    }


    public function destroy($id)
    {
    	if (!Blogs::where('id',$id)->first()):
    		return redirect( route('blogs.index') )
                ->with('message', 'هذا المنشور غير موجود!');
    	endif;
    	
        $post = Blogs::where('id',$id)->first();
        if ($post->thumbnail !== 'image-placeholder.png' && $post->thumbnail && File::exists(public_path('images/blogs/') . $post->thumbnail)) {
        	File::delete(public_path('images/blogs/') . $post->thumbnail);
        }
        $post->delete();

        return redirect()->back()->with(['success' => 'تم الحذف بنجاح!']);

    }
}
