<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blogs;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\File;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content/blogs/index')
            ->with('posts',Blogs::orderBy('updated_at','DESC')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content/blogs/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
    	$newImageName = '';

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        if (isset($request->thumbnail)) {

		    $request->validate([
		        'thumbnail' => 'required|mimes:jpg,jpeg,png|max:5048',
		    ]);

        	$newImageName = uniqid() . '-' . $request->title . '.' . $request->thumbnail->extension();
        	
        	$request->thumbnail->move(public_path('images/blogs'), $newImageName);
 
        }
        
        $slug = SlugService::createSlug(Blogs::class, 'slug', $request->title);
        
        Blogs::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => $slug,
            'thumbnail' => $newImageName,
        ]);
        
        return redirect( route('blogs.index') )
            ->with('message', 'تم النشر بنجاح!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // i think we don't neew this cuz we gonna use VueJs
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Blogs::where('id', $id)->first()):
        	return view('content/blogs/edit')
                ->with('post', Blogs::where('id', $id)->first());
        else:
        	return redirect( route('blogs.index') )
                ->with('message', 'هذا المنشور غير موجود!');
        endif;
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $slug = SlugService::createSlug(Blogs::class, 'slug', $request->title);

        if (isset($request->thumbnail)):

		    $request->validate([
		        'thumbnail' => 'required|mimes:jpg,jpeg,png|max:5048',
		    ]);
		    
		    $oldimage = Blogs::where('id', $id)->first()->thumbnail;
		    
		    if ($oldimage && File::exists(public_path('images/blogs/') . $oldimage)):
		    	File::delete(public_path('images/blogs/') . $oldimage);
		    endif;

        	$newImageName = uniqid() . '-' . $request->title . '.' . $request->thumbnail->extension();
        	
        	$request->thumbnail->move(public_path('images/blogs'), $newImageName);
        	
		    Blogs::where('id', $id)
		        ->update([
				    'title' => $request->input('title'),
				    'description' => $request->input('description'),
				    'slug' => $slug,
				    'thumbnail' => $newImageName,
		    ]);
	 
        else:

		    Blogs::where('id', $id)
		        ->update([
				    'title' => $request->input('title'),
				    'description' => $request->input('description'),
				    'slug' => $slug,
		    ]);
        
        endif;
        
        return redirect( route('blogs.edit', $id) )
            ->with('message', 'تم التعديل بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	if (!Blogs::where('id',$id)->first()):
    		return redirect( route('blogs.index') )
                ->with('message', 'هذا المنشور غير موجود!');
    	endif;
    	
        $post = Blogs::where('id',$id)->first();
        if ($post->thumbnail && File::exists(public_path('images/blogs/') . $post->thumbnail)) {
        	File::delete(public_path('images/blogs/') . $post->thumbnail);
        }
        $post->delete();
        
        return redirect( route('blogs.index') )
            ->with('message', 'تم حذف المنشور!');
    }
}
