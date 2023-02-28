@extends('../app')
@section('content')
    <form id="update-json-form">
        Token: <input id="token-update" name="token"/><br><br>
        Request type: <select id="type-update" name="type">
                <option value="GET" selected>
                    GET
                </option>
                <option value="POST">
                    POST
                </option>
            </select><br><br>
        ID: <input id="id-update" name="id"/><br><br>
        Code: <input id="code-update" name="code"/><br><br>
        <button type="submit">Submit</button>
    </form>
    <div id="response-container-update">
        <div id="json-response-update"></div>
        <div id="error-message-update"></div>
    </div>
@endsection

