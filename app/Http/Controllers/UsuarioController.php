<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::connection('reportes');
    }

    public function index()
    {
        $usuarios = $this->conn->table('usuario')
            ->join('persona', 'persona.idpersona', '=', 'usuario.idpersona')
            ->select('usuario.idusuario', 'usuario.usuario', 'usuario.activo', 'persona.nombres', 'persona.apellidos')
            ->get();

        return view('usuarios.index', [
            'usuarios' => $usuarios,
        ]);
    }

    public function create()
    {
        return view('usuarios.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'identificacion' => ['required', 'string'],
            'nombres' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'direccion' => ['nullable', 'string'],
            'celular' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'usuario' => ['required', 'string'],
            'clave' => ['required', 'string'],
            'activo' => ['nullable', 'boolean'],
        ]);

        try {
            DB::connection('reportes')->transaction(function () use ($data) {
                $personaId = DB::connection('reportes')->table('persona')->insertGetId([
                    'identificacion' => $data['identificacion'],
                    'nombres' => $data['nombres'],
                    'apellidos' => $data['apellidos'],
                    'direccion' => $data['direccion'] ?? null,
                    'celular' => $data['celular'] ?? null,
                    'email' => $data['email'] ?? null,
                ]);

                DB::connection('reportes')->table('usuario')->insert([
                    'idpersona' => $personaId,
                    'usuario' => $data['usuario'],
                    'clave' => $data['clave'],
                    'activo' => $data['activo'] ?? false,
                ]);
            });

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Error al crear'])->withInput();
        }
    }

    public function edit(int $id)
    {
        $usuario = $this->conn->table('usuario')->where('idusuario', $id)->first();
        if (! $usuario) {
            abort(404);
        }
        $persona = $this->conn->table('persona')->where('idpersona', $usuario->idpersona)->first();

        return view('usuarios.form', [
            'usuario' => $usuario,
            'persona' => $persona,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $usuario = $this->conn->table('usuario')->where('idusuario', $id)->first();
        if (! $usuario) {
            abort(404);
        }

        $data = $request->validate([
            'identificacion' => ['required', 'string'],
            'nombres' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'direccion' => ['nullable', 'string'],
            'celular' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'usuario' => ['required', 'string'],
            'clave' => ['required', 'string'],
            'activo' => ['nullable', 'boolean'],
        ]);

        try {
            DB::connection('reportes')->transaction(function () use ($data, $usuario, $id) {
                DB::connection('reportes')->table('persona')->where('idpersona', $usuario->idpersona)->update([
                    'identificacion' => $data['identificacion'],
                    'nombres' => $data['nombres'],
                    'apellidos' => $data['apellidos'],
                    'direccion' => $data['direccion'] ?? null,
                    'celular' => $data['celular'] ?? null,
                    'email' => $data['email'] ?? null,
                ]);

                DB::connection('reportes')->table('usuario')->where('idusuario', $id)->update([
                    'usuario' => $data['usuario'],
                    'clave' => $data['clave'],
                    'activo' => $data['activo'] ?? false,
                ]);
            });

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
        }
    }

    public function destroy(int $id)
    {
        try {
            DB::connection('reportes')->transaction(function () use ($id) {
                $usuario = DB::connection('reportes')->table('usuario')->where('idusuario', $id)->first();
                if ($usuario) {
                    DB::connection('reportes')->table('usuario')->where('idusuario', $id)->delete();
                    DB::connection('reportes')->table('persona')->where('idpersona', $usuario->idpersona)->delete();
                }
            });

            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Error al eliminar']);
        }
    }
}
