@extends('layout.template')

@section('title','')

@section('container')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <h1 class="mt-3">Normalisasi ChiKuadrat</h1>
        <div class="card">
            <div class="card-body">
                <table  class="table table-bordered"  width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Data Kelompok</th>
                            <th>fo</th>
                            <th>Batas Kelas Bawah </th>
                            <th>Batas Kelas Atas </th>
                            <th>Batas Bawah Z</th>
                            <th>Batas Atas Z</th>
                            <th>Z Tabel Bawah</th>
                            <th>Z Tabel Atas</th>
                            <th>L/Proporsi</th>
                            <th>fe(LxN)</th>
                            <th>(f0-fe)^2/fe</th>

                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $kelas; $i++)

                        <tr>
                            <th> {{ $i+1 }} </th>
                            <td> {{ $data[$i] }}</td>
                            <td> {{ $frekuensi[$i] }}</td>
                            <td> {{ $limitBawahBaru[$i] }}</td>
                            <td> {{ $limitAtasBaru[$i] }}</td>
                            <td> {{ $zBawah[$i] }}</td>
                            <td> {{ $zAtas[$i] }}</td>
                            <td> {{ $zTabelBawahFix[$i] }}</td>
                            <td> {{ $zTabelAtasFix[$i] }}</td>
                            <td> {{ $lprop[$i] }}</td>
                            <td> {{ $fe[$i] }}</td>
                            <td> {{ $kai[$i] }}</td>
                        </tr>

                        @endfor
                        <tr>
                            <th> Total: </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{ $totalchi }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
