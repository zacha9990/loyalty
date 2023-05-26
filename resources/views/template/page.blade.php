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

                    </div>
                </div>
            </div>
        </div> <!-- end card body-->
    </div>
@endsection

@section('scripts')

@endsection
