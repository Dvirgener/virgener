

//  ========================================= UNIT ACTIVITIES PAGE ================================================================= 


// Data table for Unit Activities
$(function() {
    $('#example2').DataTable({
        order: [
            [1, 'asc']
        ],
        scrollCollapse: false,
        scrollY: '450px',
    });
});
// Data table for Unit Activities

// Data table for Unit Activities
$(function() {
    $('#workHistory').DataTable({
        order: [
            [0, 'asc']
        ],
        scrollCollapse: false,
        scrollY: '470px',
    });
});
// Data table for Unit Activities

// search for activities on add SAA buttonc
$(document).on('submit', '#search_act', function (f) {

    f.preventDefault();
    var data = $(this).serialize;
    $.ajax({
        type: 'GET',
        url: '/spendingplan/addsaa',
        data:$(this).serialize(),
        success: function (response) {
            $("#resultTable").html(response);
            $("#resMe").load(location.href + " #resMe>*", ""); 

        }
    })
})
// search for activities on add SAA buttonc

// * Check all boxes
$(document).on('click', '#checkall', function () {
    $("#saa_adder input[type='checkbox'").prop('checked', this.checked);
    $("#addWorkForm input[type='checkbox'").prop('checked', this.checked);
    $("#editWorkForm input[type='checkbox'").prop('checked', this.checked);
})


// * This is for the add sub work button

let id = 1;
$(document).on('click', '#addSub', function () {
    id++;
    $('.subWorkGroup').append('<div class="row mb-2" id="id'+id+'"><div class="col-10 col-md-11"><input class="form-control" type="text" id="sub[]" name="sub[]"></div><div class="col-2 col-md-1"><button type="button" class="btn btn-danger removeDiv" id="'+id+'">&times</button></div></div>');

    $(document).on('click', '.removeDiv', function () {
        var butToRemove = $(this).attr("id");
        $('#id' + butToRemove).remove();
    });




});


// * Check to check atleast one checkbox
$(document).on('click', '.form-check-required', function () {
    var checkboxes = $('.form-check-required');
    checkboxes.change(function () {
        if ($('.form-check-required:checked').length > 0) {
            checkboxes.removeAttr('required');
        } else {
            checkboxes.attr('required', 'required');
        }
    });
});

// function view Saa Details
$(document).on('click', '.view_saa_but', function () {
    var saa_id = $(this).val();
    //ajax code    
    $.ajax({
        type: "GET",
        url: "/spendingplan/viewsaa?id=" + saa_id,
        // response code
        success: function (response) {
                $("#saa_view").html(response);
        }
        // response code
    })
    // ajax code
});
// function view Saa Details


// function Delete Saa Details
$(document).on('click', '.delete_saa_but', function () {

    var saa_id = $(this).val();
    //ajax code    
    $.ajax({
        type: "GET",
        url: "/spendingplan/deletesaa?id=" + saa_id,
        // response code
        success: function (response) {
                $("#saa_row").load(location.href + " #saa_row>*", ""); 
        }
        // response code
    })
    // ajax code
});
// function Delete Saa Details



//  ========================================= UNIT ACTIVITIES PAGE =================================================================



// function for viewing work queues from user profile
$(document).on('click', '.viewWorkBut', function () {
    var id = $(this).val();
    window.location.href = "/profile/workdetail?id=" + id;
});
// function for viewing work queues from user profile


// function for viewing Added Work Queue
$(document).on('click', '.viewAddedWorkBut', function () {
    var id = $(this).val();
    window.location.href = "/profile/added/workdetail?id=" + id;
});
// function for viewing Added Work Queue



// function Delete Saa Details
$(document).on('click', '.viewWorkButHistory', function () {

    var id = $(this).val();
    window.location.href = "/history/workdetail?id=" + id;
});
// function Delete Saa Details




// * view File Modal
$(document).on('click', '.viewFileBut', function () {
    var filename = $(this).val();
        //ajax code    
    $.ajax({
        type: "GET",
        url: "/profile/workdetail/viewfile?file=" + filename,
        // response code
        success: function (response) {
            $("#viewFiles").html(response);
            $('#viewFileModal').modal('show');

        }
        // response code
    })
    // ajax code
});

// * Edit Work Modal
$(document).on('click', '.editWorkBut', function () {
    var id = $(this).val();
        //ajax code    
    $.ajax({
        type: "GET",
        url: "/editwork?id=" + id,
        // response code
        success: function (response) {
            $("#editWorkFormDiv").html(response);
            $('#editWorkModal').modal('show');

        }
        // response code
    })
    // ajax code
});

// * Delete Work Modal
$(document).on('click', '.deleteWorkBut', function () {
    var id = $(this).val();
        //ajax code    
    $.ajax({
        type: "GET",
        url: "/deletework?id=" + id,
        // response code
        success: function (response) {
            $("#deleteWorkForm").html(response);
            $('#deleteWorkModal').modal('show');

        }
        // response code
    })
    // ajax code
});

// * Cancel Delete Work
$(document).on('click', '#cancelDelete', function () {
    $('#deleteWorkModal').modal('hide');
    $('#deleteSubWorkModal').modal('hide');
});

// * Add Sub-work
$(document).on('click', '#addSubWorkBut', function () {
    $('#addSubWorkModal').modal('show');
});

// * Delete Work Modal
$(document).on('click', '.editSubWork', function () {
    var id = $(this).val();
        //ajax code    
    $.ajax({
        type: "GET",
        url: "/editsubwork?id=" + id,
        // response code
        success: function (response) {
            $("#editSubWorkDiv").html(response);
            $('#editSubWorkModal').modal('show');

        }
        // response code
    })
    // ajax code
});


// * DeleteSub  Work Modal
$(document).on('click', '.deleteSubWorkBut', function () {
    var id = $(this).val();
        //ajax code    
    $.ajax({
        type: "GET",
        url: "/deletesubwork?id=" + id,
        // response code
        success: function (response) {
            $("#deleteSubWorkForm").html(response);
            $('#deleteSubWorkModal').modal('show');

        }
        // response code
    })
    // ajax code
});

// * view File Modal
$(document).on('click', '.updateWorkBut', function () {
    var idToUpdate = $(this).val();

    $('#idToUpdate').val(idToUpdate);
    $('#updateWorkModal').modal('show');
    
});

// * view File Modal
$(document).on('click', '.updateSubWorkBut', function () {
    var subIdToUpdate = $(this).val();
    $('#subIdToUpdate').val(subIdToUpdate);
    $('#updateSubWorkModal').modal('show');
    
});

// * view File Modal
$(document).on('click', '.complySubWorkBut', function () {
    var subIdToUpdate = $(this).val();
    $('#subIdToComply').val(subIdToUpdate);
    $('#complySubWorkModal').modal('show');
    
});

// * view File Modal
$(document).on('click', '.complyWorkBut', function () {
    var IdToUpdate = $(this).val();
    $('#IdToComply').val(IdToUpdate);
    $('#complyWorkModal').modal('show');
    
});


// * Delete Work Modal
$(document).on('click', '.approveBut', function () {
    var id = $(this).val();
        //ajax code    
    $.ajax({
        type: "GET",
        url: "/confirmwork?id=" + id,
        // response code
        success: function (response) {
            $("#approveOrNotDiv").html(response);
            $('#confirmWorkModal').modal('show');

        }
        // response code
    })
    // ajax code
});

// * Confirm Work Compliancel
$(document).on('click', '#confCompliance', function () {

    var id = $(this).val();
        //ajax code    
    $.ajax({
        type: "GET",
        url: "/confirmcompliance?id=" + id,

        success: function (response) {
        window.location.href = "/profile";  
        }
    })
    // ajax code
});

$(document).on('click', '#returnCompliance', function () {

    var id = $(this).val();
        //ajax code    
    $.ajax({
        type: "GET",
        url: "/returncompliance?id=" + id,

        success: function (response) {
        window.location.href = "/profile";  
        }
    })
    // ajax code
});