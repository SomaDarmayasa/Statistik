@extends('layout.template')

@section('title','')

@section('container')

<div class="container">
    <div class="row">
        <div class="colo-6">
            <h1 class="mt-3">Form Ubah Nilai Mahasiswa</h1>
            <form method="POST" action="/students/{{ $student->id }}">
                @method('PATCH')
                @csrf


                <div class="form-group">
                    <label for="Nilai">Nilai</label>
                    <input type="text" class="form-control @error('nilai') is-invalid @enderror" id="nilai" placeholder="Masukkan Nilai" name="nilai" value="{{$student->nilai}}">
                    @error('nilai')<div class = "invalid-feedback">{{$message}}</div>@enderror
                </div>

                <button type="submit" class="btn btn-success">Edit Data Nilai!</button>


            </form>


        </div>
    </div>
</div>
@endsection


