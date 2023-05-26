@extends('layouts.admin')

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
                <h4 class="card-title">{{ $cardTitle }}</h4>
                <p class="card-title-desc">
                </p>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="container mt-5">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1"
                                        role="tab" aria-controls="tab1" aria-selected="true">Minggu Ini</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab"
                                        aria-controls="tab2" aria-selected="false">Sepanjang Masa</a>
                                </li>

                            </ul>
                            <div class="tab-content mt-2" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                    aria-labelledby="tab1-tab">
                                    <h2>Weekly Points</h2>
                                    <div class="table-responsive">
                                        <table id="weekly-points-table" class="table table-bordered mb-0  w-100 d-block d-md-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Customer ID</th>
                                                    <th>Points</th>

                                                    <th>Point At</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                    <h2>All Points</h2>
                                    <div class="table-responsive">
                                        <table id="points-table" class="table table-sm table-bordered mb-0 w-100 d-block d-md-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Customer</th>
                                                    <th>Points</th>

                                                    <th>Point At</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card body-->
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#points-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('transactions.alltime') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'customer', name: 'customer' },
                { data: 'points', name: 'points' },
                { data: 'point_at', name: 'point_at'},
            ]
        });

        $('#weekly-points-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('transactions.weekly') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'customer', name: 'customer' },
                { data: 'points', name: 'points' },
                { data: 'point_at', name: 'point_at'},
            ]
        });
    });
</script>
@endsection
