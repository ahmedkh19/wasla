
@extends('layouts/contentLayoutMaster')

@section('title', 'تعديل :' . $post->title)

@section('vendor-style')
    <link rel="stylesheet" href="{{asset(mix('vendors/css/forms/select/select2.min.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/katex.min.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/monokai-sublime.min.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('vendors/css/editors/quill/quill.snow.css'))}}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" type="text/css" href="{{asset(mix('css/base/plugins/forms/form-quill-editor.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{asset(mix('css/base/pages/page-blog.css'))}}">

@endsection

@section('content')
    <!-- Blog Edit -->
    <div class="blog-edit-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('content.alerts.success')
                        @include('content.alerts.errors')
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                    @endif

                    <!-- Form -->
                        <form action="{{ route('blogs.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-2">
                                        <label for="BlogTitle">العنوان (مطلوب)</label>
                                        <input
                                                type="text"
                                                name="title"
                                                id="BlogTitle"
                                                class="form-control"
                                                placeholder="تصميم الاستراتيجية الاتصالية"
                                                value="@if (old('title')){{old('title')}}@else{{$post->title}}@endif"
                                        />
                                    </div>
                                    @error("title")
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-2">
                                        <label for="blog-edit-status">الحالة</label>
                                        <select name="status" class="form-control" id="blog-edit-status">
                                            <option @if (old ('status') === 1 || $post->status === 1) selected @endif
                                            value=1>مفعلة</option>
                                            <option @if (old ('status') === 2 || $post->status === 2) selected @endif
                                            value=2>غير مفعلة</option>
                                        </select>
                                    </div>
                                    @error("status")
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="description">الوصف</label>
                                    <textarea class="form-control tinymce" id="ckeditor" name="description" cols="30" rows="10">@if (old('description')){{old('description')}}@else{{$post->description}}@endif</textarea>
                                    @error("description")
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-2">
                                    <div class="border rounded p-2">
                                        <h4 class="mb-1">الصورة الرئيسية</h4>
                                        <div class="media flex-column flex-md-row">
                                            <img
                                                    src="@if ($post->thumbnail){{asset('/images/blogs/' . $post->thumbnail)}} @else {{asset('/images/blogs/image-placeholder.png')}} @endif"
                                                    id="blog-feature-image"
                                                    class="rounded mr-2 mb-1 mb-md-0"
                                                    width="170"
                                                    height="110"
                                                    alt="Blog Featured Image"
                                            />
                                            <div class="media-body">
                                                <h5 class="mb-0">الصورة الرئيسية:</h5>
                                                @error("image")
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                                <p class="my-50">
                                                    <a href="javascript:void(0);" id="blog-image-">.</a>
                                                </p>
                                                <div class="d-inline-block">
                                                    <div class="form-group mb-0">
                                                        <div class="custom-file">
                                                            <input name="thumbnail" type="file" class="custom-file-input" id="blogCustomFile" accept="image/*" />
                                                            <label class="custom-file-label" for="blogCustomFile">إختر الصورة</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-50">
                                    <button type="submit" class="btn btn-primary mr-1">تعديل</button>
                                    <button type="reset" class="btn btn-outline-secondary">إلغاء</button>
                                </div>
                            </div>
                        </form>
                        <!--/ Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Blog Edit -->
@endsection

@section('vendor-script')
    <script src="{{asset(mix('vendors/js/forms/select/select2.full.min.js'))}}"></script>
    <script src="{{asset(mix('vendors/js/editors/quill/katex.min.js'))}}"></script>
    <script src="{{asset(mix('vendors/js/editors/quill/highlight.min.js'))}}"></script>
    <script src="{{asset(mix('vendors/js/editors/quill/quill.min.js'))}}"></script>
@endsection

@section('page-script')
    <script src="{{asset(mix('js/scripts/pages/page-blog-edit.js'))}}"></script>
    <script src="{{asset('vendors/js/editors/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.config.extraPlugins = 'embedbase';
        CKEDITOR.config.embed_provider = '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}'

        CKEDITOR.config.extraPlugins = 'embed';
        CKEDITOR.replace('ckeditor', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
    </script>
@endsection
