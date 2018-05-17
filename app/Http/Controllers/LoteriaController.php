<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoteriaRequest;
use App\Loteria;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use PhpParser\Node\Scalar\String_;

class LoteriaController extends Controller
{
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

    }

    public function imprimir($numero)
    {
        $profile = CapabilityProfile::load("TM-T88IV");
        $connector = new WindowsPrintConnector("smb://guest:123456@".\Request::ip()."/tg2480-h");//TG2480H "smb://guest:123456@".\Request::ip()."/tg2480-h"##@##smb://guest:123456@10.43.18.100/EPSON1
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
            $printer->text("Nombre del cliente: \n" . \Auth::user()->name ." ".\Auth::user()->last_name. "\n");
            $printer->text("Numero tarjeta: \n" . \Auth::user()->username."\n");
            $printer->feed(1);
            $printer->setTextSize(2, 2);
            $printer->text("CHANCE GANADOR\n");
            $printer->setTextSize(1, 1);
            $printer->text("Acierta y gana\n");
            $printer->feed(1);
            $printer->setTextSize(4, 4);
            $printer->text($numero);
			$printer->feed(1);
			$printer->text("DEMO "."\n");
            $printer->feed(2);
            $printer->setTextSize(1, 1);
            $printer->text("Gracias por redimir su chance\n");
            $printer->text("Este chance es personal\n");
            $printer->text("e intransferible\n");
            $printer->feed(2);
            $printer->barcode($numero, Printer::BARCODE_CODE39);
            $printer->feed(2);
            $printer->cut();
        } catch (Exception $e) {
            dd($e->getMessage());
        } finally {
            $connector->write("\x1b" . "\x69");
            $printer->close();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoteriaRequest $request)
    {
        $loteria = new Loteria;
        $loteria->numero = $request->numero;
        $loteria->tarjeta = $request->user()->username;
        $loteria->equipo = "".gethostname();
        $loteria->save();
        $this->imprimir($request->numero);
        Auth::logout();
    //alert()->success('Loteria fue realizada de forma correcta.','Info')->autoclose(3000);
        return \Redirect::route('login')
            ->with('info', 'Loteria fue realizada de forma correcta');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loteria $loteria
     * @return \Illuminate\Http\Response
     */
    public function show(Loteria $loteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loteria $loteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Loteria $loteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Loteria $loteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loteria $loteria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loteria $loteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loteria $loteria)
    {
        //
    }
}
