@extends('layouts.app')

@section('content')

<div class="container">

@if(Session::has("mensaje"))
    <div class="alert alert-success" role="alert">
        {{Session::get("mensaje")}}
    </div>
@endif

<h1 class="h1"> Tabla de contactos</h1>

<table class="table table-light table-hover">

    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Celular</th>
            <th>Correo</th>
            <th>Foto</th>
            <th>Comentario</th>
            <th>Edad</th>
            <th>Género</th>
            <th>Act</th>
        </tr>
    </thead>

    <tbody>
    @foreach($contactos as $contacto)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$contacto->nombre}}</td>
            <td>{{$contacto->apellido}}</td>
            <td>{{$contacto->celular}}</td>
            <td>{{$contacto->correo}}</td>
            <td>
                <img src="{{ asset("storage")."/".$contacto->foto}}" class="img-thumbnail" alt="" width="100" height="100">
            </td>
            <td>{{$contacto->comentario}}</td>
            <td>{{$contacto->edad}}</td>
            <td>{{$contacto->genero}}</td>
            <td>
            <a href="{{url("/contactos/".$contacto->id."/edit")}}" class="btn btn-success">
                Editar
            </a>
            <form method="post" action="{{url("/contactos/".$contacto->id)}}" style="display:inline">
                {{csrf_field()}}
                {{method_field("DELETE")}}
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea eliminar?');">Eliminar</button>
            </form>
            </td>
        </tr>
    @endforeach  
    </tbody>
</table>

<a href="{{url("contactos/create")}}" class="btn btn-primary ">Agregar contacto</a>
<a href="{{url("contactos/graficas")}}" class="btn btn-secondary ">Graficos</a>
<a href="{{url("contactos/json")}}" class="btn btn-success ">Json</a>

</div>

@endsection