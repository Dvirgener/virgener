// * Function for viewing work details
$(document).on('click', '.viewWorkBut', function () {
    var id = $(this).val();
    var viewedFrom = $('#viewedFrom').val();
    $.ajax({
            type: "GET",
            url: "/"+viewedFrom+"/details/"+id,
            success: function (response) {
                $("#pageLoader").html(response);
            }
        })
});

// * view File Modal
$(document).on('click', '.viewFileBut', function () {
    var filename = $(this).val();  
    $.ajax({
        type: "GET",
        url: "/profile/viewfile?file="+filename,
        success: function (response) {
            $("#viewFiles").html(response);
            $('#viewFileModal').modal('show');
        }
    })
});

$(document).on('change', '#selectUpdateView', function () {
    var id = $(this).val();
    var mainId = $('#main_id').val();
    var viewedFrom = $('#viewedFrom').val();
    var viewedOn = $('#viewedOn').val();
        $.ajax({
        type: "GET",
        url: "/"+viewedFrom+"/details/sub/"+mainId+"/"+id,
        success: function (response) {
            $("#updateCol").html(response);
        }
    })
});