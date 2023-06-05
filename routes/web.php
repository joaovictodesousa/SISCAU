<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\HistoricoController;
use Illuminate\Support\Facades\Cadastro;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pesquisa');
});

Route::get('/historico', function (){
    return view('historico');
});

Route::get('/pesquisa', function (){
    return view('pesquisa');
});

Route::get('/cadastro', function (){
    return view('cadastro');
});

Route::get('/login', function (){
    return view('login');
});

Route::get('/cadastro', [PesquisaController::class, 'cadastro'])->name('cadastro'); //Comado de rota pesquisa para cadastro, finaliza no Controller. 

Route::get('/pesquisa', [CadastroController::class, 'pesquisa'])->name('pesquisa');

Route::get('/pesquisa', [HistoricoController::class, 'pesquisa'])->name('pesquisa');

Route::post('/cadastro', [CadastroController::class, 'store']);


//   Route::get('/verificar-conexao', function () {
//       try {
//           \DB::connection()->getPdo();
//           if (\DB::connection()->getDatabaseName()) {
//               return "Conexão bem-sucedida. Banco de dados: " . \DB::connection()->getDatabaseName();
//           } else {
//               return "Conexão bem-sucedida, mas o banco de dados não foi encontrado.";
//           }
         
//       } catch (\Exception $e) {
//          return "Falha na conexão: " . $e->getMessage();
//       }
//   });
