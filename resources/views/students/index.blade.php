@extends('layout.template')

@section('title','')

@section('container')

<div class="container">
    <div class="row">
        <div class="colo-6">
            <h1 class="mt-3">Daftar Data Nilai</h1>

             @if (session('status'))
                <div class="alert alert-success">
                {{ session('status') }}
                </div>
            @endif

            <a href="/students/create" class="btn btn-primary my-3">
                <i class="fas fa-plus mr-1"></i>
                Tambah Data Nilai</a>

            <ul class="list-group">
                @foreach ($students as $students )
                <li class="list-group-item d-flex justify-content-between align-item-center">
                    {{ $students ->nilai }}

                <a href="/students/{{$students->id}}" class="badge badge-info">
                    <i class="fas fa-info-circle mr-0"></i>
                    ubah</a>
            </li>
            @endforeach
        </ul>
        </div>
    </div>
</div>
@endsection


