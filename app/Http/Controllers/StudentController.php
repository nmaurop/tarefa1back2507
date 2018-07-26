<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Requests\CriarStudent;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /*---------------------FUNCAO EXTRA DOWNLOAD DE PDF-----------------------*/

    public function Downloadpdf($id){
        $student = Student::findorfail($id);
        $filePath = storage_path('app/localtext/' . $student->boletim);
        return response()->download($filePath, $student->boletim);
        //download(caminho pro arquivo, nome pro arquivo)
    }
    
    /*-----------------------------------------------------------------------*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return response()->json('Lista: ').$students->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CriarStudent $request)
    {
        $newStudent = new Student;

        /*--------------------------IF Local Photos----------------------------*/

        if(!Storage::exists('localtext/')) {
        Storage::makeDirectory('localtext/', 0775, true);
        }

        /*----------------------------Codigo para o PDF---------------------------------*/

        //decodifica a string em base64 e a atribui a uma variável
        $arquivo = base64_decode($request->boletim);

        //gera um nome único para o arquivo e concatena seu nome com a
        //extensão ‘.abcd’ 

        $nomearquivo = uniqid() . '.pdf';


        $path = storage_path('/app/localtext/' . $nomearquivo);
        //salva o que está na variável $image como o arquivo definido em $path
        file_put_contents($path,$arquivo);
        $newStudent->boletim = $nomearquivo;

        /*--------------------------------------------------------------------*/

        $newStudent->nome = $request->nome;
        $newStudent->idade = $request->idade;
        $newStudent->email = $request->email;
        $newStudent->cpf = $request->cpf;
        $newStudent->telefone = $request->telefone;
        $newStudent->save();
        return response()->json('Estudante registrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return response()->json('Informacao encontrada: ').response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(CriarStudent $request, Student $student)
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
        if($request->boletim){
            $student->boletim = $request->boletim;
        }

        $student->save();
        return response()->json('Informacoes atualizadas com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        Storage::delete('localtext/' . $student->boletim);
        Student::destroy($student->id);
        return response()->json('Estudante excluido com sucesso!');
    }
}
