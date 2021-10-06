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
                            <h5 class="modal-title" id="exampleModalLabel">Import File Uji T Berkolerasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/importujiT" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                <input type="file" name="file" required>
                                <p class="mt-1"> <i>File yang disarankan: .xlxs dan .csv</i> </p>
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

            @if (session('status'))
            <p></p>
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
            <h1 class="mt-8">Uji T Berkorelasi</h1>
            <a href="/exportujiT" class="btn btn-success mt-2 mb-2 mr-1">
                Export
            </a>
            <a href="#" class="btn btn-success mt-2 mb-2 mr-1" data-toggle="modal" data-target="#ujitberkolerasi">
                Import
            </a>
            <a href="/createujiT" class="btn btn-primary mt-2 mb-2">
                Tambah Nilai x1 dan x2
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead class="thead-light">
                        <tr >
                            <th class="px-1">No</th>
                            <th>X1</th>
                            <th>X2</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ujiT as $t)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->x1 }}</td>
                            <td>{{ $t->x2 }}</td>
                            <td>
                                <form name="delete" action="/hapus/{{ $t->id }}" method="POST">     {{-- setelah klik hapus, form akan mengarah ke route delete--}}
                                    @csrf               {{-- csrf token untuk tombol hapus--}}
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                             </td>
                        </tr>
                        @endforeach



                </table>
                <table class="table table-bordered text-center">
                    <tr>
                        <th class="px-1 py-2"></th>
                        <th>X1</th>
                        <th>X2</th>
                    </tr>
                    <tr>

                        <th class="px-1">rata-rata : </th>
                        <td>{{ number_format($rata2x1, 2) }}</td>
                        <td>{{ number_format($rata2x2, 2) }}</td>
                    </tr>
                    <tr>

                        <th>standar deviasi :</th>
                        <td>{{ $sdX1 }}</td>
                        <td>{{ $sdX2 }}</td>
                    </tr>
                    <tr>

                        <th>varians :</th>
                        <td>{{ number_format($variansX1, 2) }}</td>
                        <td>{{ number_format($variansX2, 2) }}</td>
                    </tr>

                    <tr class="text-center">
                        <th>T Hitung: </th>
                        <th> {{ $nilaiUjiT }}</th>
                    </tr>
                    <tr class="text-center">
                        <th>T Tabel: </th>
                        <th> {{ $TTabel }}</th>
                    </tr>
                    <tr class="text-center">
                        <th>Status H0: </th>
                        <th> {{ $status }}</th>
                    </tr>
                </table>
            </tbody>
            <table class="table text-right">
                <tr>
                    <td> <b> Nilai Uji T : </b> &nbsp {{ $nilaiUjiT }} </td>
                </tr>
            </table>
            </div>
        </div>

    </div>
</div>
@endsection
