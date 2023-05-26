@extends('layouts.admin')

@section('css-after-bootstrap')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="card">
            <div class="card-body">
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <p class="card-title-desc">
                </p>
                <div class="row">
                    <div class="col-sm-12">
                        <h1>Coupons</h1>
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
        </div> <!-- end card body-->
    </div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
{!! $dataTable->scripts() !!}
@endsection
