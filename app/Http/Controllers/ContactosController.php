<?php

namespace App\Http\Controllers;

use App\Contactos;
// Acceso a Chart.php
use App\Charts\Edad;
use Illuminate\Http\Request;
/**tener acceso a la funcionalidad del storage */
use Illuminate\Support\Facades\Storage;

class ContactosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** variable data con la informacion del modelo de contactos*/
        $data["contactos"] = Contactos::all();

        /**se envia los datos para la vista */
        return view('contactos.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contactos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validaciones para los campos
        $reglas = [
            "Nombre" => "required|string",
            "Celular" => "required|string",
            "Correo" => "required|email",
            "Foto" => "required|max:10000|mimes:jpeg,png,jpg",
            "Edad" => "required|integer|min:1|max:100",
        ];

        $msj=["required"=>"El campo :attribute es requerido"];
        
        /*validacion de laravel por los campos*/
        $this->validate($request,$reglas,$msj);

        /**almacenar toda la data del request todo menos el token para que coinsida con la tabla*/
        $data = request()->except("_token");

        /**remplazar los nulos a "" */
        foreach ($data as $key => $value) {
            if (is_null($value)) {
                 $data[$key] = "";
            }
        }

        /**Modificar la foco para que se pueda guardar en la base de datos */
        if($request->hasFile("Foto")){
            $data["Foto"] = $request->file("Foto")->store("uploads","public");
        }
        /* las fotogracias se guardan en /storage/app/public/uploads */

        //return response()->json($data);
        Contactos::insert($data);
        
        /*enviar mensaje a la vista */
        return redirect("contactos")->with("mensaje", "Contacto agregado");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function show(Contactos $contactos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //devolver la info que corresponde al id
        $contacto = Contactos::findOrFail($id);

        return view("contactos.edit", compact("contacto"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //validaciones para los campos
        $reglas = [
            "Nombre" => "required|string",
            "Celular" => "required|string",
            "Correo" => "required|email",
            "Edad" => "required|integer|min:1|max:100",
        ];


        if($request->hasFile("Foto")){
            $reglas+=["Foto" => "required|max:10000|mimes:jpeg,png,jpg"];
        }

        $msj=["required"=>"El campo :attribute es requerido"];
        
        /*validacion de laravel por los campos*/
        $this->validate($request,$reglas,$msj);




        /**almacenar toda la data del request todo menos el token y el method para cambiar a patch 
         * en el form
        */
        $data = request()->except(["_token", "_method"]);

        foreach ($data as $key => $value) {
            if (is_null($value)) {
                 $data[$key] = "";
            }
        }

        //return response()->json($data);



        /**Modificar la foco para que se pueda guardar en la base de datos */
        if($request->hasFile("Foto")){

            /*buscar el contacto para eliminar la imagen anterior de storage */
            $contacto = Contactos::findORFail($id);

            /*Eliminar foto*/
            Storage::delete("public/".$contacto->foto);
            $data["Foto"] = $request->file("Foto")->store("uploads","public");
        }

        /**update con clausula where */
        Contactos::where("id", "=",$id)->update($data);



        return redirect("contactos")->with("mensaje", "Contacto actualizado");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        /*si se borra la fotografia del storage, se elimina el contacto de la base de datos */
        $contacto = Contactos::findORFail($id);
        if(Storage::delete("public/".$contacto->foto)){
            /**elminar contacto por id */
            Contactos::destroy($id);
        }

     
        /* redireccionar solo por url*/
        return redirect("contactos");
    }

    public function graficas()
    {
        $edades = Contactos::pluck("edad");
        $generos = Contactos::pluck("genero");

        $masculino = 0;
        $femenino = 0;

        foreach ($generos as $genero ) {
            if($genero == "Masculino"){
                $masculino++;
            }else{
                $femenino++;
            }
        }

        $rango = [
            "16a20" => 0,
            "21a25" => 0,
            "26a30" => 0,
            "31a35" => 0,
            "m35" => 0
        ];
        foreach ($edades as $edad) {
            if($edad > 16 && $edad<20){
                $rango["16a20"]++;
            }elseif ($edad > 21 && $edad<25 ) {
                $rango["21a25"]++;
                
            }elseif ($edad > 26 && $edad<30) {
                $rango["26a30"]++;

            }elseif ($edad > 31 && $edad<35) {
                $rango["31a35"]++;
            }elseif ($edad > 35) {
                $rango["m35"]++;
            }
        }


    
    
        $grafica1 = new Edad;
        $grafica1->labels(["Masculino", "Femenino"]);
        $grafica1->dataset("Personas por genero", "doughnut", [$masculino, $femenino])->backgroundColor("red,green");

        $grafica2 = new Edad;
        $grafica2->labels([
            "De 16 a 20 años",
            "De 21 a 25 años",
            "De 26 a30 años",
            "De 31 a 35 años",
            "Mayor de 35 años"
            ]);
        $grafica2->dataset("Rango de edades", "bar", [$rango["16a20"],$rango["21a25"],$rango["26a30"],$rango["31a35"],$rango["m35"] ])
        ->backgroundColor("red,green");
    			
        return view("contactos.chartjs", compact("grafica1", "grafica2"));


    }

    public function json(){

        $data["contactos"] = Contactos::all();
        return response()->json($data);
        
    }
}
