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
          <span id="BlogSpan">{{ $post->thumbnail ? '': 'اختر صورة (اختياري)'; }}</span>
          <img id="BlogActuallImage" src="{{ $post->thumbnail ? '/images/blogs/' . $post->thumbnail: ''; }}" style="width:300px;" class="{{ $post->thumbnail ? '': 'hidden'; }}" alt="{{ $post->title }}">
          <input id="BlogImage" type="file" name="thumbnail" accept="image/*" class="hidden">
      </label>
  </div>
  <div class="form-group">
    <label for="BlogTitle">العنوان (مطلوب)</label>
    <input type="text" class="form-control" value="{{ $post->title }}" id="BlogTitle" name="title">
  </div>
  <div class="form-group">
    <label for="BlogDescription">المحتوي (مطلوب)</label>
    <textarea class="form-control" id="BlogDescription" name="description" rows="3">{{ $post->description }}</textarea>
  </div>
  <button type="submit" class="btn btn-primary">حفظ</button>
</form>
@endsection
