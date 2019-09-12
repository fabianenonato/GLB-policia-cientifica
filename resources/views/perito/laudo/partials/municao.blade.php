@foreach ($municoes as $municao)

    <tr align="center">
        <td> {{ mb_strtoupper($municao->tipo_municao) }} </td>
        <td> {{ $municao->marca->nome }} </td>
        <td> {{ $municao->calibre->nome }} </td>
        <td> {{ $municao->quantidade }} (Unidades)</td>
        <td></td>
        <td></td>
        <td>
            <a class="btn btn-primary"
               href="#">
                <i class="far fa-edit"></i>
            </a>

            <button value="{{ route('municoes.destroy', $municao) }}" type="submit" class="btn btn-danger delete">
                <i class="far fa-trash-alt"></i>
            </button>
        </td>
    </tr>
    </tr>
@endforeach