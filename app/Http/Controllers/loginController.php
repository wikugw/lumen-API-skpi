<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class loginController extends Controller
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

    public function register(Request $request) {
      $ngecek = User::where(['no_induk' => $request->input('no_induk')])->first();
      if ($ngecek['no_induk'] == null) {
        $no_induk = $request->input('no_induk');
        $name = $request->input('name');
        $password = Hash::make($request->input('password'));
        $jabatan = $request->input('jabatan');
        $prodi = $request->input('prodi');
        $fakultas = $request->input('fakultas');

        $register = User::create([
          'no_induk' => $no_induk,
          'name' => $name,
          'password' => $password,
          'prodi' => $prodi,
          'jabatan' => $jabatan,
          'fakultas' => $fakultas
        ]);

        if ($register) {
          return response()->json([
            'succes' => true,
            'message' => 'Succes',
            'data' => $register
          ], 201);
        } else {
          return response()->json([
            'succes' => false,
            'message' => 'Fail',
            'data' => ''
          ], 400);
        }

      } else {
        return response()->json([
          'succes' => true,
          'message' => 'Succes',
          'data' => $ngecek
        ], 201);
      }
    }

    public function auth(Request $request) {
      $no_induk = $request->no_induk;
      $password = $request->password;
      $encryptCode = sha1($password);

      if ($no_induk == null || $password == null) {
        return response()->json(
          [
            'message'=>'masukkan kosong',
            'data'=>(object) []
          ],200);
      }

      $users = User::where('no_induk', $no_induk)->first();
      if ($users == null) {
        return response()->json(
          [
            'message'=>'akun tidak ditemukan',
            'data'=>(object) []
          ],200);
      }
      if (Hash::check($password, $users->password)) {
        return response()->json(
          [
            'message'=>'data user',
            'data'=>[
              'no_induk'=>$users->no_induk,
              'name'=>$users->name,
              'prodi'=>$users->prodi,
              'fakultas'=>$users->fakultas,
              'jabatan'=>$users->jabatan
            ]
          ],200);
      } else {
        return response()->json(
          [
            'success' => false,
            'message'=>'salah',
            'data'=>(object) []
          ],200);
      }
    }
}
