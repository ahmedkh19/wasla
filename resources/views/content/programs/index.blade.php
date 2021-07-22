@extends('layouts/contentLayoutMaster')

@section('title', 'البرامج التأهيلية')

@section('content')

@if (!count($posts))
<div class="card text-center">
  <div class="card-body">
    <p class="card-text">لا يوجد برامج</p>
    <a href="{{ route('programs.create') }}" class="btn btn-primary">إضافة برنامج جديد</a>
  </div>
</div>
@else

@if (session()->has('message'))
    <div style="padding: 5px;" class="alert alert-primary" role="alert">
    	{{ session()->get('message') }}
    </div>
@endif

@foreach( $posts as $post )
    {{-- datatables here --}}
@endforeach

@endif

@endsection
