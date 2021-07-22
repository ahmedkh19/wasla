@extends('layouts/contentLayoutMaster')

@section('title', 'إضافة برنامج تأهيلي')


@section('content')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('programs.store') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                            @csrf

                            <div class="bg-grey-lighter pt-15 form-group">
								<label class="w-44 flex flex-col items-center px-5 py-5 bg-white-rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer">
									<span id="FORMSpan">اختر صورة (اختياري)</span>
									<img id="FORMActuallImage" src="" style="width:300px;" class="hidden">
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
                                        <input type="text" placeholder="ادخل عنوان البرنامج التأهيلي" name="title" id="ProgramTitle" class="form-control" value="{{ old('title') }}" />
                                        @error("title")
		                                	<span class="text-danger">{{$message}}</span>
		                                @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-2">
                                        <label for="ProgramStatus">الحالة</label>
                                        <select name="status" class="form-control" id="ProgramStatus">
                                            <option @if (old('status') == 1) selected @endif value="1">مفعلة</option>
                                            <option @if (old('status') == 2) selected @endif value="2">غير مفعلة</option>
                                        </select>
		                                @error("status")
		                                	<span class="text-danger">{{$message}}</span>
		                                @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="ProgramDescription">وصف البرنامج</label>
                                    <textarea rows="5" placeholder="ادخل وصف البرنامج" class="form-control" id="ProgramDescription" name="description" spellcheck="false">{{ old('description') }}</textarea>
                                    @error("description")
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-2">
		                            <div class="border rounded p-2">
		                                <p style="text-align:center;">المحتوي والوحدات</p>
		                                <textarea rows="3" placeholder="محتوي البرنامج" class="form-control"name="content" spellcheck="false">{{ old('content') }}</textarea>
		                                <div id="UnitsDiv" class="row" style="margin:10px 0;">
		                                	<div id="DivBefore" style="display:block;width:100%;padding-right:5px;">
		                                		<button class="btn btn-dark" id="AddUnit" type="button">إضافة وحدة</button>
		                                	</div>
		                                </div>
		                            </div>
                                </div>
                                
		                        <div class="col-md-12 form-group">
									<label style="width:75px;" for="ProgramDuration">مدة البرنامج</label>
									<input placeholder="ادخل مدة البرنامج" style="max-width:400px;display:inline;" type="text" name="duration" id="ProgramDuration" class="form-control" value="{{ old('duration') }}" />
								</div>

                                <div class="col-12 mt-50">
                                    <button type="submit" class="btn btn-primary mr-1">نشر</button>
                                    <button type="reset" id="ProgramsReset" class="btn btn-outline-secondary">إلغاء</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

