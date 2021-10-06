<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UjiAnava;
use App\Models\FTabel;
use App\Exports\UjiAnavaExport;
use App\Imports\UjiAnavaImport;
use Maatwebsite\Excel\Facades\Excel;
class UjiAnavaController extends Controller
{
    public function ujiAnava(){

        $ujiAnava = UjiAnava::all();
        $jumlahData = UjiAnava::count();

        // sum dan avg data normal
        $sumX1 = UjiAnava::sum('x1');
        $avgX1 = UjiAnava::avg('x1');
        $sumX2 = UjiAnava::sum('x2');
        $avgX2 = UjiAnava::avg('x2');
        $sumX3 = UjiAnava::sum('x3');
        $avgX3 = UjiAnava::avg('x3');
        $sumX4 = UjiAnava::sum('x4');
        $avgX4 = UjiAnava::avg('x4');

        //mencari count x per kelompok data
        $nx1 = UjiAnava::count('x1');
        $nx2 = UjiAnava::count('x2');
        $nx3 = UjiAnava::count('x3');
        $nx4 = UjiAnava::count('x4');
        //jumlah semua data
        $N = $nx1+ $nx2+ $nx3 + $nx4;

        //jumlah kelompok data
        $k = 4;

        //selesaikan tabel datanya
        $sigmaX1kuadrat = 0;
        $sigmaX2kuadrat = 0;
        $sigmaX3kuadrat = 0;
        $sigmaX4kuadrat = 0;
        $sigmaXtotal = 0;
        $sigmaXtotalkuadrat = 0;



        for ($i=0; $i < $jumlahData; $i++){
            $X1kuadrat[$i] = $ujiAnava[$i]->x1 *  $ujiAnava[$i]->x1;
            $X2kuadrat[$i] =  $ujiAnava[$i]->x2 *  $ujiAnava[$i]->x2;
            $X3kuadrat[$i] =  $ujiAnava[$i]->x3 *  $ujiAnava[$i]->x3;
            $X4kuadrat[$i] =  $ujiAnava[$i]->x4 *  $ujiAnava[$i]->x4;

            $sigmaX1kuadrat += $X1kuadrat[$i];
            $sigmaX2kuadrat += $X2kuadrat[$i];
            $sigmaX3kuadrat += $X3kuadrat[$i];
            $sigmaX4kuadrat += $X4kuadrat[$i];

            // mencari Xtotal
            $Xtotal[$i] = $ujiAnava[$i]->x1 +  $ujiAnava[$i]->x2 +  $ujiAnava[$i]->x3 + $ujiAnava[$i]->x4;
            $XtotalKuadrat[$i] =  $Xtotal[$i] * $Xtotal[$i];

            $sigmaXtotal += $Xtotal[$i];
            $sigmaXtotalkuadrat += $XtotalKuadrat[$i];
        }


        //mencari JKa (Jumlah Kuadrat Antara) rumus sigma xperkelompok * n x per kelompok
        if($nx1 !== 0 ){
            $a1 =  ($sumX1/$nx1);
        }else {
            $a1 = 0;
        }

        if($nx2 !== 0 ){
            $a2 =  ($sumX2/$nx2);
        }else {
            $a2 = 0;
        }


        if($nx3 !== 0 ){
            $a3 =  ($sumX3/$nx3);
        }else {
            $a3 = 0;
        }

        if($nx4 !== 0 ){
            $a4 =  ($sumX4/$nx4);
        }else {
            $a4 = 0;
        }

        if($N !== 0 ){
            $a5 =  ($sigmaXtotal/$N);
        }else {
            $a5 = 0;
        }


        $JKA =  $a1 + $a2 + $a3 + $a4 -$a5;

     // mencari DKA
        $DKA = $k - 1;

        // mencari RJKA Rerata Jumlah Kuadrat Antara
        if($DKA !== 0 ){
            $RJKA = $JKA/$DKA;
        } else {
            $RJKA = 0;
        }


        // mencari JKt
        $sigmaYkuadrat = $sigmaX1kuadrat + $sigmaX2kuadrat + $sigmaX3kuadrat;

        if ($N !== 0) {
            $JKT = $sigmaYkuadrat - (($sigmaXtotal * $sigmaXtotal)/$N);
        } else {
            $JKT =0;
        }


        //mencari  Jumlah Kuadrat Dalam (JKD)
        $JKD = $JKT - $JKA;

        //mencari DKD
        $DKD = $N - $k;

        // mencari RJKD Rerata Jumlah Kuadrat Dalam
        if($DKD !== 0) {
            $RJKD = $JKD/$DKD;
        } else {
            $RJKD = 0;
        }


        // uji F
        if($RJKD !== 0 ){
            $F = $RJKA/ $RJKD;
        }else{
            $F = 0;
        }


        $DKT = $DKD + $DKA;

        // dd($F);
        //mengecek tabel f, butuh $DKA dan $DKD
        //function cek label
        function label($nilai){

            switch($nilai){
                case '0':
                    $sLabel = 'nol';
                    break;
                case '1':
                    $sLabel = 'satu';
                    break;
                case '2':
                    $sLabel = 'dua';
                    break;
                case '3':
                    $sLabel = 'tiga';
                    break;
                case '4':
                    $sLabel = 'empat';
                    break;
                case '5':
                    $sLabel = 'lima';
                    break;
                default: $sLabel = 'Tidak ada field';
            }

            return $sLabel;
        }

        //1. cek label
        $labelDKA = label($DKA);

        //2. cek di tabel f
        $kolom = Ftabel::where('df1', '=', $DKD)->get();
        $fTabel = $kolom[0]->$labelDKA;

        //cek keterangan
        if ($F > $fTabel){
            $status =  "Signifikan";
        } else {
            $status =   "Tidak Signifikan";
        }
        return view('ujiAnava.ujiAnava', ['ujiAnava' => $ujiAnava,
                             'jumlahData'=>$jumlahData,

                                'x1kuadrat' => $X1kuadrat,
                                'x2kuadrat'=> $X2kuadrat,
                                'x3kuadrat'=>$X3kuadrat,
                                'x4kuadrat'=>$X4kuadrat,
                                'xtotal'=>$Xtotal,
                                'xtotalkuadrat' =>$XtotalKuadrat,

                                'sumX1' =>$sumX1,
                                'sumX2' =>$sumX2,
                                'sumX3' =>$sumX3,
                                'sumX4' =>$sumX4,
                                'avgX1' =>$avgX1,
                                'avgX2' =>$avgX2,
                                'avgX3' =>$avgX3,
                                'avgX4' =>$avgX4,
                                'sumxtotal'=>$sigmaXtotal,
                                'sumxtotalkuadrat'=>$sigmaXtotalkuadrat,

                                'sigmaX1kuadrat' => $sigmaX1kuadrat,
                                'sigmaX2kuadrat' => $sigmaX2kuadrat,
                                'sigmaX3kuadrat' => $sigmaX3kuadrat,
                                'sigmaX4kuadrat' => $sigmaX4kuadrat,

                                // antar
                                'JKA' => $JKA,
                                'DKA'=>$DKA,
                                'RJKA'=>$RJKA,
                                'F'=>$F,

                                //dalam
                                'jkd' => $JKD,
                                'dkd'=> $DKD,
                                'rjkd' => $RJKD,

                                // total
                                'jkt' => $JKT,
                                'dkt' => $DKT,

                                 //ftabel
                                 'fTabel' => $fTabel,

                                 //status
                                 'status' => $status,


        ]);

    }

    public function exportAnava(){

        return Excel::download(new UjiAnavaExport, time().'_'.'DataUjiAnava.xlsx');
    }
    public function importAnava(Request $request){

        $this->validate($request,
        [
            'file'      =>  'required|file|mimes:xlsx,csv'
        ],
        [
            'file'      =>  'File Harus Berekstensi .xlsx atau .csv',
        ]);

        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move('Anava', $namaFile);

        Excel::import(new UjiAnavaImport, public_path('/Anava/'.$namaFile));

        return redirect('/ujiAnava')->with('status', 'Data Uji Anava Berhasil Diimport!');

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
        return view('ujiAnava.createujiAnava');
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
            'x1'=>'required',
            'x2'=>'required',
            'x3'=>'required',
            'x4'=>'required',
        ]);


            UjiAnava::create($request->all());

        return redirect('/ujiAnava')->with('status','Data  Berhasil Ditambahkan !');
    }
    public function deleteAnava($id)
    {
        $ujiAnava = UjiAnava::find($id);         //cari id yang dipencet
        $ujiAnava->delete();                  //delete id tersebut


        return redirect('/ujiAnava')->with('status', 'Data Berhasil Dihapus');                //redirect lagi ke home
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
