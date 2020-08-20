/*start....only for the right_sidebar , it should be removed finally...*/
/*$(document).on('click','.on-click',function(){
    var val=$(this).children('.hidden').html();
    alert(val);
});*/
/*end...only for the right_sidebar , it should be removed finally...*/

/* ............for delete button start...................*/
$(document).on('submit', '.delete-form', function() {
    return confirm('Are you sure ?');
});
/* ............for delete button end...................*/

$('#custom-alert').on('closed.bs.alert', function() {
    $('#alert-container').remove();
})
$("#alert-container").fadeTo(2000, 500).slideUp(500, function(){
    $("#alert-container").slideUp(500);
});

var tooltipArr = [
    { "className": "fa-edit", "title": "Edit" },
    { "className": "fa-eye", "title": "View" },
    { "className": "fa-remove", "title": "Delete" },
    { "className": "fa-plus", "title": "Add" },
    { "className": "fa-list", "title": "View List" },

];

tooltipArr.forEach(function(item, index) {
    var tis = $('.' + item.className).parent();
    tis.attr("title", item.title);
    tis.tooltip();
});

function readURL(input) {   
    var preview_location = $(input).parent().parent().find('.preview-div');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview_location.html('<img class="img-responsive" width="70" src="' + e.target.result + '">');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

/* -- start User role permission check box true false control -- */
function permission_select_deselect_child(selector) {
    var check;
    if ($(selector).is(':checked') === false) {
        check = false;
    } else {
        check = true;
    }
    if ($(selector).parent().parent().hasClass('controller') === true) {
        var action_ul = $(selector).parent().parent().next('div.action-wraper');
        $.each(action_ul.children('.actions'), function(ind, val) {
            var cur_check_box = $(val).children().children('input');
            $(cur_check_box).prop('checked', check);
        });
    }
}

function permission_select_parent(selector) {
    var check = $('.' + selector).is(':checked');
    $('.parent_' + selector).prop('checked', check);
}
/* -- End User role permission check box true false control -- */