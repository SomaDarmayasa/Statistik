@extends('layout.template')

@section('title','')

@section('container')

<div class="container">
    <div class="row">
        <div class="colo-6">
            <h1 class="mt-3">Silahkan Masukkan nilai X dan Y</h1>
            <form method="POST" action="/korelasiMoment">
                @csrf

                <div class="form-group">
                    <label for="input1">Nilai X</label>
                    <input type="text" class="form-control @error('x') is-invalid @enderror" id="x" placeholder="Masukkan Nilai X" name="x" value="{{old('x')}}">
                    @error('x1')<div class = "invalid-feedback">{{$message}}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="imput2">Nilai Y</label>
                    <input type="text" class="form-control @error('y') is-invalid @enderror" id="y" placeholder="Masukkan Nilai Y" name="y" value="{{old('y')}}">
                    @error('y')<div class = "invalid-feedback">{{$message}}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Tambah Data !</button>


            </form>


        </div>
    </div>
</div>
@endsection
