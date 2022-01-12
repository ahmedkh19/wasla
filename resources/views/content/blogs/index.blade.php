
@extends('layouts/contentLayoutMaster')

@section('title', 'التدوينات' )

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">

  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

@endsection

@section('page-style')
  <!-- Page css files -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">

  <style>
    img.services-image {
      height: 126px;
      width: 50%;
    }

  </style>
@endsection

@section('content')

  @include('content.alerts.success')
  @include('content.alerts.errors')
  @include('content.alerts.message')

  <div class="card-content collapse show">
    <div class="card-body card-dashboard">
      <table class="table display nowrap table-striped table-bordered scroll-horizontal dataTable">
        <thead class="">
        <tr>
          <th>العنوان</th>
          <th>الصورة الرئيسية</th>
          <th>الحالة</th>
          <th>الإجراءات</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
      <div class="justify-content-center d-flex">
      </div>

    </div>
  </div>


@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>

  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>


@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script>

  <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>



  <script>

    function getShortDescription(description) {
      let maxLength = 35 // maximum number of characters to extract

      let trimmedString = description.substr(0, maxLength);

      trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))
      return trimmedString + '...'
    }

    function checkStatus(status) {
      if (status === 1) {
        return 'مفعلة';
      } else {
        return 'غير مفعلة';
      }
    }
    $(document).ready( function () {
      $('.dataTable').DataTable({
        processing: true,
        serverSide: true,
        "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
        },
        ajax: "{{ route('blogs-ajax') }}",
        columns: [
          {data: 'title', name: 'title' , searchable: true},
          {data: 'thumbnail', name: 'thumbnail' , searchable: false},
          {data: 'status', name: 'status'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs:
                [
                  {
                    "targets": 1,
                    "data": 'thumbnail',
                    "render": function (data, type, row, meta) {
                      if (!!data)
                        return '<img class="services-image" src="{{asset("/images/blogs/")}}' + '/' + data + '"/>';
                      else
                        return 'لا توجد صورة';

                    }
                  },
                  {
                    "targets": 2,
                    "data": 'status',
                    "render": function (data, type, row, meta) {
                      return checkStatus(data)
                    }
                  },
                ],
        searching: true

      });
    });
  </script>
@endsection
