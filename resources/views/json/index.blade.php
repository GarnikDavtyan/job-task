@extends('../app')
@section('content')

    <a href="{{ route('jsons.create') }}">Create a JSON</a>
    <a href="{{ route('jsons.edit') }}">Edit a JSON</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Json</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jsons as $json)
                <tr>
                    <td>{{ $json['id'] }}</td>
                    <td>{{ $json->user['name'] }}</td>
                    <td>{{ $json['json'] }}</td>
                    <td>
                        <div class="buttons">
                            <a href="{{ route('jsons.show', $json['id']) }}">View</a>
                            <form action="{{ route('jsons.destroy', $json['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

