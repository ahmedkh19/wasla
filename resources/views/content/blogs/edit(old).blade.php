@extends('layouts/contentLayoutMaster')

@section('title', 'تعديل : ' . $post->title)

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

@if (session()->has('message'))
    <div style="padding: 5px;" class="alert alert-primary" role="alert">
    	{{ session()->get('message') }}
    </div>
@endif

<a href="{{ route('blogs.index') }}" style="margin-bottom: 10px;" class="btn btn-dark">عودة</a>
<form action="{{ route('blogs.index') .'/' .$post->id }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <div class="bg-grey-lighter pt-15 form-group">
      <label class="w-44 flex flex-col items-center px-5 py-5 bg-white-rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer">
          <span id="BlogSpan">{{ $post->thumbnail ? '': 'اختر صورة (اختياري)' }}</span>
          <img id="BlogActuallImage" src="{{ $post->thumbnail ? '/images/blogs/' . $post->thumbnail: '' }}" style="width:300px;" class="{{ $post->thumbnail ? '': 'hidden'; }}" alt="@if (old('title')){{old('title')}}@else{{$post->title}}@endif">
          <input id="BlogImage" type="file" name="thumbnail" accept="image/*" class="hidden">
      </label>
  </div>
  <div class="form-group">
    <label for="BlogTitle">العنوان (مطلوب)</label>
    <input type="text" class="form-control" value="@if (old('title')){{old('title')}}@else{{$post->title}}@endif" id="BlogTitle" name="title">
  </div>
  <div class="form-group">
    <label for="BlogDescription">المحتوي (مطلوب)</label>
      <textarea class="form-control tinymce" id="ckeditor" name="description" cols="30" rows="10">@if (old('description')){{old('description')}}@else{{$post->description}}@endif</textarea>
  </div>
  <button type="submit" class="btn btn-primary">حفظ</button>
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

