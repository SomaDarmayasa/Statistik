<?php

namespace App\Http\Controllers;


use App\Models\Student;
use App\Models\Nilai;

use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Nilai::all();
        return view('students.index', ['students' => $students]);
    }

    public function studentsexport(){
        return Excel::download(new StudentsExport,'nilai.xlsx');
    }

    public function studentsimportexcel(Request $request){

        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move('Nilai', $namaFile);
        Excel::import(new StudentsImport, public_path('/Nilai/'.$namaFile));
        return redirect('/mahasiswa');


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nilai'=>'required',
        ]);


            Nilai::create($request->all());

        return redirect('/students')->with('status','Data Berhasil Ditambahkan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nilai $student
     * @return \Illuminate\Http\Response
     */
    public function show(Nilai $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nilai  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Nilai $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nilai  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nilai $student)
    {
       // return request();
       $request->validate([

            'nilai'=>'required',
        ]);
        Nilai::where('id',$student->id)
            ->update([

                'nilai' => $request->nilai,
            ]);
            return redirect('/students')->with('status','Data Nilai Berhasil DiEdit !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nilai  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nilai $student)
    {
        Nilai::destroy($student->id);
        return redirect('/students')->with('status','Data Nilai Berhasil Dihapus !');
    }
}
