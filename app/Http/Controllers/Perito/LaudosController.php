<?php

/*
 * Developed by Milena Mognon
 */

namespace App\Http\Controllers\Perito;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaudoRequest;
use App\Models\Cidade;
use App\Models\Diretor;
use App\Models\Gerador\Gerar;
use App\Models\Laudo;
use App\Models\OrgaoSolicitante;
use App\Models\Secao;
use Illuminate\Support\Facades\Auth;

class LaudosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::id();
        $laudos = Laudo::findMyReps($user);
        return view('perito.laudo.index', compact('laudos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $secoes = Secao::all();
        $cidades = Cidade::all();
        $diretores = Diretor::all();

        return view('perito.laudo.create',
            compact('secoes', 'cidades', 'diretores'));
    }

    /*
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(LaudoRequest $request)
    {
        $laudo = Laudo::config_laudo_info($request);
        $laudo = Laudo::create($laudo);
        $laudo_id = $laudo->id;
        return redirect()->route('laudos.materiais', compact('laudo_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Laudo $laudo
     * @return \Illuminate\Http\Response
     */
    public function show(Laudo $laudo)
    {
        $cidades = Cidade::all();
        $secoes = Secao::all();
        $diretores = Diretor::allOrdered();
        $solicitantes = OrgaoSolicitante::fromCity($laudo->cidade_id);
        $armas = $laudo->armas;
        $municoes = $laudo->municoes;
        $componentes = $laudo->componentes;
        return view('perito.laudo.show',
            compact('laudo', 'cidades', 'solicitantes',
                'diretores', 'secoes', 'armas', 'municoes', 'componentes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Laudo $laudo
     * @return \Illuminate\Http\Response
     */
    public function update(LaudoRequest $request, $laudo)
    {
        $updated_laudo = Laudo::config_laudo_info($request);
        Laudo::find($laudo->id)->fill($updated_laudo)->save();
        $laudo_id = $laudo->id;
        return redirect()->route('laudos.show', compact('laudo_id'))
            ->with('success', __('flash.update_m', ['model' => 'Laudo']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $laudo
     * @return \Illuminate\Http\Response
     */
    public function destroy($laudo)
    {
        Laudo::destroy($laudo->id);
        return response()->json(['success' => 'done']);
    }

    public function materiais($laudo)
    {
        return view('perito.materiais', compact('laudo'));
    }

    public function generate_docx(Laudo $laudo)
    {
        if ($laudo->armas->isEmpty() && $laudo->municoes->isEmpty() && $laudo->componentes->isEmpty()) {
            return redirect()->route('laudos.show', compact('laudo'))
                ->with('warning', '?? preciso ter ao menos 1 (um) material cadastrado para gerar o laudo!');
        } else {
            $phpWord = new Gerar();
            $phpWord = $phpWord->create_docx($laudo);

            return $phpWord;
        }
    }

    public function search($rep)
    {
        $rep = str_replace('-', '/', $rep);
        $laudo = Laudo::where([['rep', $rep], ['perito_id', Auth::id()]])->first();
        if(empty($laudo)){
            return response()->json(['fail' => 'true',
            'message' => 'Nenhum laudo encontrado em este n??mero (' . $rep . ')']);
        } else {
            $laudo_id = $laudo->id;
            return response()->json(['url' => route('laudos.show', $laudo)]);
        }
    }
}
