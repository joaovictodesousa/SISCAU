@include('navbar.cabecalho')

<p class="titulo_destroy">Deseja deletar?</p>
 
    <div class="conatiner_botao_destroy">
        <form action="{{ route('principal.destroy', ['GuiasRecolhimento' => $GuiasRecolhimento->id]) }}" method="POST">
        @csrf
        <input name="_method" type="hidden" value="DELETE">    
        <button class="btn btn-success" type="submit" style="padding: 10px 25px">Sim</button>  
        </form>
        <a href="{{ route('pesquisa') }}" class="btn btn-danger" style="padding: 10px 25px">Não</a>
    </div>
</body>
