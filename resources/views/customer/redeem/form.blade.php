@extends('layouts.admin')

@section('css-before-bootstrap')
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/settlement_asset/create.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{ $formTitle }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.process_convert') }}" method="post" id="coupon_form">
                            @csrf
                            <div class="row">
                                <div class="card border border-primary">
                                    <div class="card-body">
                                        <h5 class="mb-4"><i class="mdi mdi-check-all me-3"></i> Kamu Punya <span class="badge rounded-pill bg-success">{{ $totalPoints }}</span> points</h5>
                                        <p class="card-text">Berarti maksimal kamu bisa menukar <span class="badge rounded-pill bg-success">{{ $maxCoupons }}</span> kupon setara <span class="badge rounded-pill bg-success">{{ 50 * $maxCoupons }}</span> poin.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="poin" class="form-label">Poin</label>
                                        <input type="number" min="0" max="{{ $totalPoints }}" class="form-control" id="poin" name="poin"
                                            value="{{ old('poin') }}">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="submit-form">Tukar</button>
                                <a href="{{ route('customer.coupons') }}" class="btn btn-light">Batal</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
