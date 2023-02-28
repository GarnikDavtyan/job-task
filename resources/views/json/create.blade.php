@extends('../app')
@section('content')
    <form id="json-form">
        Token: <input id="token" name="token"/><br><br>
        Request type: <select id="type" name="type">
                <option value="GET" selected>
                    GET
                </option>
                <option value="POST">
                    POST
                </option>
            </select><br><br>
        JSON: <textarea id="json" name="json"></textarea><br><br>
        <button type="submit">Submit</button>
    </form>
    <div id="response-container">
        <div id="json-response"></div>
        <div id="error-message"></div>
    </div>
@endsection

