@extends('layout.component')
@section('page')
    <div class="col-8">
        <h4>Atualizar Munição</h4>
    </div>
    <hr>
    @include('perito.municoes.arma_longa.form', ['acao' => 'Atualizar'])
@endsection
