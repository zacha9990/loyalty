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
                        <form action="" method="post" id="dev_form">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Pengembang</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="surat_izin" class="form-label">No Surat Izin</label>
                                        <input type="text" class="form-control" id="surat_izin" name="surat_izin"
                                            value="{{ old('surat_izin') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="penanggung_jawab" class="form-label">Penanggung Jawab</label>
                                        <input type="text" class="form-control" id="penanggung_jawab"
                                            name="penanggung_jawab" value="{{ old('penanggung_jawab') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="date_year" class="form-label">Tahun</label>
                                        <input type="number" class="form-control" id="date_year" name="date_year"
                                            value="{{ old('date_year') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <input id="pac-input" class="controls form-control" type="text"
                                        placeholder="Cari tempat...">
                                    <div id="map"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="longitude" class="form-label">Kordinat Longitude</label>
                                        <input type="number" step="any" name="longitude" class="form-control"
                                            id="longitude" value="{{ old('longitude') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="latitude" class="form-label">Kordinat Latitude</label>
                                        <input type="number" step="any" name="latitude" class="form-control"
                                            id="latitude" value="{{ old('latitude') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea name="address" class="form-control" id="address" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            <hr>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="sa_save">Simpan</button>
                                <a href="{{ route('developer.index') }}" class="btn btn-light">Batal</a>
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
