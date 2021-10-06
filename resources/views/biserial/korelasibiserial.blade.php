@extends('layout.template')

@section('title','')

@section('container')

<div class="row justify-content-center">
    <div class="col-12">
        <div class="d-flex justify-content">

            <!-- Modal -->
            <div class="modal fade" id="biserialModal" tabindex="-1" role="dialog" aria-labelledby="biserialModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import File Korelasi Biserial</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/importbiserial" method="POST" enctype="multipart/form-data">
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
            <h1>Korelasi Biserial</h1>
        </div>
        <div>
            <a href="/exportbiserial" class="btn btn-success mt-2 mb-2 mr-1">
                Export
            </a>
            <a href="#" class="btn btn-success mt-2 mb-2" data-toggle="modal" data-target="#biserialModal">
                Import
            </a>
            <a href="/createbiserial" class="btn btn-primary mt-2 mb-2">
                Tambah Data Kecerdasan dan Keaktifan
            </a>
        </div>
        <div class="card">

            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kecerdasan</th>
                            <th>Keaktifan</th>
                            <th>x - mean</th>
                            <th>x- mean^2</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                       @for ($i = 0; $i < $N; $i++) <tr>

                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $biserial[$i]->kecerdasan}}</td>
                            <td>{{ $biserial[$i]->keaktifan}}</td>
                            <td>{{ $XminXt[$i]}}</td>
                            <td>{{ $XminXtKuadrat[$i]}}</td>
                            <td>
                                <form name="delete" action="/hapusbiserial/{{ $biserial[$i]->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>mean : {{$xt}}</td>
                            <td></td>
                            <td></td>
                            <td>{{$sigma}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row my-4">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0 ">X1 </h6>
                            </div>
                            <div class="col-sm-2 text-secondary">
                                {{$X1}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0">X2</h6>
                            </div>
                            <div class="col-sm-2 text-secondary">
                                {{$X2}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0">SDt</h6>
                            </div>
                            <div class="col-sm-2 text-secondary">
                                {{$sdt}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0">p</h6>
                            </div>
                            <div class="col-sm-2 text-secondary">
                                {{$p}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0">q</h6>
                            </div>
                            <div class="col-sm-2 text-secondary">
                                {{$q}}
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <h6 class="mb-0">rbis</h6>
                            </div>
                            <div class="col-sm-2 text-secondary">
                                {{$rbis}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
