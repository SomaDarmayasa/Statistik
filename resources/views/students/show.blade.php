@extends('layout.template')

@section('title','')

@section('container')

<div class="container">
    <div class="row">
        <div class="colo-7">
            <h1 class="mt-3">Ubah Nilai Mahasiswa</h1>

            <div class="card">
                <div class="card-body">

                    <h6 class="card-text">Nilai : {{$student->nilai}}</h6>


                    <a href="{{ $student->id }}/edit" class="btn btn-success">
                        <i class="fas fa-wrench mr-1"></i>
                        Edit</a>
                    <form action="/students/{{ $student->id }}" method="post" class="d-inline" >
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt mr-1"></i>
                            Delete
                        </button>
                    </form>

                    <a href="/students" class="btn btn-primary">

                        <i class="fas fa-undo-alt mr-1"></i>
                        kembali
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


