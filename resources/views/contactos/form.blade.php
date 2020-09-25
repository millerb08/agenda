
@if($view=="create")
    <h1 class='h1'> Agregar contacto</h1>
@else
    <h1 class='h1'> Editar contacto</h1>
@endif

    <div class="form-group">
        <label for="Nombre" class="control-label">{{"Nombre"}}</label>
        <input class="form-control" type="text" name="Nombre" id="Nombre" value="{{isset($contacto->nombre)?$contacto->nombre:old('Nombre')}}">
    </div>
    
    <div class="form-group">
        <label for="Apellido" class="control-label">{{"Apellido"}}</label>
        <input class="form-control" type="text" name="Apellido" id="Apellido" value="{{isset($contacto->apellido)?$contacto->apellido:old('Apellido')}}">
    </div>

    <div class="form-group">
        <label for="Celular" class="control-label">{{"Celular"}}</label>
        <input class="form-control" type="text" name="Celular" id="Celular" value="{{isset($contacto->celular)?$contacto->celular:old('Celular')}}">
    </div>

    <div class="form-group">
        <label class="control-label" for="Correo">{{"Correo"}}</label>
        <input class="form-control" type="email" name="Correo" id="Correo" value="{{isset($contacto->correo)?$contacto->correo:old('Correo')}}">
    </div>

    <div class="form-group">
        <label class="control-label" or="Foto">{{"Foto"}}</label>
        @if (isset($contacto->foto))
            <br/>
                <img class="img-fluid img-thumbnail" src="{{ asset("storage")."/".$contacto->foto}}" alt="" width="200">
            <br/>     
        @endif
        <input class="form-control" type="file" name="Foto" id="Foto" value="{{isset($contacto->foto)?$contacto->foto:old('Foto')}}">
    </div>

    <div class="form-group">
        <label class="control-label" for="Comentario">{{"Comentario"}}</label>
        <textarea class="form-control" name="Comentario" id="Comentario">{{isset($contacto->comentario)?$contacto->comentario:old('Comentario')}}</textarea>
    </div>

    <div class="form-group">
        <label class="control-label" for="Edad">{{"Edad"}}</label>
        <input class="form-control" type="text" name="Edad" id="Edad" value="{{isset($contacto->edad)?$contacto->edad:old('Edad')}}">
    </div>

    <div class="form-group">
        <label class="form-group" for="Genero">{{"Género"}}</label>
        <select class="form-control" name="Genero" id="Genero">
            @if (!isset($contacto->genero))
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            @elseif ($contacto->genero == "Femenino")
                <option value="Masculino">Masculino</option>
                <option value="Femenino" selected>Femenino</option>
            @else
            <option value="Masculino" selected>Masculino</option>
            <option value="Femenino" >Femenino</option>
            @endif
        </select>
    </div>



    <input class="btn btn-primary" type="submit" value="{{$view=="create" ? "Crear" : "Editar"}}">

    <a href="{{url("contactos")}}" class="btn btn-secondary" >Regresar</a>