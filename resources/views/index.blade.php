@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Gestión de Alumnos</h1>

    <!-- Botón para abrir modal de nuevo alumno -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#alumnoModal" onclick="crearAlumno()">
        Agregar Alumno
    </button>

    <!-- Tabla -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre Completo</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Carrera</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->rut }}</td>
                <td>{{ $alumno->nombres }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</td>
                <td>{{ $alumno->correo }}</td>
                <td>{{ $alumno->telefono }}</td>
                <td>{{ $alumno->carrera->nombre }}</td>
                <td>
                    <button class="btn btn-warning btn-sm"
                        data-bs-toggle="modal" data-bs-target="#alumnoModal"
                        onclick="editarAlumno({{ $alumno }})">
                        Editar
                    </button>

                    <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Seguro que deseas eliminar este alumno?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $alumnos->links() }}
</div>

<!-- Modal para Crear/Editar Alumno -->
<div class="modal fade" id="alumnoModal" tabindex="-1" aria-labelledby="alumnoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="alumnoForm" method="POST">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">

        <div class="modal-header">
          <h5 class="modal-title" id="alumnoModalLabel">Agregar Alumno</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
              <div class="col-md-6">
                  <label>RUT</label>
                  <input type="text" name="rut" id="rut" class="form-control" required>
              </div>
              <div class="col-md-6">
                  <label>Nombres</label>
                  <input type="text" name="nombres" id="nombres" class="form-control" required>
              </div>
          </div>
          <div class="row mb-3">
              <div class="col-md-6">
                  <label>Apellido Paterno</label>
                  <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" required>
              </div>
              <div class="col-md-6">
                  <label>Apellido Materno</label>
                  <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" required>
              </div>
          </div>
          <div class="row mb-3">
              <div class="col-md-6">
                  <label>Fecha Nacimiento</label>
                  <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required>
              </div>
              <div class="col-md-6">
                  <label>Correo</label>
                  <input type="email" name="correo" id="correo" class="form-control" required>
              </div>
          </div>
          <div class="row mb-3">
              <div class="col-md-6">
                  <label>Teléfono</label>
                  <input type="text" name="telefono" id="telefono" class="form-control" required>
              </div>
              <div class="col-md-6">
                  <label>Carrera</label>
                  <select name="carrera_id" id="carrera_id" class="form-select" required>
                      <option value="">Seleccione una carrera</option>
                      @foreach($carreras as $carrera)
                          <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                      @endforeach
                  </select>
              </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    function crearAlumno() {
        document.getElementById("alumnoForm").reset();
        document.getElementById("alumnoForm").action = "{{ route('alumnos.store') }}";
        document.getElementById("formMethod").value = "POST";
        document.getElementById("alumnoModalLabel").innerText = "Agregar Alumno";
    }

    function editarAlumno(alumno) {
        document.getElementById("alumnoForm").action = "/alumnos/" + alumno.id;
        document.getElementById("formMethod").value = "PUT";
        document.getElementById("alumnoModalLabel").innerText = "Editar Alumno";

        // Rellenar campos
        document.getElementById("rut").value = alumno.rut;
        document.getElementById("nombres").value = alumno.nombres;
        document.getElementById("apellido_paterno").value = alumno.apellido_paterno;
        document.getElementById("apellido_materno").value = alumno.apellido_materno;
        document.getElementById("fecha_nacimiento").value = alumno.fecha_nacimiento;
        document.getElementById("correo").value = alumno.correo;
        document.getElementById("telefono").value = alumno.telefono;
        document.getElementById("carrera_id").value = alumno.carrera_id;
    }
</script>
@endsection
