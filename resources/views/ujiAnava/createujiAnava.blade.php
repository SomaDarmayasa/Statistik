@extends('layout.template')

@section('title','')

@section('container')

<div class="container">
    <div class="row">
        <div class="colo-6">
            <h1 class="mt-3">Silahkan Masukkan nilai X1 ,X2, X3 dan X4</h1>
            <form method="POST" action="/ujiAnava">
                @csrf

                <div class="form-group">
                    <label for="input1">Nilai X1</label>
                    <input type="text" class="form-control @error('x1') is-invalid @enderror" id="x1" placeholder="Masukkan Nilai x1" name="x1" value="{{old('x1')}}">
                    @error('x1')<div class = "invalid-feedback">{{$message}}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="imput2">Nilai X2</label>
                    <input type="text" class="form-control @error('x2') is-invalid @enderror" id="x2" placeholder="Masukkan Nilai x2" name="x2" value="{{old('x2')}}">
                    @error('x2')<div class = "invalid-feedback">{{$message}}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="input3">Nilai X3</label>
                    <input type="text" class="form-control @error('x3') is-invalid @enderror" id="x3" placeholder="Masukkan Nilai x3" name="x3" value="{{old('x3')}}">
                    @error('x3')<div class = "invalid-feedback">{{$message}}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="input4">Nilai X4</label>
                    <input type="text" class="form-control @error('x4') is-invalid @enderror" id="x4" placeholder="Masukkan Nilai x4" name="x4" value="{{old('x4')}}">
                    @error('x4')<div class = "invalid-feedback">{{$message}}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Tambah Data !</button>


            </form>


        </div>
    </div>
</div>
@endsection
