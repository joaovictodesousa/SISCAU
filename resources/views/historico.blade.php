@include('navbar.cabecalho')

    <main>

    <section class="container_titulo"> 
        <h1><b>Guias de recolhimento</b></h1>
    </section>
    
  <section class="container">
  
    <div class="divTable">
      <table>
        <thead>
          <tr>
            <th class="th_tipo">Tipo recolhimento</th>
            <th class="th_empresa">Empresa</th>
            <th class="th_valor">Valor</th>
            <th class="th_acoes">Ações</th>
          </tr>
        </thead>
        <tbody>
          
        @foreach($historico as $histo)
          <tr>
            <td>{{ $histo->auxtiporecolhimento }}</td>
            <td>{{ $histo->razaosocial }}</td>
            <td>R$ {{ $histo->valor }}</td>
            <td>
              <a href=" {{ route('editardados', ['GuiasRecolhimento'=> $histo->id] ) }} " class="btn btn-light btn-sm">Editar</a>
              <a href=" {{ route('principal.show', ['GuiasRecolhimento'=> $histo->id] ) }} " class="btn btn-success btn-sm">ver mais</a>
            </td>
          </tr>
        @endforeach
   
      </tbody>
      </table>
    </div>
    
  </section>

      <div class="container_botoes">
          <button class="botao_imprimir">Imprimir</button>
          <a href="{{ route('pesquisa') }}" class="botao_voltar">Voltar</a>
      </div>

    </main>

    
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.js"></script>
  </body>
</html>