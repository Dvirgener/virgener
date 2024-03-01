// * Function for viewing Work list upon loading of page
$(window).on("load", function () {
    var id = $('#profileId').val();
    var viewedFrom = $('#viewedFrom').val();
            $.ajax({
            type: "GET",
            url: "/"+viewedFrom+"/work/"+id,
            success: function (response) {
                $("#pageLoader").html(response);
            }
        })
});

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

// * Function for viewing added work details
$(document).on('click', '.viewAddedWorkBut', function () {
    var id = $(this).val();
    var viewedFrom = $('#viewedFrom').val();
    var viewedOn = $('#viewedOn').val();
    $.ajax({
            type: "GET",
            url: "/"+viewedFrom+"/details/added/"+id,
            success: function (response) {
                $("#pageLoader").html(response);
            }
        })
});

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

// * ============================================================================================================ > MODALS


// * Check all boxes (MISC)
$(document).on('click', '#checkall', function () {
    $("#saa_adder input[type='checkbox'").prop('checked', this.checked);
    $("#addWorkForm input[type='checkbox'").prop('checked', this.checked);
    $("#editWorkForm input[type='checkbox'").prop('checked', this.checked);
})

// * Check to check atleast one checkbox (MISC)
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


// * Function to open Edit Work Modal
$(document).on('click', '.editWorkBut', function () {
    var id = $(this).val();  
    $.ajax({
        type: "GET",
        url: "/profile/details/edit/" + id,
        success: function (response) {
            $("#editWorkFormDiv").html(response);
            $('#editWorkModal').modal('show');
        }
    })
});

// * Function to save edited work 
$(document).on('submit', '#editWorkForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("id");
    $.ajax({
        type: 'POST',
        url: '/profile/details/edit/save',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#editWorkModal').modal('hide');
            $("#pageLoader").load("/profile/details/added/" + id);
            $("#editWorkModal").load(location.href + " #editWorkModal>*", "");
            
        }
    })
})

// * Function to Open Delete Work Modal
$(document).on('click', '.deleteWorkBut', function () {
    var id = $(this).val();  
    $("#idToDelete").val(id);
    $('#deleteWorkModal').modal('show');
});


// * Function to Open edit Sub Work modal
$(document).on('click', '.editSubWork', function () {

    var id = $(this).val();
    $.ajax({
        type: "GET",
        url: "/profile/details/edit/sub/"+id,
        success: function (response) {
            $("#editSubWorkDiv").html(response);
            $('#editSubWorkModal').modal('show');
        }
    })
});


// * Function to save edited Sub work 
$(document).on('submit', '#editSubWorkForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("main_id");
    $.ajax({
        type: 'POST',
        url: '/profile/details/edit/sub/save',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#editSubWorkModal').modal('hide');
            $("#pageLoader").load("/profile/details/added/" + id);
            $("#editSubWorkModal").load(location.href + " #editSubWorkModal>*", "");
            
        }
    })
})

// * Function to open Delete Sub Work Modal
$(document).on('click', '.deleteSubWorkBut', function () {
    var id = $(this).val();  
    $.ajax({
        type: "GET",
        url: "/profile/details/delete/sub/"+id,
        success: function (response) {
            $("#deleteSubWorkForm").html(response);
            $('#deleteSubWorkModal').modal('show');
        }
    })
});

// * Function to save deleted sub work 
$(document).on('submit', '#deleteSubWorkForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("main_id");
    $.ajax({
        type: 'POST',
        url: '/profile/details/delete/sub',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#deleteSubWorkModal').modal('hide');
            $("#pageLoader").load("/profile/details/added/" + id);
            $("#deleteSubWorkModal").load(location.href + " #deleteSubWorkModal>*", "");
            $("#deleteWorkModal").load(location.href + " #deleteWorkModal>*", "");
        }
    })
})

// * Add Sub-work modal
$(document).on('click', '#addSubWorkBut', function () {
    $('#addSubWorkModal').modal('show');
});

// * Function to save Added Sub work 
$(document).on('submit', '#addSubWorkForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("mainId");
    $.ajax({
        type: 'POST',
        url: '/profile/details/add/sub',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#addSubWorkModal').modal('hide');
            $("#pageLoader").load("/profile/details/added/" + id);
            $("#deleteSubWorkModal").load(location.href + " #deleteSubWorkModal>*", "");
            $("#deleteWorkModal").load(location.href + " #deleteWorkModal>*", "");
            $("#addSubWorkModal").load(location.href + " #addSubWorkModal>*", "");
            
        }
    })
})

// * Function to delete an update 
$(document).on('submit', '#deleteUpdateForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("mainId");
    $.ajax({
        type: 'POST',
        url: '/profile/details/delete/update',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $("#pageLoader").load("/profile/details/added/" + id);        
        }
    })
})

// * Open update Work Modal
$(document).on('click', '.updateWorkBut', function () {
    var idToUpdate = $(this).val();
    $('#idToUpdate').val(idToUpdate);
    $('#updateWorkModal').modal('show');
    
});

// * Function to save an update 
$(document).on('submit', '#updateWorkForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("main_id");
    $.ajax({
        type: 'POST',
        url: '/profile/details/update',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#updateWorkModal').modal('hide');
            $("#pageLoader").load("/profile/details/" + id);        
        }
    })
})

// * update Sub Work Modal
$(document).on('click', '.updateSubWorkBut', function () {
    var subIdToUpdate = $(this).val();
    $('#subIdToUpdate').val(subIdToUpdate);
    $('#updateSubWorkModal').modal('show');
    
});

// * Function to save an update on a sub work 
$(document).on('submit', '#updateSubWorkForm', function (f) {
    f.preventDefault();

    var data = new FormData(this);
    var id = data.get("mainId");
    $.ajax({
        type: 'POST',
        url: '/profile/details/update/sub',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#updateSubWorkModal').modal('hide');
            $("#pageLoader").load("/profile/details/" + id);        
        }
    })
})


// * Comply Sub Work Modal
$(document).on('click', '.complySubWorkBut', function () {
    var subIdToUpdate = $(this).val();
    $('#subIdToComply').val(subIdToUpdate);
    $('#complySubWorkModal').modal('show');
    
});

// * Function to save compliance on a sub work 
$(document).on('submit', '#complySubWorkForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("mainId");
    $.ajax({
        type: 'POST',
        url: '/profile/details/comply/sub',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#complySubWorkModal').modal('hide');
            $("#pageLoader").load("/profile/details/" + id);        
        }
    })
})

// * Function on clicking the comply work button
$(document).on('click', '.complyWorkBut', function () {
    var IdToUpdate = $(this).val();
    $('#IdToComply').val(IdToUpdate);
    $('#complyWorkModal').modal('show');
});

// * Function to save compliance on a sub work 
$(document).on('submit', '#complyWorkForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var main_id = data.get("main_id");
    var id = data.get("complyId");
    $.ajax({
        type: 'POST',
        url: '/profile/details/comply',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#complyWorkModal').modal('hide');
            if (id == 0){
                window.location.href = "/profile";  
            }else{
                $("#pageLoader").load("/profile/details/" + main_id);    
            }
        }
    })
})

// * Function on the work approve button
$(document).on('click', '.approveBut', function () {
    $('#confirmWorkModal').modal('show');
});

// * Confirm Work Compliance
$(document).on('click', '#confCompliance', function () {
    var id = $(this).val();   
    $.ajax({
        type: "GET",
        url: "/profile/details/work/approve?id=" + id,
        success: function (response) {
        window.location.href = "/profile";  
        }
    })
});

// * Return Work Compliance
$(document).on('click', '#returnCompliance', function () {
    var id = $(this).val();   
    $.ajax({
        type: "GET",
        url: "/profile/details/work/return?id=" + id,
        success: function (response) {
        window.location.href = "/profile";  
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

$(document).on('change', '#selectAddedUpdateView', function () {
    var id = $(this).val();
    var mainId = $('#main_id').val();
    var viewedFrom = $('#viewedFrom').val();
        $.ajax({
        type: "GET",
        url: "/"+viewedFrom+"/details/added/sub/"+mainId+"/"+id,
        success: function (response) {
            $("#updateCol").html(response);
        }
    })
});

// * Function for viewing added work details
$(document).on('click', '.editUpdateBut', function () {
    var id = $(this).val();
    $.ajax({
            type: "GET",
            url: "/profile/update/edit?id="+id,
            success: function (response) {
                $("#editUpdateDiv").html(response);
                $('#editUpdateModal').modal('show');
            }
        })
});

// * Function to save compliance on a sub work 
$(document).on('submit', '#updateWorkUpdateForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var main_id = data.get("main_id");
    var id = data.get("complyId");
    $.ajax({
        type: 'POST',
        url: '/profile/update/edit/save',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#editUpdateModal').modal('hide');
            if (id == 0){
                window.location.href = "/profile";  
            }else{
                $("#pageLoader").load("/profile/details/" + main_id);    
            }
        }
    })
})