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
            ->select('usuario.idpersona', 'usuario.usuario', 'usuario.activo', 'persona.nombres', 'persona.apellidos')
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
            'idpersona' => ['required', 'integer'],
            'usuario' => ['required', 'string'],
            'clave' => ['required', 'string'],
            'activo' => ['nullable', 'boolean'],
        ]);

        try {
            DB::connection('reportes')->table('usuario')->insert([
                'idpersona' => $data['idpersona'],
                'usuario' => $data['usuario'],
                'clave' => $data['clave'],
                'activo' => $data['activo'] ?? false,
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Error al crear'])->withInput();
        }
    }

    public function edit(int $id)
    {
        $usuario = $this->conn->table('usuario')->where('idpersona', $id)->first();
        if (! $usuario) {
            abort(404);
        }

        return view('usuarios.form', [
            'usuario' => $usuario,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $usuario = $this->conn->table('usuario')->where('idpersona', $id)->first();
        if (! $usuario) {
            abort(404);
        }

        $data = $request->validate([
            'idpersona' => ['required', 'integer'],
            'usuario' => ['required', 'string'],
            'clave' => ['required', 'string'],
            'activo' => ['nullable', 'boolean'],
        ]);

        try {
            DB::connection('reportes')->table('usuario')->where('idpersona', $id)->update([
                'idpersona' => $data['idpersona'],
                'usuario' => $data['usuario'],
                'clave' => $data['clave'],
                'activo' => $data['activo'] ?? false,
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Error al actualizar'])->withInput();
        }
    }

    public function destroy(int $id)
    {
        try {
            DB::connection('reportes')->transaction(function () use ($id) {
                $usuario = DB::connection('reportes')->table('usuario')->where('idpersona', $id)->first();
                if ($usuario) {
                    DB::connection('reportes')->table('usuario')->where('idpersona', $id)->delete();
                    DB::connection('reportes')->table('persona')->where('idpersona', $id)->delete();
                }
            });

            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Error al eliminar']);
        }
    }
}
