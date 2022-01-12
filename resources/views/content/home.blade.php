@extends('layouts/contentLayoutMaster')

@section('title', 'الرئيسية')
@php
use App\Models\Service;
use App\Models\Blogs;
use App\Models\Programs;
@endphp
@section('content')

  <section id="dashboard-analytics">
    <div class="row match-height">
      <div class="col-xl-12 col-md-12 col-sm-12">
      <!-- Page layout -->
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">مرحبا بك في لوحة تحكم موقع {{WEBSITE_NAME}}🤍 </h4>
        </div>
        <div class="card-body">
          <div class="card-text">
            <p>
              يمكنك إدارة الموقع بشكل كامل عن طريق لوحة التحكم😍 , ومتوفر بها الآتي:
            </p>
            <ul>
              <li>إدارة التدوينات.</li>
              <li>إدارة الخدمات الإستشارية.</li>
              <li>إدارة البرامج التأهيلية.</li>
              <li>تعديل السلايدر في الصفحة الرئيسية.</li>
              <li>تعديل البيانات الخاصة بالموقع.</li>
            </ul>
          </div>
        </div>
      </div>
      </div>
      <!--/ Page layout -->

      <div class="col-xl-4 col-md-4 col-sm-6">
        <div class="card text-center">
          <div class="card-body">
            <div class="avatar bg-light-primary p-50 mb-1">
              <div class="avatar-content">
                <i data-feather="edit-2" class="font-medium-5"></i>
              </div>
            </div>
            <h2 class="font-weight-bolder">{{ Blogs::count() }}</h2>
            <p class="card-text">إجمالي التدوينات</p>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-4 col-sm-6">
        <div class="card text-center">
          <div class="card-body">
            <div class="avatar bg-light-primary p-50 mb-1">
              <div class="avatar-content">
                <i data-feather="phone" class="font-medium-5"></i>
              </div>
            </div>
            <h2 class="font-weight-bolder">{{ Service::count() }}</h2>
            <p class="card-text">إجمالي الخدمات الإستشارية</p>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-4 col-sm-6">
        <div class="card text-center">
          <div class="card-body">
            <div class="avatar bg-light-primary p-50 mb-1">
              <div class="avatar-content">
                <i data-feather="video" class="font-medium-5"></i>
              </div>
            </div>
            <h2 class="font-weight-bolder">{{ Programs::count() }}</h2>
            <p class="card-text">إجمالي البرامج التأهيلية</p>
          </div>
        </div>
      </div>

    </div>
  </section>
@endsection
