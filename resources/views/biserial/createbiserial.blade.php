@extends('layout.template')

@section('title','')

@section('container')

<div class="container">
    <div class="row">
        <div class="colo-6">
            <h1 class="mt-3">Silahkan Masukkan nilai Kecerdasan dan Keaktifan</h1>
            <form method="POST" action="/korelasiBiserial">
                @csrf

                <div class="form-group">
                    <label for="input1">Nilai Kecerdasan</label>
                    <input type="text" class="form-control @error('kecerdasan') is-invalid @enderror" id="kecerdasan" placeholder="Masukkan Nilai Kecerdasan" name="kecerdasan" value="{{old('kecerdasan')}}">
                    @error('kecerdasan')<div class = "invalid-feedback">{{$message}}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="imput2">Nilai Keaktifan</label>
                    <input type="text" class="form-control @error('keaktifan') is-invalid @enderror" id="keaktifan" placeholder="Masukkan Nilai Keaktifan" name="keaktifan" value="{{old('keaktifan')}}">
                    @error('keaktifan')<div class = "invalid-feedback">{{$message}}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Tambah Data !</button>


            </form>


        </div>
    </div>
</div>
@endsection
