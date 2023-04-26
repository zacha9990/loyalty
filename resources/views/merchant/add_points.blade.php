@extends('layouts.admin')

@section('css-after-bootstrap')
    <style>
        .container {
          height: 100%;
          display: flex;
          justify-content: center;
          align-items: center;
        }

        .img-fluid {
          max-width: 50px;
        }

        @media (min-width: 768px) {
          .display-1 {
            font-size: 12rem;
          }
        }

        /*#layout-wrapper > div.main-content > div > div:nth-child(1) > div > div > div,
        #vertical-menu-btn > i,
        #page-header-search-dropdown > i {
            display: none;
        }*/
    </style>
@endsection

@section('content')
    <div class="container-fluid">
    @if($customer)
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

                @if(session('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">{{ $cardTitle }}</h4>
                <p class="card-title-desc"></p>

                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 text-center">
                            <i class="fas fa-check" style="font-size: 4em; color: green;"></i>
                            <h1 class="display-1 mt-3">{{ $points }}</h1>
                            <h2 class="h6 mt-2">{{ $customer->name }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">{{ $cardTitle }}</h4>
                <p class="card-title-desc"></p>

                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 text-center">
                            <i class="fas fa-times" style="font-size: 4em; color: red;"></i>
                            <h1 class="display-1 mt-3">Customer tidak ditemukan.</h1>
                            <h6>Hubungi admin!</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')

@endsection
