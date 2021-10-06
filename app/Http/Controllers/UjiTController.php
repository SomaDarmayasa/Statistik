<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UjiT;
use App\Models\TTabel;
use App\Exports\UjiTExport;
use App\Imports\UjiTImport;
use Maatwebsite\Excel\Facades\Excel;

class UjiTController extends Controller
{
    public function ujiTBerkorelasi(){

        $ujiT = UjiT::all();
        $rata2x1 = UjiT::average('x1');
        $rata2x2 = UjiT::average('x2');
        $n1 = UjiT::count('x1');
        $n2 = UjiT::count('x2');

        $jumlahData = UjiT::count();

        //fungsi standar deviasi
        function std_deviation($my_arr){
            $no_element = count($my_arr);
            $var = 0.0;
            $avg = array_sum($my_arr)/$no_element;
            foreach($my_arr as $i)
                {
                    $var += pow(($i - $avg), 2);
                }
            return (float)sqrt($var/$no_element);
        }

        //ambil nilai x1 dan x2
        $x1 = UjiT::select('x1')->get();
        $x2 = UjiT::select('x2')->get();

        //masukan x1 dan x2 ke dalam array agar bisa dipakai dengan functionnya
        $i = 0;
        foreach ($x1 as $a){
            $arrayX1[$i] = $a->x1;
            $i++;
        }
        $j = 0;
        foreach ($x2 as $b){
            $arrayX2[$j] = $b->x2;
            $j++;
        }

        //standar deviasi dari seluruh x1 dan x2
        $sdX1 = number_format(std_deviation($arrayX1), 2);
        $sdX2 = number_format(std_deviation($arrayX2), 2);

        //varians x1 dan x2
        $variansX1 = pow($sdX1, 2);
        $variansX2 = pow($sdX2, 2);

        //mulai mencari korelasi x1 dan x2
        $sumX1Kuadrat = 0;
        $sumX2Kuadrat = 0;
        $sumX1X2 = 0;
        for ($i=0; $i < $jumlahData; $i++) {

            $x1korelasi[$i] = $ujiT[$i]->x1 - $rata2x1;
            $x2korelasi[$i] = $ujiT[$i]->x2 - $rata2x2;

            $x1Kuadrat[$i] = $x1korelasi[$i] * $x1korelasi[$i];
            $sumX1Kuadrat += $x1Kuadrat[$i];

            $x2Kuadrat[$i] = $x2korelasi[$i] * $x2korelasi[$i];
            $sumX2Kuadrat += $x2Kuadrat[$i];

            $x1Kalix2[$i] = $x1korelasi[$i] * $x2korelasi[$i];
            $sumX1X2 += $x1Kalix2[$i];
        }

       //rumus korelasi
       $korelasimoment = number_format($sumX1X2/sqrt($sumX1Kuadrat*$sumX2Kuadrat), 2);


        //nilaiUjiT
       $nilaiUjiT = number_format($rata2x1 - $rata2x2 / sqrt( ( ($variansX1/$n1)+($variansX2/$n2)) - 2*$korelasimoment*( ($sdX1/sqrt($n1)) * ($sdX2/sqrt($n2)) ) ), 2 );

       //mengecek tabel T, butuh $derajat bebas dan label nilai = 0.05
       $derajatBebas = $jumlahData - 1;
       $labelnilai = "limapersen";

       //1. cek di tabel T
        $kolom = Ttabel::where('df', '=', $derajatBebas)->get();
        $TTabel = $kolom[0]->$labelnilai;

        //cek keterangan
        if ($nilaiUjiT < $TTabel){
            $status =  "Diterima";
        } else {
            $status =   "Tidak Diterima";
        }
        return view('ujiT.ujiT', ['ujiT' => $ujiT,
                                        'rata2x1' => $rata2x1,
                                        'rata2x2' => $rata2x2,
                                        'sdX1' => $sdX1,
                                        'sdX2' => $sdX2,
                                        'variansX1' => $variansX1,
                                        'variansX2' => $variansX2,
                                        'nilaiUjiT' => $nilaiUjiT,
                                        'TTabel' => $TTabel,
                                        'status' => $status,
                                    ]);
    }

    public function ujiTBerkorelasiExport(){

        return Excel::download(new UjiTExport, time().'_'.'HasilUjiT.xlsx');
    }
    public function ujiTBerkorelasiImport(Request $request){

        $this->validate($request,
        [
            'file'      =>  'required|file|mimes:xlsx,csv'
        ],
        [
            'file'      =>  'File Harus Berekstensi .xlsx atau .csv',
        ]);

        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move('UjiT', $namaFile);

        Excel::import(new UjiTImport, public_path('/UjiT/'.$namaFile));

        return redirect('/ujiTBerkorelasi')->with('status', 'Data Uji T Berhasil Diimport!');

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
        return view('ujiT.createujiT');
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
        ]);


            UjiT::create($request->all());

        return redirect('/ujiTBerkorelasi')->with('status','Data Nilai Berhasil Ditambahkan !');
    }

    public function deleteT($id)
    {
        $ujiT = UjiT::find($id);         //cari id yang dipencet
        $ujiT->delete();                  //delete id tersebut


        return redirect('/ujiTBerkorelasi')->with('status', 'Data Berhasil Dihapus');                //redirect lagi ke home
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
    public function destroy()
    {
        //
    }
}
