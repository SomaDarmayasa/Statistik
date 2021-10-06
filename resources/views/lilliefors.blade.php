@extends('layout.template')

@section('title','')

@section('container')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <h1 class="mt-3">Normalisasi Lilliefors</h1>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Yi</th>
                            <th>Frekuensi</th>
                            <th>fkum</th>
                            <th>Zi</th>
                            <th>F(Zi)</th>
                            <th>S(Zi)</th>
                            <th>|F(Zi)-S(Zi)|</th>

                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $banyakData; $i++)

                        <tr>
                            <th> {{ $i+1 }}</th>
                            <td> {{ $frekuensi[0][$i]->nilai}}</td>
                            <td> {{ $frekuensi[0][$i]->frekuensi}}</td>
                            <td> {{ $fkum2[$i] }}</td>
                            <td> {{ $Zi[$i] }}</td>
                            <td> {{ $fZi[$i] }}</td>
                            <td> {{ $sZi[$i] }}</td>
                            <td> {{ $lilliefors[$i] }}</td>
                        </tr>

                        @endfor
                        <tr class="text-bold">
                            <td>Total:</td>
                            <td></td>
                            <td>{{ $n }}</td>
                            <td>{{ $n }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td> {{ $totalLillie }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
