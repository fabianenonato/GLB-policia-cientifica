@extends('layout.component')
@section('page')
    <div class="col-8">
        <h4>Cadastro de Munição</h4>
    </div>
    <hr>
    @include('perito.municoes.arma_curta.form', ['acao' => 'Cadastrar'])
@endsection