<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::with('carrera')->paginate(10);
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $carreras = Carrera::all();
        return view('alumnos.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rut' => 'required|unique:alumnos',
            'nombres' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'fecha_nacimiento' => 'required|date',
            'correo' => 'required|email|unique:alumnos',
            'telefono' => 'required',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        Alumno::create($request->all());

        return redirect()->route('alumnos.index')->with('success', 'Alumno creado con éxito.');
    }

    public function show(Alumno $alumno)
    {
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        $carreras = Carrera::all();
        return view('alumnos.edit', compact('alumno', 'carreras'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'rut' => 'required|unique:alumnos,rut,' . $alumno->id,
            'nombres' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'fecha_nacimiento' => 'required|date',
            'correo' => 'required|email|unique:alumnos,correo,' . $alumno->id,
            'telefono' => 'required',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        $alumno->update($request->all());

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado con éxito.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado con éxito.');
    }
}

