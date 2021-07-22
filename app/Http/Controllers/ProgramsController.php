<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\Programs;
use Illuminate\Support\Facades\File;

class ProgramsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content/programs/index')
        	->with('posts',Programs::orderBy('updated_at','DESC')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content/programs/create');
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
    	
    	$units = array();
    	
    	if (isset($request->UnitNumber) && isset($request->UnitTitle) && isset($request->UnitContent)):
    		foreach ( $request->UnitNumber as $key => $value ):
    			$unit_hold = array();
    			if ( isset($request->UnitTitle[$key]) ):
    				$unit_number = $value;
    				$unit_title = $request->UnitTitle[$key];
    				$unit_content = $request->UnitContent[$key];
    				
    				$unit_hold = [
    					'unit_number' => $unit_number,
    					'unit_title' => $unit_title,
    					'unit_content' => $unit_content,
    				];
    				
    				$units[] = $unit_hold;

    			endif;
    		endforeach;
    	endif;

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:1,2',
        ]);

        if (isset($request->thumbnail)) {

		    $request->validate([
		        'thumbnail' => 'required|mimes:jpg,jpeg,png|max:5048',
		    ]);

        	$newImageName = uniqid() . '-' . $request->title . '.' . $request->thumbnail->extension();
        	
        	$request->thumbnail->move(public_path('images/programs'), $newImageName);
 
        }
        
        $slug = SlugService::createSlug(Programs::class, 'slug', $request->title);
        
        Programs::create([
        	'status' => $request->input('status'),
            'thumbnail' => $newImageName,
            'title' => $request->input('title'),
            'slug' => $slug,
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'units' => json_encode($units, JSON_UNESCAPED_UNICODE),
            'duration' => $request->input('duration'),
        ]);
        
        return redirect( route('programs.index') )
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Programs::find($id)):
        	return view('content/programs/edit')
                ->with('post', Programs::where('id', $id)->first());
        else:
        	return redirect( route('programs.index') )
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
    	
    	$units = array();
    	
    	if (isset($request->UnitNumber) && isset($request->UnitTitle) && isset($request->UnitContent)):
    		foreach ( $request->UnitNumber as $key => $value ):
    			$unit_hold = array();
    			if ( isset($request->UnitTitle[$key]) ):
    				$unit_number = $value;
    				$unit_title = $request->UnitTitle[$key];
    				$unit_content = $request->UnitContent[$key];
    				
    				$unit_hold = [
    					'unit_number' => $unit_number,
    					'unit_title' => $unit_title,
    					'unit_content' => $unit_content,
    				];
    				
    				$units[] = $unit_hold;

    			endif;
    		endforeach;
    	endif;
    	
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:1,2',
        ]);
        
        $slug = SlugService::createSlug(Programs::class, 'slug', $request->title);

        if (isset($request->thumbnail)):

		    $request->validate([
		        'thumbnail' => 'required|mimes:jpg,jpeg,png|max:5048',
		    ]);
		    
		    $oldimage = Programs::where('id', $id)->first()->thumbnail;
		    
		    if ($oldimage && File::exists(public_path('images/programs/') . $oldimage)):
		    	File::delete(public_path('images/programs/') . $oldimage);
		    endif;

        	$newImageName = uniqid() . '-' . $request->title . '.' . $request->thumbnail->extension();
        	
        	$request->thumbnail->move(public_path('images/programs'), $newImageName);
        	
		    Programs::where('id', $id)
		        ->update([
				    'thumbnail' => $newImageName,
				    'title' => $request->input('title'),
				    'status' => $request->input('status'),
				    'description' => $request->input('description'),
				    'content' => $request->input('content'),
				    'slug' => $slug,
				    'units' => json_encode($units, JSON_UNESCAPED_UNICODE),
				    'duration' => $request->input('duration'),
		    ]);
	 
        else:

		    Programs::where('id', $id)
		        ->update([
				    'title' => $request->input('title'),
				    'status' => $request->input('status'),
				    'description' => $request->input('description'),
				    'content' => $request->input('content'),
				    'slug' => $slug,
				    'units' => json_encode($units, JSON_UNESCAPED_UNICODE),
				    'duration' => $request->input('duration'),
		    ]);
        
        endif;
        
        return redirect( route('programs.edit', $id) )
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
    	if (!Programs::find($id)):
    		return redirect( route('programs.index') )
                ->with('message', 'هذا المنشور غير موجود!');
    	endif;
    	
        $post = Programs::where('id',$id)->first();
        if ($post->thumbnail && File::exists(public_path('images/programs/') . $post->thumbnail)) {
        	File::delete(public_path('images/programs/') . $post->thumbnail);
        }
        $post->delete();
        
        return redirect( route('programs.index') )
            ->with('message', 'تم حذف المنشور!');
    }
}
