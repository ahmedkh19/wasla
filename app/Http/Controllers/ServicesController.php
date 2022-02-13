<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicesRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class ServicesController extends Controller
{
    public function index()
    {
        return view('content.services.index');
    }

    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            $services = Service::orderBy('id','DESC')->get();
            return Datatables::of($services)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $action_btn = '<a href="'. route('services.edit', $row->id) .'" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a> <a href="'. route('services.destroy', $row->id) .'" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>';
                    return $action_btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return false;
    }


    public function create()
    {
        return view('content.services.create');
    }

    public function store(ServicesRequest $request)
    {
        try {
            DB::beginTransaction();
            $service = Service::create($request->except(['image']));
            if (!empty($request->image)) {
                $service->image = uploadImage('services', $request->image);
            } else {
                $service->image = 'image-placeholder.png';
            }
           $service->save();
            DB::commit();
            return redirect()->back()->with(['success' => 'تمت ألاضافة بنجاح']);
        }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with(['error' => 'هناك خطا حصل : '. $ex]);
        }

    }


    public function edit($id)
    {
        $service = Service::find($id);
        return view('content.services.edit', compact('service'));
    }


    public function update($id, ServicesRequest $request)
    {
        try {
            DB::beginTransaction();
            $service = Service::find($id);
            $service->update($request->except('image'));

            if (!empty($request->image)) {
               if ( deleteImage('services',$service->image) ) {
                   $service->image = uploadImage('services', $request->image);
               }
            }
            $service->save();
            DB::commit();
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'لقد حدث خطأ، رجاء أعد المحاولة لاحقا : '. $ex]);

        }

    }


    public function destroy($id)
    {
        try {
            $service = Service::find($id);
            if (!$service)
                return redirect()->back()->with(['error' => 'لقد حدث خطأ، رجاء أعد المحاولة لاحقا']);

            if ( deleteImage('services',$service->image) ) {
                $service->delete();
                return redirect()->back()->with(['success' => 'تم الحذف بنجاح!']);
            }
            return redirect()->back()->with(['error' => 'لقد حدث خطأ، رجاء أعد المحاولة لاحقا']);

        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'لقد حدث خطأ، رجاء أعد المحاولة لاحقا']);
        }
    }

}
