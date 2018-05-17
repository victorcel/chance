<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\User;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;



Route::get('/', 'Auth\LoginController@showLoginForm')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('index')->middleware('chance');
Route::get('consulta', function () {
    $now = new \DateTime();
    dd(gethostbyaddr(\Request::ip()));
    //DB::select(' ALTER TABLE users DROP INDEX email');
    $consultas = DB::connection('sqlsrv')->select("select '%2862'+CAST( tPlayerCard .Acct  AS VARCHAR(10))+'?' as PlayerId,tPlayerIdentType .PlayerIdentity , tPlayerCard .Acct ,tPlayer.FirstName ,tPlayer.LastName
                    from tPlayer ,tPlayerCard ,tPlayerIdentType
                    where tPlayer .PlayerId = tPlayerCard .PlayerId and
                    tPlayer .PlayerId = tPlayerIdentType .PlayerId and tPlayerCard .Acct >= 100013867 and tPlayer.FirstName not like '/' and YEAR(tPlayer.CreatedDtm)=" . $now->format('Y') . ' and month(tPlayer.CreatedDtm)=' . $now->format('m') . "
                    --and tPlayerCard .Acct = '100092730'");
    $cont = 0;
    foreach ($consultas as $consulta) {
        $cont = $cont + 1;
        $user = new User;
        $user->email = $consulta->PlayerId;
        $user->name = $consulta->FirstName;
        $user->last_name = $consulta->LastName;
        $user->password = bcrypt($consulta->PlayerIdentity);
        $user->username = $consulta->Acct;
        $user->save();
    }

//mario novoa 13:00
//    $user = new User;
//    $user->email = 4321;
//    $user->name = "Prueba";
//    $user->last_name = "Sun Dreams";
//    $user->password = bcrypt(4321);
//    $user->username = 4321;
//    $user->save();
    DB::select('ALTER IGNORE TABLE users ADD UNIQUE INDEX(email,username)');
    return redirect()->route('login')->with('info', 'El dia de hoy se actualizaron ' . $cont . ' usuarios');
});
Route::resource('chance', 'LoteriaController');

Route::get('/print', function () {
    $profile = CapabilityProfile::load("TM-T88IV");
    $connector = new WindowsPrintConnector("smb://guest:123456@10.43.18.100/EPSON1");//TG2480H "smb://guest:123456@".\Request::ip()."/tg2480-h"##@##smb://guest:123456@10.43.18.100/EPSON1
    //   $connector = new WindowsPrintConnector("TG2480H");//TG2480H "smb://guest:123456@".\Request::ip()."/tg2480-h"
    //dd($connector);
    $printer = new Printer($connector, $profile);
    $now = new \DateTime();
    //dd($product->price);
    //  dd($printer);
    try {
        //   $connector->write("\x1b"."Sun Casino Colombia S.A.S\n"."\x44");
        //$printer->selectPrintMode(Printer::MODE_FONT_B);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Sun Casinos Colombia S.A.S\n");
        $printer->text("Fecha Impresion:\n");
        $printer->text($now->format('d-m-Y H:i:s'));
        $printer->feed(2);
        $printer->text("Nombre del cliente: \n" . \Auth::user()->name . "\n");
        $printer->feed(2);
        $printer->setTextSize(4, 4);
        $printer->text("1234");
        $printer->feed(2);
        $printer->setTextSize(1, 1);
        $printer->text("Gracias por redimir su chance\n");
        $printer->text("Este ticket es personal\n");
        $printer->text("e intransferible\n");
        $printer->feed(2);
        //$printer ->text("Puntos Restantes:"."515\n");
        //  $printer->feed(5);
        $printer->barcode("ABC", Printer::BARCODE_CODE39);
        $printer->cut();
        $printer->pulse();
    } catch (Exception $e) {
        dd($e->getMessage());
    } finally {
        $connector->write("\x1b" . "\x69");
        $printer->close();
    }
});