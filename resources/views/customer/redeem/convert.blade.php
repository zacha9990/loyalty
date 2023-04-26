@extends('layouts.admin')

@section('css-after-bootstrap')
<style>
    div.avatar-sm.tukar-point{
        width: 6rem;
    }
</style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Poin</p>
                                <h4 class="mb-2">{{ $totalPoints }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-shopping-cart-2-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2"></p>
                                <h4 class="mb-2"></h4>
                            </div>
                            <div class="avatar-sm tukar-point">
                                <a href="{{ route('customer.show_convert_form') }}" class="btn btn-primary waves-effect waves-light">Tukar Poin</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <p class="card-title-desc">
                </p>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="coupons-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kupon</th>
                                        <th>Tanggal Penukaran</th>
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
<script>
    $(function() {
        $('#coupons-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('customer.coupons.list') !!}",
            columns: [{
                    data: 'rownum',
                    name: 'rownum'
                },
                {
                    data: 'lottery_coupons',
                    name: 'lottery_coupons'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
            ]
        });
    });
</script>
@endsection
