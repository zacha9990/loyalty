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
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card" onclick="openTransactionLink()" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Transaksi</p>
                                <h4 class="mb-2">{{ $history['total_data'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-shopping-cart-2-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card" onclick="openTransactionLink()" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Transaksi Minggu Ini</p>
                                <h4 class="mb-2">{{ $history['total_data_this_week'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="mdi mdi-currency-usd font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openTransactionLink() {
        // Replace 'your-link-url' with the actual URL you want to open
        window.open("{{ route('transactions.index') }}");
    }
</script>
@endsection
