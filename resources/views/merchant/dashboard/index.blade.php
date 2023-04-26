@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 my-2">
                        <div class="float-start">
                            <h2>Merchant Dashboard</h2>
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
                        {!! QrCode::size(300)->generate('123') !!}
                    </div>
                </div>
            </div>
        </div> <!-- end card body-->
    </div>
@endsection

@section('scripts')

@endsection
