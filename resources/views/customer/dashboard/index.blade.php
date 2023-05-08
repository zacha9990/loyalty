@extends('layouts.admin')

@section('css-after-bootstrap')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 my-2">
                        <div class="float-start">
                            <h2>Customer Dashboard</h2>
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
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Kamu Punya Poin sebanyak</p>
                                    <h4 class="mb-2">{{ $totalPoints }}</h4>
                                    @if (is_array($nearestExpiringPoints) && !empty($nearestExpiringPoints))
                                        <p class="text-muted mb-0">
                                            <span class="text-danger fw-bold font-size-12 me-2">
                                                <i class="me-1 align-middle"></i>{{ $nearestExpiringPoints['points'] }}
                                            </span>poin akan expired pada {{ $nearestExpiringPoints['expiring_month'] }}</p>
                                    @else
                                        <p class="text-muted mb-0">Tidak ada poin yang akan expired dalam 6 bulan ke depan</p>
                                    @endif

                                    @if (is_array($nearestExpiringPoints) && !empty($nearestExpiringPoints))
                                    <p class="text-muted mb-0">
                                        <span class="text-danger fw-bold font-size-12 me-2">
                                            <i class="me-1 align-middle"></i>{{ $totalPoints }}</span>
                                        </span>poin akan expired dalam 6 bulan ke depan</p>
                                    </p>
                                    @endif
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-shopping-cart-2-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card body-->

        <div class="card">
            <div class="card-body">
                <a  class="btn btn-outline-primary d-grid"
                    href="#"
                    id="copy-link"
                    data-clipboard-text="{{ route('customer.register', ["ref" => Auth::guard('customer')->user()->id]) }}">
                    Copy Link Referral-mu!
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var clipboard = new ClipboardJS('#copy-link');

        clipboard.on('success', function(e) {
            Swal.fire({
                title: "Sukses",
                text: "Link Referral-mu Berhasil Di-copy",
                icon: "success",
                confirmButtonColor: "#0f9cf3"
            })
        });

        clipboard.on('error', function(e) {
            alert('Failed to copy link to clipboard!');
        });
    </script>
@endsection
