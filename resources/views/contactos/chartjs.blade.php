@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex">
            <div class="w-1/2">
                <h1 class="font-bold">Grafica Genero</h1>
                {!! $grafica1->container() !!}   
            </div>

            <div class="w-1/2">
                <h1 class="font-bold">Grafica Rango edades</h1>
                {!! $grafica2->container() !!}
            </div>          
        </div>
    <a href="{{url("contactos")}}" class="btn btn-primary ">Regresar</a>

        {!! $grafica1->script() !!}
        {!! $grafica2->script() !!}
    </div>


@endsection


