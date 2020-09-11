<?php

namespace App\Http\Controllers;
use App\Models\Tareas;
use Illuminate\Http\Request;
use Response;
class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $tarea = new Tareas();
            $tarea->name = $request->name;
            $tarea->description = $request->description;
            $tarea->idusers = $request->idusers;
            $tarea->save();
            return \Response::json($tarea, 201);
        } catch (\Throwable $th) {
            return \Response::json($th, 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tareas  $tareas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $tarea = Tareas::where('idusers',$id)->get();
            return \Response::json($tarea, 201);
        } catch (\Throwable $th) {
            return \Response::json($tarea, 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tareas  $tareas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $tarea = Tareas::find($id);
            return \Response::json($tarea, 201);
        } catch (\Throwable $th) {
            return \Response::json($tarea, 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tareas  $tareas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $tarea = Tareas::find($id);
            $tarea->name = $request->name;
            $tarea->description = $request->description;
            $tarea->state = $request->state;
            $tarea->save();
            return \Response::json($tarea, 201);
        } catch (\Throwable $th) {
            return \Response::json($tarea, 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tareas  $tareas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $tarea = Tareas::destroy($id);
            return \Response::json(['Tarea'=>'Tarea eliminado correctamente'], 200);
        } catch (\Throwable $th) {
            return \Response::json($th, 401);
        }
    }
}
