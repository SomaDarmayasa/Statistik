@extends('layout.template')

@section('title','')

@section('container')

<div class="container">
    <div class="row">
        <div class="colo-6">
            <h1 class="mt-3">Data Bergolong</h1>
            <div class="table-responsive">
                @if(count($nilai) > 0)

                <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead>
                        <tr class="thead-light">
                            <th>No</th>
                            <th>Rentangan</th>
                            <th>Frekuensi</th>
                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>no</th>
                            <th>Rentangan</th>
                            <th>Frekuensi</th>
                        </tr>
                    </tfoot> --}}

                    <tbody>
                        @for($i = 0; $i < $class; $i++) <tr>
                            <td>{{$i + 1}}</td>
                            <td>{{$nilai[$i]}}</td>
                            <td>{{$frek[$i]}}</td>
                            </tr>

                            @endfor
                    </tbody>
                </table>
            </div>

            @else
            <p>data not found </p>
            @endif
        </div>

        </div>
    </div>
</div>
@endsection
