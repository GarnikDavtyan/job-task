$('#json-form').on('submit',function(e){
    e.preventDefault();

    $('#response-container').hide();
    $('#json-response').empty();
    $('#error-message').empty();
    let token = $('#token').val();
    let method = $('#type').val();
    let json = $('#json').val();

    $.ajax({
      url: "/api/save-json",
      type: method,
      headers: {
        "Authorization": "Bearer " + token
      },
      data:{
        json: json
      },

      success: function(response){
        $('#json-response').html(
          `<div>ID: ${response.data.id}</div>
          <div>Memory used by query: ${response.data.query_memory_used}B</div>
          <div>Duration of query: ${response.data.query_time}ms</div>
          <div>Memory used by request: ${response.data.request_memory_used}B</div>
          <div>Duration of request: ${response.data.request_time}ms</div>`
          );
      },

      error: function(response) {
        $('#error-message').text(response.responseJSON.message);
      },

      complete: function() {
        $('#response-container').show();
      }
      });
    });