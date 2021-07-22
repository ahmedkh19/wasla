@extends('layouts/contentLayoutMaster')

@section('title', 'تعديل : ' . $post->title)


@section('content')

@if (session()->has('message'))
	<div style="padding: 5px;" class="alert alert-primary" role="alert">
		{{ session()->get('message') }}
	</div>
@endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('programs.index') .'/' .$post->id }}" method="POST" enctype="multipart/form-data" class="mt-2">
                            @csrf
                            @method('PUT')
                            <div class="bg-grey-lighter pt-15 form-group">
								<label class="w-44 flex flex-col items-center px-5 py-5 bg-white-rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer">
									<span id="FORMSpan">{{ $post->thumbnail ? '': 'اختر صورة (اختياري)'; }}</span>
									<img id="FORMActuallImage" src="{{ $post->thumbnail ? '/images/programs/' . $post->thumbnail: ''; }}" style="width:300px;" class="{{ $post->thumbnail ? '': 'hidden'; }}" alt="{{ $post->title }}">
									<input id="FORMImage" type="file" name="thumbnail" accept="image/*" class="hidden">
								</label>
								    @error("thumbnail")
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
							</div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-2">
                                        <label for="ProgramTitle">عنوان البرنامج</label>
                                        <input type="text" placeholder="ادخل عنوان البرنامج التأهيلي" name="title" value="{{ $post->title }}" id="ProgramTitle" class="form-control" value="{{ old('title') }}" />
                                        @error("title")
		                                	<span class="text-danger">{{$message}}</span>
		                                @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-2">
                                        <label for="ProgramStatus">الحالة</label>
                                        <select name="status" class="form-control" id="ProgramStatus">
                                            <option @if ( $post->status == 1) selected @endif value="1">مفعلة</option>
                                            <option @if ( $post->status == 2) selected @endif value="2">غير مفعلة</option>
                                        </select>
		                                @error("status")
		                                	<span class="text-danger">{{$message}}</span>
		                                @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="ProgramDescription">وصف البرنامج</label>
                                    <textarea rows="5" placeholder="ادخل وصف البرنامج" class="form-control" id="ProgramDescription" name="description" spellcheck="false">{{ $post->description }}</textarea>
                                    @error("description")
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-2">
		                            <div class="border rounded p-2">
		                                <p style="text-align:center;">المحتوي والوحدات</p>
		                                <textarea rows="3" placeholder="محتوي البرنامج" class="form-control"name="content" spellcheck="false">{{ $post->content }}</textarea>
		                                <div id="UnitsDiv" class="row" style="margin:10px 0;">
		                                @foreach ( json_decode($post->units) as $unit )
                                	    <div class="col-md-6 col-12" style="padding: 5px;">
                                	    	<div class="rounded border p-1" style="background-color: rgb(115, 103, 240);">
                                	    		<div class="form-group">
                                	    			<input class="form-control" name="UnitNumber[]" value="{{ $unit->unit_number }}" placeholder="رقم الوحدة (مطلوب)" required="">
                                	    		</div>
		                            	    	<div class="form-group">
		                            	    		<input name="UnitTitle[]" value="{{ $unit->unit_title }}" class="form-control" placeholder="عنوان الوحدة (مطلوب)" required="">
		                            	    	</div>
		                            	    	<div class="form-group">
		                            	    		<textarea name="UnitContent[]" class="form-control" placeholder="محتوي الوحدة (اختياري)">{{ $unit->unit_content }}</textarea>
		                            	    	</div>
                                	    	</div>
                                	    	<span onclick="this.parentNode.remove();" class="Programsclose">X</span>
                                	    </div>
                                	    @endforeach
		                                	<div id="DivBefore" style="display:block;width:100%;padding-right:5px;">
		                                		<button class="btn btn-dark" id="AddUnit" type="button">إضافة وحدة</button>
		                                	</div>
		                                </div>
		                            </div>
                                </div>
                                
		                        <div class="col-md-12 form-group">
									<label style="width:75px;" for="ProgramDuration">مدة البرنامج</label>
									<input placeholder="ادخل مدة البرنامج" style="max-width:400px;display:inline;" type="text" name="duration" id="ProgramDuration" class="form-control" value="{{ $post->duration }}" />
								</div>

                                <div class="col-12 mt-50">
                                    <button type="submit" class="btn btn-primary mr-1">حفظ</button>
                                    <a href="{{ route('programs.index') }}" class="btn btn-dark">عودة</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

