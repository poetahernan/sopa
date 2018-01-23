<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input ;
use Illuminate\Support\Facades\Response;



class SopaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    var $cadena_buscar;
    var $sopa_array;
    var $sopa_rows;
    var $sopa_columns;
    var $contador;



    public function __construct() {

        $this->middleware('auth');
        $this->sopa_array=array();
        $this->cadena_buscar="OIE";
        $this->sopa_rows=0;
        $this->sopa_columns=0;
        $this->contador=0;

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('home');

    }

    public function GenerarTablaSopa()
    {

        $this->sopa_array=array();

        $table=Input::get('tabla');

        foreach ($table  as $fila)
        {
            $this->sopa_array[$fila['row']][$fila['column']]=$fila['value'];
        }



        $this->cadena_buscar=Input::get('palabra');
        $this->sopa_rows=Input::get('rows');
        $this->sopa_columns=Input::get('columns');




        $va=$this->Mostrar();


        return Response::json(array(
                 'success' => true,
                 'palabras' => $va,
             ));


    }
    public function GenerarSopa() {



        $inputData = Input::get('formDatos');

        parse_str($inputData, $formFields);

        $formulario_datos = array(
            'txt_filas' => $formFields['txt_filas'],
            'txt_columnas' => $formFields['txt_columnas'],
        );
        $rules = array(
            'txt_filas' => 'required|numeric|min:1|max:100',
            'txt_columnas' => 'required|numeric|min:1|max:100'
        );
        $validator = Validator::make($formulario_datos, $rules);

        if ($validator->fails())
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ));

        else {


            $txt_filas = $formFields['txt_filas'];
            $txt_columnas = $formFields['txt_columnas'];

            $tabla = "";

            for ($i = 0; $i < $txt_filas; $i++) {

                $tabla .= "<tr>";

                for ($j = 0; $j < $txt_columnas; $j++) {

                    $tabla .= "<td> <input class=\"form-control\" id=".$i.$j." name=".$i.$j." type=\"text\" maxlength=\"1\"> </td>";

                }
                $tabla .= "</tr>";

            }


            $this->sopa_rows=$txt_filas;

            $this->sopa_columns=$txt_columnas;


            return Response::json(array(
                'success' => true,
                'sopa' => $tabla,
            ));

        }
    }


    public function Mostrar()
    {

        $this->contador=0;

        for($row=0;$row<$this->sopa_rows;$row++)
        {
            for($column=0;$column<$this->sopa_columns;$column++)
            {

                if($this->sopa_array[$row][$column]==$this->cadena_buscar[0])
                {

                    $this->BuscarPalabra($row,$column);


                }

            }

        }

        return $this->contador;

    }

    public function BuscarPalabra($row,$column)
    {

        $hori_derecha=1;
        $hori_abajo=1;
        $hori_izquierda=1;
        $hori_arriba=1;



        $diagonal_1=1;
        $diagonal_2=1;
        $diagonal_3=1;
        $diagonal_4=1;




        for($direction=0;$direction<strlen($this->cadena_buscar);$direction++)
        {

            if($hori_derecha!=0 )
            {
                if(($column + $direction)<$this->sopa_columns)
                {
                    if ($this->sopa_array[$row][$column + $direction] == $this->cadena_buscar[$direction]) {
                        $hori_derecha = 1;
                    } else {
                        $hori_derecha = 0;
                    }
                }
                else
                {
                    $hori_derecha = 0;
                }
            }

            if($hori_abajo!=0) {

               if(($row + $direction)<$this->sopa_rows) {

                    if ($this->sopa_array[$row + $direction][$column] == $this->cadena_buscar[$direction]) {
                        $hori_abajo = 1;
                    } else {
                        $hori_abajo = 0;

                    }
                }
                else
                {
                    $hori_abajo = 0;
                }

            }

            if($hori_izquierda!=0)
            {
                if(($column - $direction)>=0) {


                    if ($this->sopa_array[$row][$column - $direction] == $this->cadena_buscar[$direction]) {
                        $hori_izquierda = 1;
                    } else {
                        $hori_izquierda = 0;
                    }
                }
                else
                {
                    $hori_izquierda = 0;
                }
            }

            if($hori_arriba!=0) {

                if(($row - $direction)>=0) {

                    if ($this->sopa_array[$row- $direction][$column] == $this->cadena_buscar[$direction]) {
                        $hori_arriba = 1;
                    } else {
                        $hori_arriba = 0;
                    }
                }
                else
                {
                    $hori_arriba = 0;
                }
            }


            if($diagonal_1!=0) {


                if(($column+$direction)<$this->sopa_columns && ($row - $direction)>=0) {


                    if ($this->sopa_array[$row-$direction][$column+$direction] == $this->cadena_buscar[$direction]) {
                        $diagonal_1 = 1;
                    } else {
                        $diagonal_1 = 0;
                    }
                }
                else
                {
                    $diagonal_1 = 0;
                }
            }

            if($diagonal_2!=0) {


                if(($column - $direction)>=0 && ($row - $direction)>=0) {


                    if ($this->sopa_array[$row-$direction][$column-$direction] == $this->cadena_buscar[$direction]) {
                        $diagonal_2 = 1;
                    } else {
                        $diagonal_2 = 0;
                    }
                }
                else
                {
                    $diagonal_2 = 0;
                }
            }


            if($diagonal_3!=0) {


                if(($row+$direction)<$this->sopa_rows && ($column - $direction)>=0) {


                    if ($this->sopa_array[$row+$direction][$column-$direction] == $this->cadena_buscar[$direction]) {
                        $diagonal_3 = 1;
                    } else {
                        $diagonal_3 = 0;
                    }
                }
                else
                {
                    $diagonal_3 = 0;
                }
            }


            if($diagonal_4!=0) {


                if(($row+$direction)<$this->sopa_rows && ($column+$direction)<$this->sopa_columns)
                {


                    if ($this->sopa_array[$row+$direction][$column+$direction] == $this->cadena_buscar[$direction]) {
                        $diagonal_4 = 1;
                    } else {
                        $diagonal_4 = 0;
                    }
                }
                else
                {
                    $diagonal_4 = 0;
                }
            }




        }


        $this->contador+=$hori_derecha;
        $this->contador+=$hori_abajo;
        $this->contador+=$hori_izquierda;
        $this->contador+=$hori_arriba;
        $this->contador+=$diagonal_1;
        $this->contador+=$diagonal_2;
        $this->contador+=$diagonal_3;
        $this->contador+=$diagonal_4;


    }






}
