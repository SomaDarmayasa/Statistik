@extends('layout.template')

@section('title','')

@section('container')

<div class="row justify-content-center">
    <div class="col-12">
        <div class="d-flex justify-content">
            <!-- Modal -->
            <div class="modal fade" id="korelasiModal" tabindex="-1" role="dialog" aria-labelledby="korelasiModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import File Korelasi Moment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/importmoment" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                <input type="file" name="file" required>
                                <p class="mt-1"> <i>File yang mendukung: .xlxs dan .csv</i> </p>
                                </div>

                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                                @csrf

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h1 class="mt-8">Korelasi Moment</h1>
        </div>
        <a href="/exportmoment" class="btn btn-success mt-2 mb-2 mr-1">
            Export
        </a>
        <a href="#" class="btn btn-success mt-2 mb-2" data-toggle="modal" data-target="#korelasiModal">
            Import
        </a>
        <a href="/createmoment" class="btn btn-primary mt-2 mb-2">
            Tambah Data X dan Y
        </a>
        <div>

        </div>

        <div class="card">
            {{-- <div class="card-header border-0">
                <p class="h3">Korelasi Moment</p>
            </div> --}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead class="thead-light">
                        <tr >
                            <th>No</th>
                            <th>X</th>
                            <th>Y</th>
                            <th>x</th>
                            <th>y</th>
                            <th>x^2</th>
                            <th>y^2</th>
                            <th>xy</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $jumlahData; $i++)
                        <tr>


                            <th>{{ $i+1 }}</th>
                            <td>{{ $moments[$i]->x}}</td>
                            <td>{{ $moments[$i]->y}}</td>
                            <td>{{ $xKecil[$i] }}</td>
                            <td>{{ $yKecil[$i] }}</td>
                            <td>{{ $xKuadrat[$i] }}</td>
                            <td>{{ $yKuadrat[$i] }}</td>
                            <td>{{ $xKaliY[$i] }}</td>
                            <td>
                                <form name="delete" action="/hapusmoment/{{ $moments[$i]->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endfor

                        <tr>
                            <th>rata-rata : </th>
                            <th> {{ number_format($rata2X,2) }}</th>
                            <th> {{ number_format($rata2Y,2) }}</th>
                        </tr>
                        <tr>
                            <th> jumlah : </th>
                            <th> {{ $sumX }}</th>
                            <th> {{ $sumY}} </th>
                            <th></th>
                            <th></th>
                            <th> {{ $sumXKuadrat }}</th>
                            <th> {{ $sumYKuadrat }}</th>
                            <th> {{ $sumXY }}</th>
                        </tr>
                    </tbody>
                </table>
                <table class="table text-right">
                    <tr>
                        <td> <b> Nilai korelasi moment : </b> &nbsp {{ $korelasimoment }} </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
