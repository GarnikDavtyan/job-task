$(document).ready(function() {
    $('.toggle').click(function() {
        let toggle = $(this);
        let jsonObject = toggle.next('.json-object');
        let isExpanded = jsonObject.hasClass('expanded');

        if (isExpanded) {
            jsonObject.removeClass('expanded');
            jsonObject.addClass('collapsed');
            $(this).html('+');
            jsonObject.hide();
        } else {
            jsonObject.addClass('expanded');
            jsonObject.removeClass('collapsed');
            $(this).html('-');
            jsonObject.show();
        }
    });
});