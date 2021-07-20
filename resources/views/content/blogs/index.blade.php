@extends('layouts/contentLayoutMaster')

@section('title', 'التدوينات')

@section('content')

@if (!count($posts))
<div class="card text-center">
  <div class="card-body">
    <p class="card-text">لا يوجد تدوينات</p>
    <a href="{{ route('blogs.create') }}" class="btn btn-primary">إضافة جديد</a>
  </div>
</div>
@else

@if (session()->has('message'))
    <div style="padding: 5px;" class="alert alert-primary" role="alert">
    	{{ session()->get('message') }}
    </div>
@endif

@foreach( $posts as $post )
<div class="card mb-3">
  <div class="row g-0" style="height: 230px;">
  @if ($post->thumbnail)
    <div class="col-md-4" style="height:100%">
      <img src="{{ '/images/blogs/' . $post->thumbnail }}" style="width:100%;height:100%;" class="img-fluid rounded-start" alt="{{ $post->title }}">
    </div>
  @endif
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">{{ $post->title }}</h5>
        <p class="card-text">{{ Str::limit(strip_tags($post->description), 100) }}</p>
        <p class="card-text"><small class="text-muted">{{ date('D, d M Y', strtotime($post->updated_at)) }}</small></p>
        <a href="{{ route('blogs.edit' , $post->id) }}" class="btn btn-primary">تعديل</a>
        <form style="display:inline;" method="POST" action="{{ route('blogs.index') . '/' . $post->id }}">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">حذف</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

@endif

@endsection
