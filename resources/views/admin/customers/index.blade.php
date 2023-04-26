@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 my-2">
                        <div class="float-start">
                            <h2>{{ $h2title }}</h2>
                        </div>
                        <div class="float-end">
                        </div>
                    </div>
                </div>


                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"></h4>
                <p class="card-title-desc">
                </p>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-between">
                            {{-- <a class="btn btn-primary waves-effect waves-light mb-3"
                                href="{{ route('developer.create') }}">Tambah Data</a> --}}
                            {{-- <a class="btn btn-primary waves-effect waves-light mb-3" href="">Cetak Data</a> --}}
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="customer-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Telepon</th>
                                        <th>Email</th>
                                        <th>Point</th>
                                        <th width="200">Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card body-->
    </div>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(function() {
            $('#customer-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('admin.customer.list') !!}",
                columns: [{
                        data: 'rownum',
                        name: 'rownum'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'points',
                        name: 'points'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#customer-table').on('click', '.btn-delete[data-remote]', function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var url = $(this).data('remote');
                console.log(url);
                // confirm then
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        method: '_DELETE',
                        submit: true
                    }
                }).always(function(data) {
                    $('#customer-table').DataTable().draw(false);
                });
            })
        });
    </script>
@endsection
