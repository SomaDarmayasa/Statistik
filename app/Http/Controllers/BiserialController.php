<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biserial;
use App\Exports\BiserialExport;
use App\Imports\BiserialImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class BiserialController extends Controller
{
    public function korelasiBiserial()
    {
        $biserial = Biserial::all();

        //mean x1
        $X1 = DB::table('table_biserial')
        ->where('keaktifan', 'aktif')
        ->avg('kecerdasan');

        //mean x2
        $X2 = DB::table('table_biserial')
        ->where('keaktifan', 'non aktif')
        ->avg('kecerdasan');

        // mean total
        $Xt = DB::table('table_biserial')->avg('kecerdasan');


        $n =DB::table('table_biserial')
        ->where('keaktifan', 'aktif')
        ->count('kecerdasan');

        $N = DB::table('table_biserial')->count('kecerdasan');
        // cari p
        $p = $n/$N;
        //cari q
        $q = 1 - $p;

       // mencari SDt
        $sigma = 0;
        for ($i=0; $i < $N; $i++){
            $XminXt[$i] = $biserial[$i]->kecerdasan - $Xt;
            $XminXtkuadrat[$i] = $XminXt[$i] * $XminXt[$i];
            $sigma += $XminXtkuadrat[$i];
        }
        $sdt = $sigma / ($N - 1);

        // korelasi point biserial rumus 1 dipake
        $PkaliX = ($p*$q);
        $pengali = sqrt($PkaliX);
        $rbis = (($X1 - $X2)/$sdt)*$pengali;
        return view('biserial.korelasibiserial', [
            'biserial' => $biserial,
            'XminXt' => $XminXt,
            'XminXtKuadrat' => $XminXtkuadrat,
            'N'=> $N,
            'sigma'=>$sigma,
            'X1' => $X1,
            'X2' => $X2,
            'xt'=> $Xt,
            'sdt' => $sdt,
            'rbis'=>$rbis,
            'p' => $p,
            'q' => $q
                                    ]);
    }

    public function exportbiserial(){

        return Excel::download(new BiserialExport, time().'_'.'pointbiserial.xlsx');
    }

    public function importbiserial(Request $request){

        $this->validate($request,
        [
            'file'      =>  'required|file|mimes:xlsx,csv'
        ],
        [
            'file'      =>  'File Harus Berekstensi .xlsx atau .csv',
        ]);

        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move('Biserial', $namaFile);

        Excel::import(new BiserialImport, public_path('/Biserial/'.$namaFile));

        return redirect('/korelasiBiserial')->with('status', 'Data Korelasi Biserial Berhasil Diimport!');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('biserial.createbiserial');
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
            'kecerdasan'=>'required',
            'keaktifan'=>'required',
        ]);


            Biserial::create($request->all());

        return redirect('/korelasiBiserial')->with('status','Data Nilai Berhasil Ditambahkan !');
    }
    public function deleteBiserial($id)
    {
        $biserial = Biserial::find($id);         //cari id yang dipencet
        $biserial->delete();                  //delete id tersebut


        return redirect('/korelasiBiserial')->with('status', 'Data Berhasil Dihapus');                //redirect lagi ke home
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
