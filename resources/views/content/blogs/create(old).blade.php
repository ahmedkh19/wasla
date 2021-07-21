@extends('layouts/contentLayoutMaster')

@section('title', 'إضافة جديد')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('blogs.index') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="bg-grey-lighter pt-15 form-group">
      <label class="w-44 flex flex-col items-center px-5 py-5 bg-white-rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer">
          <span id="BlogSpan">اختر صورة (اختياري)</span>
          <img id="BlogActuallImage" src="" style="width:300px;" class="hidden">
          <input id="BlogImage" type="file" name="thumbnail" accept="image/*" class="hidden">
      </label>
  </div>
  <div class="col-md-6 col-12 form-group mb-2">
    <label for="BlogTitle">العنوان (مطلوب)</label>
    <input type="text" class="form-control" id="BlogTitle" name="title">
  </div>
    <div class="col-md-6 col-12 form-group mb-2">
        <label for="BlogTitle">الحالة (مطلوبة)</label>
        <input type="text" class="form-control" id="BlogTitle" name="title">
    </div>

  <div class="form-group">
    <label for="BlogDescription">المحتوي (مطلوب)</label>
    <textarea class="form-control tinymce" id="ckeditor" name="description" cols="30" rows="10">{{ old('description') }}</textarea>
  </div>
  <button type="submit" class="btn btn-primary">نشر</button>
</form>
@endsection

@section('page-script')
    <script src="{{asset('vendors/js/editors/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.config.extraPlugins = 'embedbase';
        CKEDITOR.config.embed_provider = '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}'

        CKEDITOR.config.extraPlugins = 'embed';
        CKEDITOR.replace('ckeditor', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
    </script>
@endsection
