<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\AuxTipoRecolhimento;
use App\Models\AuxAgencias;
use App\Models\AuxTipoDocumento;
use App\Models\AuxInstituicoesFinanceiras;
use App\Models\AuxEmpresas;
use App\Models\GuiasRecolhimento;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PrincipalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function historico()
    {
        return view('retornar_historico')->redirect()->back();
    }

    public function index()
    {

        // $historico = Filtro::paginate(15);

        // chamando dados das tabelas auxiliares
        $recolhimentos = AuxTipoRecolhimento::all();
        $agencias = AuxAgencias::all();
        $documentos = AuxTipoDocumento::all();

        return view('pesquisa', [
            'recolhimentos' => $recolhimentos,
            'agencias' => $agencias,
            'documentos' => $documentos,
            // 'historico' => $historico
        ]);
    }


    public function create()
    {
        //função de cadastrar os select de outras tabelas auxiliares

        //Quando não tiver o select seria somente o retorn view('cadastro')

        //A função create em si é usada para exibir o formulário de criação de um recurso, ou seja, 
        //é usada para exibir um formulário no qual os usuários podem preencher os dados necessários 
        //para criar um novo registro no banco de dados.

        $recolhimentos = AuxTipoRecolhimento::all();
        $financas = AuxInstituicoesFinanceiras::all();
        $agencia = AuxAgencias::all();
        $documento = AuxTipoDocumento::all();
        $empresa = AuxEmpresas::all();

        // dd($recolhimentos);

        return view('cadastro', [
            'recolhimentos' => $recolhimentos,
            'financas' => $financas,
            'agencia' => $agencia,
            'documento' => $documento,
            'empresa' => $empresa
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'numeroconta' => 'required|string|max:10',
            // Máximo de 10 caracteres
            'numerocontrato' => 'required|string|max:10',
            'aditivo' => 'required|string|max:10',
            'datagr' => 'required|string|max:10',
            'datavalidade' => 'required|string|max:10',
            'numero' => 'required|string|max:10',
            'valor' => 'required|string|max:10',
            'numerodocumento' => 'required|string|max:10',
            'numeronl' => 'required|string|max:10',
            'historico' => 'required|string|max:10'
        ]);

        // $ultimoDado = GuiasRecolhimento::latest()->first();

        $request['valor'] = str_replace(',', '.', $request['valor']);

        $GuiasRecolhimento = new GuiasRecolhimento;
        $GuiasRecolhimento->fill($request->all());
        $GuiasRecolhimento->save();

        return redirect()->route('principal.mostrarcadastro', [ 'GuiasRecolhimento' => $GuiasRecolhimento ])->with('success', 'Guia de recolhimento cadastrada com sucesso.');
    }

    public function show(GuiasRecolhimento $GuiasRecolhimento)
    {
        $recolhimentos = AuxTipoRecolhimento::all();
        $financas = AuxInstituicoesFinanceiras::all();
        $agencia = AuxAgencias::all();
        $documento = AuxTipoDocumento::all();
        $empresa = AuxEmpresas::all();

        //dd($GuiasRecolhimento->TipoRecolhimento->descricao);

        return view('show', [
            'GuiasRecolhimento' => $GuiasRecolhimento,
            'recolhimentos' => $recolhimentos,
            'financas' => $financas,
            'agencia' => $agencia,
            'documento' => $documento,
            'empresa' => $empresa
        ]);      
        // view para mostrar o view show
    }

    public function filtrar(Request $request)
    {

        // Passando a variavel para cada input do campo de pesquisa
        $nr = $request->input('nr');
        $nrcontrato = $request->input('nrcontrato');
        $nrdocumento = $request->input('nrdocumento');
        $auxtiporecolhimentoid = $request->input('auxtiporecolhimentoid');
        $codigoagencia = $request->input('codigoagencia');
        $nrbaixaprocesso = $request->input('nrbaixaprocesso');
        $nrcpfcnpj = $request->input('nrcpfcnpj');
        $datagrinicio = $request->input('datagrinicio');
        $datagrfim = $request->input('datagrfim');
        $datavalidadeinicio = $request->input('datavalidadeinicio');
        $datavalidadefim = $request->input('datavalidadefim');
        $databaixainicio = $request->input('databaixainicio');
        $databaixafim = $request->input('databaixafim');
        $nrauxtipodocumentoid = $request->input('nrauxtipodocumentoid');
        $nrnumeronl = $request->input('nrnumeronl');
        $tipoconsulta = $request->input('tipoconsulta');

        //Função do PROSDURE
        $historico = DB::select("
            SELECT * FROM pesquisa(
                :nr,
                :nrcontrato,
                :nrdocumento,
                :auxtiporecolhimentoid,
                :codigoagencia,
                :nrbaixaprocesso,
                :nrcpfcnpj,
                :datagrinicio,
                :datagrfim,
                :datavalidadeinicio,
                :datavalidadefim,
                :databaixainicio,
                :databaixafim,
                :nrauxtipodocumentoid,
                :nrnumeronl,
                :tipoconsulta
            )
                
        ", [
            'nr' => $nr,
            'nrcontrato' => $nrcontrato,
            'nrdocumento' => $nrdocumento,
            'auxtiporecolhimentoid' => $auxtiporecolhimentoid,
            'codigoagencia' => $codigoagencia,
            'nrbaixaprocesso' => $nrbaixaprocesso,
            'nrcpfcnpj' => $nrcpfcnpj,
            'datagrinicio' => $datagrinicio,
            'datagrfim' => $datagrfim,
            'datavalidadeinicio' => $datavalidadeinicio,
            'datavalidadefim' => $datavalidadefim,
            'databaixainicio' => $databaixainicio,
            'databaixafim' => $databaixafim,
            'nrauxtipodocumentoid' => $nrauxtipodocumentoid,
            'nrnumeronl' => $nrnumeronl,
            'tipoconsulta' => $tipoconsulta
        ]); //Acima estamos passando a os nomes da função para variavel para saber onde vai funcionar cada nome da pesquisa

        //Função de paginação
        $historicoCollection = collect($historico);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $currentPageItems = $historicoCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
    
        $historicoPaginated = new LengthAwarePaginator(
            $currentPageItems,
            count($historicoCollection),
            $perPage,
            $currentPage,
            ['path' => $request->fullUrl(), 'query' => $request->query()]
        );
    
        $historicoPaginated = $historicoPaginated->appends(request()->except('page'));
    
        return view('historico', [
            'historico' => $historicoPaginated
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(GuiasRecolhimento $GuiasRecolhimento)
    {
        //mostrar os dados no input que vai trazer, no caso os que vai trazer para o blade

        $recolhimentos = AuxTipoRecolhimento::all();
        $financas = AuxInstituicoesFinanceiras::all();
        $agencia = AuxAgencias::all();
        $empresa = AuxEmpresas::all();
        $documento = AuxTipoDocumento::all();

        return view('Edit', [
            'GuiasRecolhimento' => $GuiasRecolhimento,
            'recolhimentos' => $recolhimentos,
            'financas' => $financas,
            'agencia' => $agencia,
            'empresa' => $empresa,
            'documento' => $documento

        ]);

    }

    public function update(Request $request, string $id)
    {

        //Esse é o que vai fazer as alterações, que vai mudar no banco.
        $request['valor'] = str_replace(',', '.', $request['valor']); // função de colocar o . no ,

        $NewGuiaRecolhimento = [
            'auxtiporecolhimentoid' => $request->input('auxtiporecolhimentoid'),
            'auxinstituicaofinanceiraid' => $request->input('auxinstituicaofinanceiraid'),
            'auxagenciaid' => $request->input('auxagenciaid'),
            'numeroconta' => $request->input('numeroconta'),
            'numerocontrato' => $request->input('numerocontrato'),
            'aditivo' => $request->input('aditivo'),
            'datagr' => $request->input('datagr'),
            'datavalidade' => $request->input('datavalidade'),
            'auxtipodocumentoid' => $request->input('auxtipodocumentoid'),
            'numero' => $request->input('numero'),
            'auxempresaid' => $request->input('auxempresaid'),
            'valor' => $request->input('valor'),
            'numerodocumento' => $request->input('numerodocumento'),
            'numeronl' => $request->input('numeronl'),
            'historico' => $request->input('historico')
        ];

        // Atualização de resultado

        GuiasRecolhimento::where('id', $id)->update($NewGuiaRecolhimento);

        return redirect()->route('pesquisa')->with('success', 'Guia de recolhimento alterado com sucesso.');
    }

    public function destroy($id)
    {
        //Código para deixar como ativo e inativo
        $guiasrecolhimento = GuiasRecolhimento::find($id);

        if (!$guiasrecolhimento) {
            return redirect()->route('pesquisa')->with('error', 'GuiasRecolhimento não encontrado.');
        }

        $guiasrecolhimento->ativo = false; // Define o GuiasRecolhimento como inativo
        $guiasrecolhimento->save(); // salvar como inativas

        return redirect()->route('pesquisa')->with('success', 'GuiasRecolhimento excluído com sucesso.');
    }

    public function mostrarcadastro(GuiasRecolhimento $GuiasRecolhimento)
    {    
        return view('mostrarcadastro', ['GuiasRecolhimento' => $GuiasRecolhimento]);
    }
  
  }
