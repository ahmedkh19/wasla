
@extends('layouts/contentLayoutMaster')

@section('title', 'إضافة خدمة إستشارية')

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

    <style>
        #addItem{
            right: 1%;
            top: 50%;
            transform: translate(0,-50%);
            padding: 10px 20px;
            font-size: 20px;
            font-weight: 700;
            color: #f5f5f5;
            border: 2px solid #f5f5f5;
            border-radius: 5px;
            background: gray;
            cursor: pointer;
            transition: all 0.3s linear 0s;}
        #addItem:hover{ color: burlywood;}


    </style>
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
                        <!-- Form -->
                        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-2">
                                        <label for="blog-edit-title">إسم الخدمة</label>
                                        <input
                                                type="text"
                                                name="name"
                                                id="blog-edit-title"
                                                class="form-control"
                                                placeholder="تصميم الاستراتيجية الاتصالية"
                                                value="{{ old('name') }}"
                                        />
                                    </div>
                                    @error("name")
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-2">
                                        <label for="blog-edit-status">الحالة</label>
                                        <select name="status" class="form-control" id="blog-edit-status">
                                            <option @if (old ('status') === 1) selected @endif
                                                    value=1>مفعلة</option>
                                            <option @if (old ('status') === 2) selected @endif
                                                    value=2>غير مفعلة</option>
                                        </select>
                                    </div>
                                    @error("status")
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="description">الوصف</label>
                                    <textarea rows="5" class="form-control" id="description" name="description" spellcheck="false" placeholder="تتعدد أنواع وأساليب التخطيط الاستراتيجي حسب نوع نشاط المنظمة وبالرغم من أن الكثير يعتمد على التخطيط كوظيفة إدارية بغرض إدارة أداء المنظمة نحو أهداف محددة، إلا أننا نعمل في وصلة مع المنظمات غير الربحية على تصميم استراتيجية اتصالية تمكن المنظمة من تحقيق الاتصال الفعال مع مجتمعها المحلي وإدماج المستفيدين من خدماتها في عملية تصميم وتنفيذ مشاريعها التنموية وهو ما يضمن التركيز على قضية المنظمة واستدامة أثر تدخلاتها التنموية، حيث تُعد الاستراتيجية الاتصالية للمنظمة أسلوباً جديداً وفاعلاً لقيادة المنظمات غير الربحية نحو تحقيق أثر أعمق ومستدام">{{ old('description') }}</textarea>
                                    @error("description")
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-2">
                                    <div class="border rounded p-2" >
                                        <h4 class="mb-1">المميزات/المحتوى</h4>
                                        <button type="button" id="addItem" style="float: left !important;">+</button>
                                        <div class="row">
                                            <div id="Services">
                                                    <div class="form-group mb-2">

                                                        <label for="blog-content">المميزة</label>
                                                        <input
                                                                type="text"
                                                                name="content[]"
                                                                id="blog-content"
                                                                class="form-control"
                                                                placeholder="الاستراتيجية الاتصالية"
                                                        />
                                                    </div>
                                            </div>
                                        </div>
                                        @error("content")
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                    <div class="col-12 mb-2">
                                    <div class="border rounded p-2">
                                        <h4 class="mb-1">الصورة الرئيسية</h4>
                                        <div class="media flex-column flex-md-row">
                                            <img
                                                    src="{{asset('/storage/uploads/images/services/image-placeholder.png')}}"
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
                                                            <input name="image" type="file" class="custom-file-input" id="blogCustomFile" accept="image/*" />
                                                            <label class="custom-file-label" for="blogCustomFile">إختر الصورة</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-50">
                                    <button type="submit" class="btn btn-primary mr-1">نشر</button>
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

    <script>

        //To add more inputs
        $('#addItem').click(function(){
            $('#Services').append(`
               <div class="form-group mb-2">
                  <label for="blog-content">المميزة</label>
                   <input
                          type="text"
                          name="content[]"
                          id="blog-content"
                          class="form-control"
                          placeholder="الاستراتيجية الاتصالية"
                  />
               </div>
            `);
        });

    </script>
@endsection
