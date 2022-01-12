<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programs;
use Illuminate\Support\Facades\File;
use DataTables;

class ProgramsController extends Controller
{

    public function index()
    {
        return view('content/programs/index')
        	->with('posts',Programs::orderBy('updated_at','DESC')->get());
    }

    public function create()
    {
        return view('content/programs/create');
    }

    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Programs::orderBy('updated_at','DESC')->get();
            return Datatables::of($blogs)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $action_btn = '<a href="'. route('programs.edit', $row->id) .'" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a> <a href="'. route('programs.destroy', $row->id) .'" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>';
                    return $action_btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return false;
    }

    public function store(Request $request)
    {
       // return $request;
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
        

        Programs::create([
        	'status' => $request->input('status'),
            'thumbnail' => $newImageName,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'units' => json_encode($units, JSON_UNESCAPED_UNICODE),
            'duration' => $request->input('duration'),
        ]);
        
        return redirect( route('programs.index') )
            ->with('message', 'تم النشر بنجاح!');

    }

    public function edit($id)
    {
        if (Programs::find($id)):
        	return view('content/programs/edit')
                ->with('post', Programs::where('id', $id)->first());
        else:
        	return redirect( route('programs.index') )
                ->with('message', 'هذا البرنامج غير موجود!');
        endif;
    }

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
				    'units' => json_encode($units, JSON_UNESCAPED_UNICODE),
				    'duration' => $request->input('duration'),
		    ]);
        
        endif;
        
        return redirect( route('programs.edit', $id) )
            ->with('message', 'تم التعديل بنجاح!');
    }


    public function destroy($id)
    {
    	if (!Programs::find($id)):
    		return redirect( route('programs.index') )
                ->with('message', 'هذا البرنامج غير موجود!');
    	endif;
    	
        $post = Programs::where('id',$id)->first();
        if ($post->thumbnail && File::exists(public_path('images/programs/') . $post->thumbnail)) {
        	File::delete(public_path('images/programs/') . $post->thumbnail);
        }
        $post->delete();
        
        return redirect( route('programs.index') )
            ->with('message', 'تم حذف البرنامج!');
    }
}
