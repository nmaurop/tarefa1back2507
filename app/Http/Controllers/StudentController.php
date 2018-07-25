<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();

        return $students->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newStudent = new Student;

        $newStudent->nome = $request->nome;
        $newStudent->idade = $request->idade;
        $newStudent->email = $request->email;
        $newStudent->cpf = $request->cpf;
        $newStudent->telefone = $request->telefone;

        $newStudent->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        if($request->nome){
          $student->nome = $request->nome;
        }
        if($request->idade){
          $student->idade = $request->idade;
        }
        if($request->email){
          $student->email = $request->email;
        }
        if($request->cpf){
          $student->cpf = $request->cpf;
        }
        if($request->telefone){
          $student->telefone = $request->telefone;
        }

        $student->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        Student::destroy($student->id);
    }
}
