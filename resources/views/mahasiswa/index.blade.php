@extends('layout.template')

@section('title','')

@section('container')

<div class="container">

    <div class="row">
        <div class="colo-10">
            <h1 class="mt-3">Tabel Data Nilai </h1>
            <a href="/exportstudents" class="btn btn-success">
                <i class="fas fa-file-export mr-1"></i>
                   Export Excel
            </a>
            {{-- <a href="/importstudents"class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Import</a> --}}

            {{-- ini dari santrikoding --}}
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#import">
                <i class="fas fa-file-import mr-1"></i>
                 Import Excel
            </button>
            <table class="table table-bordered">
                <tr>
                    <thead class="thead-light">
                        <th scope="col">ID</th>
                        <th scope="col">SKOR/NILAI</th>
                    </thead>

                </tr>
                    </thead>
                <tbody>


                    @foreach ( $mahasiswa as $mhs)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>

                        <td>{{ $mhs->nilai }}</td>

                    <tr>
                    @endforeach


                </tbody>
            </table>
            <label for="max" class="ml-4">Skor Maksimum : <b>{{ $max }}</b></label>
                    <label for="min" class="ml-4">Skor Minimum : <b>{{ $min }}</b></label>
                    <label for="rata2" class="ml-4">Rata-Rata Nilai : <b>{{ $rata2 }}</b></label>

                    <h1>Tabel Frekuensi</h1>
                        <table class="table table-bordered">
                                <tr>
                                    <thead class="thead-light">
                                    <td scope="col">Skor</td>
                                    <td scope="col">Frekuensi</td>
                                    </thead>
                                </tr>

                           <tbody>
                               @foreach ($frekuensi as $nilai)

                               <tr>
                                   <td> {{ $nilai->nilai }} </td>
                                   <td> {{ $nilai->frekuensi }}</td>
                                </tr>

                                @endforeach
                                <tr>
                                    <td> <b>Total Jumlah Skor :</b>  </td>
                                    <td> {{ $totalnilai }}</td>
                                </tr>
                                <tr>
                                    <td> <b>Total Jumlah Frekuensi :</b>  </td>
                                    <td> {{ $totalfrekuensi }}</td>
                                </tr>
                           </tbody>
                        </table>
        </div>
    </div>


<!-- modal santrikoding.com -->
<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ImportData</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="mahasiswa/importstudents" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>PILIH FILE</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

  <!-- Modal yt bamara -->
   {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


            <form action="/importstudents" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="file" name="file" required="required">
                </div>
            </div>
          <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Selesai</button>
              <button type="button" class="btn btn-primary">Import</button>
            </div>

        </div>
    </form>
      </div>

    </div>
  </div> --}}

  {{-- dari medikre.com --}}
  <!-- <div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            ImportExcel
        </div>
        <div class="card-body">
            <form action="/importstudents" method="POST" enctype="multipart/form-data">
                (@+csrf)
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Import User Data</button>
                {{-- <a class="btn btn-warning" href="/importstudents">Export User Data</a>  --}}
            </form>
        </div>
    </div>
</div> -->
</div>
@endsection


