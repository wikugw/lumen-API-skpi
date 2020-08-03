<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->post('/register', 'loginController@register');
$router->post('/auth', 'loginController@auth');

$router->get('/mahasiswa/{no_induk}', 'prestasiController@indexMahasiswa');
$router->post('/mahasiswa/prestasitambah', 'prestasiController@prestasiTambah');
$router->delete('/mahasiswa/{id_prestasi}/hapus', 'prestasiController@hapus');
$router->get('/mahasiswa/exportpdf/{no_induk}', 'prestasiController@exportpdf');

$router->get('/kemahasiswaan', 'prestasiController@indexKemahasiswaan');
$router->post('/kemahasiswaan/kegiatantambah', 'prestasiController@kegiatanTambah');
$router->get('/kemahasiswaan/listuser', 'prestasiController@listUser');
$router->delete('/kemahasiswaan/{id_prestasi}/tolak', 'prestasiController@tolak');
$router->put('/kemahasiswaan/{id_prestasi}/verifikasi', 'prestasiController@verifikasi');

$router->get('/akademik', 'prestasiController@indexAkademik');
$router->get('/akademik/exportexcel', 'prestasiController@exportexcel');
