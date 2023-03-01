@extends('../app')
@section('content')

    @include('json.expandable_object', ['json' => $json])

@endsection
