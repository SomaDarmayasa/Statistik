<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moment;
use App\Exports\MomentExport;
use App\Imports\MomentImport;
use Maatwebsite\Excel\Facades\Excel;
class MomentController extends Controller
{


    public function korelasiMoment(){
        $moments = Moment::all();
        $jumlahData = Moment::count();
        $jumlahX = Moment::count('x');
        $jumlahY = Moment::count('y');

        $rata2X = Moment::average('x');
        $rata2Y = Moment::average('y');

        $sumX = Moment::sum('x');
        $sumY = Moment::sum('y');

        $sumXKuadrat = 0;
        $sumYKuadrat = 0;
        $sumXY = 0;
        for ($i=0; $i < $jumlahX; $i++) {

             $xKecil[$i] = $moments[$i]->x - $rata2X;
             $yKecil[$i] = $moments[$i]->y - $rata2Y;
            $xKuadrat[$i] = $xKecil[$i] * $xKecil[$i];
            $sumXKuadrat += $xKuadrat[$i];

            $yKuadrat[$i] = $yKecil[$i] * $yKecil[$i];
            $sumYKuadrat += $yKuadrat[$i];

            $xKaliY[$i] = $xKecil[$i] * $yKecil[$i];
            $sumXY += $xKaliY[$i];
        }

        //rumus
     //    $korelasimoment = $jumlahData*$sumXY - ($sumX)*($sumY)/sqrt(($jumlahData * $sumXKuadrat - pow($sumX, 2)) *($jumlahData*$sumYKuadrat - pow($sumY, 2)));
        $korelasimoment = $sumXY/sqrt($sumXKuadrat*$sumYKuadrat);

        return view('moment.korelasimoment', ['moments' => $moments,
                                         'jumlahData' => $jumlahData,
                                         'xKuadrat' => $xKuadrat,
                                         'yKuadrat' => $yKuadrat,
                                         'xKecil' => $xKecil,
                                         'yKecil' => $yKecil,
                                         'xKaliY' => $xKaliY,
                                         'sumX' => $sumX,
                                         'sumY' => $sumY,
                                         'sumXKuadrat' => $sumXKuadrat,
                                         'sumYKuadrat' => $sumYKuadrat,
                                         'sumXY' => $sumXY,
                                         'korelasimoment' => $korelasimoment,
                                         'rata2X' => $rata2X,
                                         'rata2Y' => $rata2Y,
                                     ]);
     }


    public function exportmoment()
    {
        return Excel::download(new MomentExport, time().'_'.'pointmoment.xlsx');
    }

    public function importmoment(Request $request)
    {
        $this->validate($request,
        [
            'file'      =>  'required|file|mimes:xlsx,csv'
        ],
        [
            'file'      =>  'File Harus Berekstensi .xlsx atau .csv',
        ]);

        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move('Moment', $namaFile);

        Excel::import(new MomentImport, public_path('/Moment/'.$namaFile));

        return redirect('/korelasiMoment')->with('status', 'Data Korelasi Moment Berhasil Diimport!');
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
        return view('moment.createmoment');
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
            'x'=>'required',
            'y'=>'required',


        ]);


            Moment::create($request->all());

        return redirect('/korelasiMoment')->with('status','Data Berhasil Ditambahkan !');
    }

    public function deleteMoment($id)
    {
        $moments = Moment::find($id);         //cari id yang dipencet
        $moments->delete();                  //delete id tersebut


        return redirect('/korelasiMoment')->with('status', 'Data Berhasil Dihapus');                //redirect lagi ke home
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
