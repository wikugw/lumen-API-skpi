<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Auth;

class prestasiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexMahasiswa($nim) {
      $data_prestasi = \App\m_prestasi::where('no_induk',$nim)->get();
      return response()->json( $data_prestasi,200);
    }

    public function prestasiTambah(Request $request) {
      $data_prestasi = \App\m_prestasi::create($request->all());
      if ($request->hasFile('foto')) {
        $request->file('foto')->move('images/',$request->file('foto')->getClientOriginalName());
        $data_prestasi->foto = $request->file('foto')->getClientOriginalName();
        $data_prestasi->save();
      }
      return response()->json(['status'=>'berhasil'],201);
    }

    public function hapus($id_prestasi) {
      $prestasi = \App\m_prestasi::find($id_prestasi);
      $prestasi->delete();
      return response()->json(['status'=>'berhasil']);
    }

    public function exportpdf($nim) {
      $data_prestasi = \App\m_prestasi::where('no_induk', $nim)
                                      ->where('status','Verifikasi')->get();

      $data_user = \App\User::where('no_induk',$nim)->first();
      return response()->json( ['user'=>$data_user,'data_prestasi'=>$data_prestasi],200);
    }

    public function indexKemahasiswaan() {
      $data_prestasi = \App\m_prestasi::with('User')->where('status','Menunggu')->get();
      return response()->json( $data_prestasi,200);
    }

    public function listUser() {
      $list_user = User::where('jabatan','Mahasiswa')->get();
      return response()->json( $list_user,200);
    }

    public function kegiatanTambah(Request $request) {
      $list_user = User::where('jabatan','Mahasiswa')->get();
      $arrayUser = json_decode($request->list_user, true);
      $jenisPrestasi = $request->jenis;
      $namaPrestasi = $request->nama_prestasi;
      $lokasiKegiatan = $request->lokasi;
      $tahunKegiatan = $request->tahun;
      $tingkatKejuaraan = $request->tingkat;
      $posisi = $request->posisi;
      $uraian = $request->uraian;

      if ($request->hasFile('foto')) {
        $request->file('foto')->move('images/',$request->file('foto')->getClientOriginalName());
      }
        for ($i=0; $i < count((is_countable($arrayUser)?$arrayUser:[])); $i++) {
           \App\m_prestasi::create([
             'jenis'=> $jenisPrestasi,
             'no_induk'=> $arrayUser[$i],
             'foto'=> $request->file('foto')->getClientOriginalName(),
             'nama_prestasi' => $namaPrestasi,
             'lokasi' => $lokasiKegiatan,
             'tahun' => $tahunKegiatan,
             'tingkat' => $tingkatKejuaraan,
             'posisi' => $posisi,
             'uraian'=> $uraian,
             'status' => 'Verifikasi'
           ]);
        }

        return response()->json(['status'=>'berhasil'],201);
    }

    public function tolak($id_prestasi) {
      $prestasi = \App\m_prestasi::find($id_prestasi);
      // $prestasi->status = 'Ditolak';
      // $prestasi->save();
      $prestasi->delete();
      return response()->json(['status'=>'berhasil'],200);
    }

    public function verifikasi($id_prestasi) {
      $prestasi = \App\m_prestasi::find($id_prestasi);
      $prestasi->status = 'Verifikasi';
      $prestasi->save();
      return response()->json(['status'=>'berhasil']);
    }

    public function indexAkademik() {
      $data_prestasi = \App\m_prestasi::with('User')->where('status','Verifikasi')->get();
      return response()->json( $data_prestasi,200);
    }

    public function indexAkademik1() {
      $data_prestasi = \App\m_prestasi::with('User')
                                      ->where('no_induk','165150701111020')
                                      ->where('status','Verifikasi')->get();
      return response()->json( $data_prestasi,200);
    }

    public function exportexcel() {
      $data_prestasi= \App\m_prestasi::with('User')->where('status','Verifikasi')->get();
      return response()->json( $data_prestasi,200);
    }

}
