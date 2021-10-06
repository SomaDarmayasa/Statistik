<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

//use App\Models\Student;
use App\Models\Nilai;
use App\Models\ZTable;
use App\Models\Mahasiswa; //kelas model di app

class MahasiswaController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {

        //$mahasiswa = DB::table('students')->get(); //menggunakan query builder untuk memanggil database
        $mahasiswa = Nilai::all(); //menggunakan kelas model untuk memanggil database table
        $maxNilai = Nilai::max('nilai');
        $minNilai = Nilai::min('nilai');
        $rata2 = number_format(Nilai::average('nilai'),3);


        //untuk tabel frekuensi
        $frekuensi = Nilai::select('nilai', DB::raw('count(*) as frekuensi'))  //ambil skor, hitung banyak skor taruh di tabel frekuensi
                                 ->groupBy('nilai')                              //urutkan sesuai skor
                                 ->get();
        $totalnilai = Nilai::sum('nilai');
        $totalfrekuensi = Nilai::count('nilai');        //karena total frekuensi = banyaknya skor yang ada

        return view('mahasiswa.index',['mahasiswa' => $mahasiswa,
                        'max' => $maxNilai,
                        'min' => $minNilai,
                        'rata2' => $rata2,
                        'frekuensi' => $frekuensi,
                        'totalnilai' => $totalnilai,
                        'totalfrekuensi' => $totalfrekuensi]);

    }


    public function databergolong()
    {


      $valMax = Nilai::max('nilai');
      $valMin = Nilai::min('nilai');

      $range = $valMax - $valMin;

      $dataNilai = Nilai::count('nilai');

      $class = ceil(3.3 * log10($dataNilai) + 1);

      $interval = ceil($range/$class);

      $limitBawah = $valMin;

      $limitAtas = 0;

      for($i = 0; $i < $class; $i++)
      {
          $limitAtas = $limitBawah + $interval - 1;
          $frek[$i] = Nilai::select('nilai as value', DB::raw('count(*) as frek'))
          ->where([['nilai','>=',$limitBawah],['nilai','<=',$limitAtas]])
          ->groupBy('nilai')
          ->count('nilai');

          $nilai[$i] = $limitBawah.'-'.$limitAtas;
          $limitBawah = $limitAtas + 1;

      }
      return view('mahasiswa.group',
      [
        'class' => $class,
        'nilai' => $nilai,
        'frek' => $frek

      ]);

    }

    public function chikuadrat(){
        $maxNilai = Nilai::max('nilai');
        $minNilai = Nilai::min('nilai');
         //$n = f0 = banyak nilai/total frekuensi
        $n = Nilai::count('nilai');
        $rata2 = number_format(Nilai::average('nilai'),2);

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

        //fungsi desimal
        function desimal($nilai){
            if($nilai<0){
                $des = substr($nilai,0,4);
            } else {
                $des = substr($nilai,0,3);
            }
            return $des;
        }

         //fungsi label
         function label($nilai){
            if($nilai<0){
                $str1 = substr($nilai,4,1);
            } else {
                $str1 = substr($nilai,3,1);
            }

            switch($str1){
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
                case '6':
                    $sLabel = 'enam';
                    break;
                case '7':
                    $sLabel = 'tujuh';
                    break;
                case '8':
                    $sLabel = 'delapan';
                    break;
                case '9':
                    $sLabel = 'sembilan';
                    break;
                default: $sLabel = 'Tidak ada field';
            }

            return $sLabel;
        }
         //ambil nilai skor
         $nilai = Nilai::select('nilai')->get();

         //masukin nilai ke dalam array biar bisa dipakek sama fungsinya

         $i = 0;
        foreach ($nilai as $a){
            $arrayNilai[$i] = $a->nilai;
            $i++;
        }

        //standar deviasi dari seluruh skor
        $SD = number_format(std_deviation($arrayNilai), 2);

        //mencari RANGE/rentangan
        $range = $maxNilai - $minNilai;

         //mencari kelas
         $kelas = ceil(1 + 3.3 * log10 ($n));

         //menghitung interval
        $interval = ceil($range/$kelas);

         //set batas bawah dan batas atas
         $limitBawah = $minNilai;
         $limitAtas = 0;

         //data chi
        $totalchi = 0;
        for($i = 0; $i < $kelas; $i++){
            //untuk menghitung batas bawah
            $limitBawahBaru[$i] = $limitBawah - 0.5;
            $limitAtas = $limitBawah + $interval - 1;

            //untung menghitung batas atas
            $limitAtasBaru[$i] = $limitAtas + 0.5;

            //untung menghitung atas dan bawah z
            $zBawah[$i] = number_format(($limitBawahBaru[$i]- $rata2)/$SD, 2);
            $zAtas[$i] = number_format(($limitAtasBaru[$i]- $rata2)/$SD, 2);

             //untung menghitung z tabel atas dan bawah
             $cariDesimalBawah = desimal($zBawah[$i]);
             $cariDesimalAtas = desimal($zAtas[$i]);

             $labelDesimalBawah = label($zBawah[$i]);
             $labelDesimalAtas= label($zAtas[$i]);

            $zTabelBawah = ZTable::where('z','=',$cariDesimalBawah)->get();
            $zTabelAtas = ZTable::where('z', '=', $cariDesimalAtas)->get();
            $zTabelBawahFix[$i] = $zTabelBawah[0]->$labelDesimalBawah;
            $zTabelAtasFix[$i] = $zTabelAtas[0]->$labelDesimalAtas;

            //untung menghitung l/proporsi
            $lprop[$i] = abs($zTabelBawahFix[$i] - $zTabelAtasFix[$i]);

            //untuk menghitung fe(L*N)
            $fe[$i] = $lprop[$i]*$n;

             //untuk menghitung f0
             $frekuensi[$i] = Nilai::select(DB::raw('count(*) as frekuensi, nilai'))
                                    ->where([
                                        ['nilai', '>=', $limitBawah],
                                        ['nilai', '<=', $limitAtas],
                                    ])
                                    ->groupBy()
                                    ->count();
            $data[$i] = $limitBawah. " - ". $limitAtas;
            $limitBawah = $limitAtas + 1;

            //untuk menghitung (f0-fe)^2/fe
            $kai[$i] = number_format(pow(($frekuensi[$i] - $fe[$i]),2)/$fe[$i], 7);
            $totalchi += $kai[$i];
        }
         return view('chi-normalisasi',
         [
            'data'=> $data,
            'frekuensi'=> $frekuensi,
            'limitAtas'=> $limitAtas,
            'limitBawah'=> $limitBawah,
            'kelas'=> $kelas,
            'interval'=>$interval,
            'range'=> $range,
            'limitBawahBaru'=> $limitBawahBaru,
            'limitAtasBaru'=> $limitAtasBaru,
            'zBawah'=> $zBawah,
            'zAtas'=> $zAtas,
            'zTabelBawahFix'=>$zTabelBawahFix,
            'zTabelAtasFix'=>$zTabelAtasFix,
            'lprop'=>$lprop,
            'fe'=>$fe,
            'kai'=>$kai,
            'totalchi'=>$totalchi
         ]);




    }

    public function lilliefors(){

        //mengambil banyak nilai
        $n = Nilai::count('nilai');
        $rata2 = number_format(Nilai::average('nilai'),2);

        //function standar deviasi
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

         //function desimal
         function desimal($nilai){
            if($nilai<0){
                $des = substr($nilai,0,4);
            } else {
                $des = substr($nilai,0,3);
            }
            return $des;
        }
        //function label
        function label($nilai){
            if($nilai<0){
                $str1 = substr($nilai,4,1);
            } else {
                $str1 = substr($nilai,3,1);
            }

            switch($str1){
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
                case '6':
                    $sLabel = 'enam';
                    break;
                case '7':
                    $sLabel = 'tujuh';
                    break;
                case '8':
                    $sLabel = 'delapan';
                    break;
                case '9':
                    $sLabel = 'sembilan';
                    break;
                default: $sLabel = 'Tidak ada field';
            }

            return $sLabel;
        }

        //ambil nilai skor
        $nilai = Nilai::select('nilai')->get();

        //masukin skor ke dalam array biar bsa dipakek sama functionnya
        $i = 0;
        foreach ($nilai as $a){
            $arrayNilai[$i] = $a->nilai;
            $i++;
        }

        //standar deviasi dari seluruh skor
        $SD = number_format(std_deviation($arrayNilai), 2);

        //ngambil data dan frekuensinya
        for($i = 0; $i < $n; $i++){
            $frekuensi[$i] = Nilai::select('nilai', DB::raw('count(*) as frekuensi'))  //ambil skor, hitung banyak skor taruh di tabel frekuensi
                                ->groupBy('nilai')    //urutkan sesuai skor
                                ->get();
            //ngambil banyak data setelah diambil frekuensinya
            $banyakData = count($frekuensi[$i]);
        }
         //mencari f(zi) dari tabel z
         $fkum = 0;
         $totalLillie = 0;
         for ($i = 0; $i < $banyakData; $i++){
              //frekuensi komulatif
            $fkum += $frekuensi[0][$i]->frekuensi;
            $fkum2[$i] = $fkum;

            //mencari nilai Zi
            $Zi[$i] = number_format(($frekuensi[0][$i]->nilai - $rata2)/$SD, 2);

            //mencari F(zi)dari tabel z
            $cariDesimalZi = desimal($Zi[$i]);
            $labelZi = label($Zi[$i]);
            $zTabel = ZTable::where('z', '=', $cariDesimalZi)->get();
            $fZi[$i] = $zTabel[0]->$labelZi;

            //mencari S(Zi)
            $sZi[$i] = $fkum2[$i]/$n;

            //mencari |F(Zi)-S(Zi)|
            $lilliefors[$i] = abs($fZi[$i]-$sZi[$i]);

            //total
            $totalLillie += $lilliefors[$i];
         }
         return view('lilliefors', ['frekuensi' => $frekuensi,
                                    'banyakData' => $banyakData,
                                    'fkum2' => $fkum2,
                                    'Zi' => $Zi,
                                    'fZi' => $fZi,
                                    'sZi' => $sZi,
                                    'lilliefors' => $lilliefors,
                                    'totalLillie' => $totalLillie,
                                    'n' => $n,
                                 ]);


    }
    // public function ujiTBerkolerasi(){

    //     $t = 30;

    //     return view('/ujiTBerkolerasi', ['ujiT' => $t,

    //                                 ]);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function operations($id)
    {
        return DB::table('students')->avg('id');
    }
}
