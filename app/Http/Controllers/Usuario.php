<?php

namespace App\Http\Controllers;

use App\Models\TipoUsuario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class Usuario extends Controller
{
    use RefreshDatabase;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('tipos')->get()->except(auth()->user()->id);

        return Inertia::render(
            'Users/Index',
            [
                'users' => $users,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = TipoUsuario::all();        

        return Inertia::render(
            'Users/Create',
            [
                'tipos' => $tipos,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users', 'email', 'string', 'max:255'],
            'password' => ['required','confirmed', Password::defaults()],
            'tipo_id' => ['required', 'integer']
        ]);

        /* return $request->all(); */
        User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),                
                'remember_token' => Str::random(10),
                'tipo_usuario_id' => $request->tipo_id,
            ]
        );

        sleep(1);

        return redirect()->route('users.index')->with('message', 'Usuario creado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('tipos')->find($id);
        $tipos = TipoUsuario::all();        

        return Inertia::render(
            'Users/Edit',
            [
                'user' => $user,
                'tipos' => $tipos,
            ]
        );
    }

    public function profile($id)
    {
        $user = User::with('tipos')->find($id);               

        return Inertia::render(
            'Users/Profile',
            [
                'user' => $user,                
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'email', 'string', 'max:255'],                        
        ]);

        $eUser = [
            'name' => $request->name,
            'email' => $request->email,                                    
            'tipo_usuario_id' => $request->tipo_id,
        ];

        if(!empty($request->password))
        {
            $request->validate([                                
                'password' => ['required','confirmed', Password::defaults()],                
            ]);

            $eUser['password'] = Hash::make($request->password);
        }

        User::find($id)->update($eUser);
        sleep(1);
        return redirect()->route('users.index')->with('message', 'Usuario modificado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        sleep(1);
        return redirect()->route('users.index')->with('message', 'Usuario eliminado con éxito.');
    }
}
