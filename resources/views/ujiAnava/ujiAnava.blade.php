@extends('layout.template')

@section('title','')

@section('container')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="d-flex justify-content">

            <!-- Modal -->
            <div class="modal fade" id="ujitberkolerasi" tabindex="-1" role="dialog" aria-labelledby="ujitberkolerasi" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import File Uji Anava</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/importAnava" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                <input type="file" name="file" required>
                                <p class="mt-1"> <i>File yang disupport: .xlxs dan .csv</i> </p>
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
            <h1>Uji Anava</h1>
        </div>
        @if (session('status'))
        <p></p>
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <div>
            <a href="/exportAnava" class="btn btn-success mt-2 mb-2 mr-1">
                Export
            </a>
            <a href="#" class="btn btn-success mt-2 mb-2" data-toggle="modal" data-target="#ujitberkolerasi">
                Import
            </a>
            <a href="/createujiAnava" class="btn btn-primary mt-2 mb-2">
                Tambah Nilai x1,x2,x3, dan x4
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class=" thead-light text-center">
                        <tr>
                            <th>No</th>
                            <th>X1</th>
                            <th>X1^2</th>
                            <th>X2</th>
                            <th>X2^2</th>
                            <th>X3</th>
                            <th>X3^2</th>
                            <th>X4</th>
                            <th>X4^2</th>
                            <th>Xt</th>
                            <th>Xt^2</th>
                            <th>aksi</th>

                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @for ($i = 0; $i < $jumlahData; $i++) <tr>
                        <tr>
                            <td>{{$i+1 }}</td>
                            <td>{{$ujiAnava[$i]->x1}}</td>
                            <td>{{$x1kuadrat[$i]}}</td>
                            <td>{{$ujiAnava[$i]->x2}}</td>
                            <td>{{$x2kuadrat[$i]}}</td>
                            <td>{{$ujiAnava[$i]->x3}}</td>
                            <td>{{$x3kuadrat[$i]}}</td>
                            <td>{{$ujiAnava[$i]->x4}}</td>
                            <td>{{$x4kuadrat[$i]}}</td>
                            <td>{{$xtotal[$i]}}</td>
                            <td>{{$xtotalkuadrat[$i]}}</td>
                            <td>
                                <form name="delete" action="/deleteanava/{{ $ujiAnava[$i]->id }}" method="POST">     {{-- setelah klik hapus, form akan mengarah ke route delete--}}
                                    @csrf               {{-- csrf token untuk tombol hapus--}}
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endfor
                        <tr>
                            <th></th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <th>sigma :</th>
                            <td>{{$sumX1}}</td>
                            <td>{{$sigmaX1kuadrat}}</td>
                            <td>{{$sumX2}}</td>
                            <td>{{$sigmaX2kuadrat}}</td>
                            <td>{{$sumX3}}</td>
                            <td>{{$sigmaX3kuadrat}}</td>
                            <td>{{$sumX4}}</td>
                            <td>{{$sigmaX4kuadrat}}</td>
                            <td>{{$sumxtotal}}</td>
                            <td>{{$sumxtotalkuadrat}}</td>
                        </tr>

                        <tr>
                            <th>mean :</th>
                            <td>{{$avgX1}}</td>
                            <td></td>
                            <td>{{$avgX2}}</td>
                            <td></td>
                            <td>{{$avgX3}}</td>
                            <td></td>
                            <td>{{$avgX4}}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-5">
            <div class="card-body">
                <div class="card-header border-0">
                    <p class="h3">Tabel Uji Anava</p>
                </div>
                <table id="table" class="table table-striped table-bordered my-4">

                    <thead>
                        <tr>
                            <th>Sumber Variasi</th>
                            <th>JK</th>
                            <th>DK</th>
                            <th>RJK</th>
                            <th>F</th>
                            <th>Ftabel</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Antar :</th>
                            <td>{{ number_format($JKA, 2) }}</td>
                            <td>{{ number_format($DKA, 2) }}</td>
                            <td>{{ number_format($RJKA, 2) }}</td>
                            <td>{{ number_format($F, 2) }}</td>
                            <td> {{ $fTabel}} </td>
                            <td> {{ $status }}</td>
                        </tr>

                        <tr>
                            <th>Dalam :</th>
                            <td>{{ number_format($jkd, 2) }}</td>
                            <td>{{ number_format($dkd, 2) }}</td>
                            <td>{{ number_format($rjkd,2) }}</td>
                            <td> - </td>
                            <td> - </td>
                            <td></td>
                        </tr>

                        <tr>
                            <th></th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <th>Total :</th>
                            <td>{{ number_format($jkt, 2) }}</td>
                            <td>{{ number_format($dkt, 2) }}</td>
                            <td> - </td>
                            <td> - </td>
                            <td> - </td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>

            </div>
    </div>
</div>
@endsection
