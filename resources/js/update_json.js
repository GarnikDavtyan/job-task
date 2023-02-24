$('#update-json-form').on('submit',function(e){
    e.preventDefault();

    $('#response-container-update').hide();
    $('#json-response-update').empty();
    $('#error-message-update').empty();
    let token = $('#token-update').val();
    let method = $('#type-update').val();
    let id = $('#id-update').val();
    let code = $('#code-update').val();

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: "update-json",
      type: method,
      headers: {
        "Authorization": "Bearer " + token
      },
      data:{
        id: id,
        code: code
      },

      success: function(response){
        $('#json-response-update').html(
          `<div>JSON updated successfully</div>
          <div>Updated JSON: ${response.data}</div>`
          );
      },

      error: function(response) {
        $('#error-message-update').text(response.responseJSON.message);
      },

      complete: function() {
        $('#response-container-update').show();
      }
      });
    });