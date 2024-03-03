// * Add Vehicle modal
$(document).on('click', '#addVehicleBut', function () {
    $('#addVehicleModal').modal('show');
});

// * Function to save Add Vehicle 
$(document).on('submit', '#addVehicleForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type: 'POST',
        url: '/section/vehicle/add',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#addVehicleModal').modal('hide');
            window.location.href = "/section/vehicle";  
        }
    })
})

// * Function for viewing work details
$(document).on('click', '.viewVehicleBut', function () {
    var id = $(this).val();
    $.ajax({
            type: "GET",
            url: "/section/vehicle/details/"+id,
            success: function (response) {
                $("#vehicleDetailDiv").html(response);
            }
        })
});

// * Function for viewing added work details
$(document).on('click', '.updateStatusBut', function () {
    var id = $(this).val();
    $.ajax({
            type: "GET",
            url: "/profile/update/edit?id="+id,
            success: function (response) {
                $('#updateVehicleStatusModal').modal('show');
            }
        })
});

// * Function to save compliance on a sub work 
$(document).on('submit', '#updateVehicleStatusForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("vehicleId");
    $.ajax({
        type: 'POST',
        url: '/section/vehicle/update/status',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#updateVehicleStatusModal').modal('hide');
            $("#vehicleListDiv").load(location.href + " #vehicleListDiv>*", "");
            $("#vehicleDetailDiv").load("/section/vehicle/details/" + id);    
        }
    })
})

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

// * Function for viewing added work details
$(document).on('click', '.editVehicleButton', function () {
    $('#editVehicleModal').modal('show');
});

// * Function for viewing added work details
$(document).on('click', '.deleteVehicleButton', function () {
    $('#deleteVehicleModal').modal('show');
});

// * Function for viewing added work details
$(document).on('click', '.addVehicleWorkBut', function () {
    $('#addVehicleWorkModal').modal('show');
});


// * Function for viewing added work details
$(document).on('click', '.renewVehicleBut', function () {
    $('#renewVehicleModal').modal('show');
});


// * Function for viewing added work details
$(document).on('click', '.confDeleteVehicle', function () {
    var id = $(this).val();
    $('#deleteVehicleModal').modal('hide');
    $.ajax({
        type: 'GET',
        url: '/section/vehicle/delete?id='+id,
        success: function (response) {
            window.location.href = "/section/vehicle";  
        }
    })
});

// * Function to save Add Vehicle 
$(document).on('submit', '#updateVehicleForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("id");

    $.ajax({
        type: 'POST',
        url: '/section/vehicle/update/details',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#editVehicleModal').modal('hide');
            $("#vehicleDetailDiv").load("/section/vehicle/details/" + id);       
        }
    })
})

// * Function to save Add Vehicle 
$(document).on('submit', '#addVehicleWorkForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("id");

    $.ajax({
        type: 'POST',
        url: '/section/vehicle/addwork',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#addVehicleWorkModal').modal('hide');
            $("#vehicleDetailDiv").load("/section/vehicle/details/" + id);       
        }
    })
})

// * Function to save Add Vehicle 
$(document).on('submit', '#renewVehicleForm', function (f) {
    f.preventDefault();
    var data = new FormData(this);
    var id = data.get("id");

    $.ajax({
        type: 'POST',
        url: '/section/vehicle/renew',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#renewVehicleModal').modal('hide');
            $("#vehicleDetailDiv").load("/section/vehicle/details/" + id);       
        }
    })
})



// * Check all boxes (MISC)
$(document).on('click', '#checkall', function () {
    $("#addVehicleWorkForm input[type='checkbox'").prop('checked', this.checked);
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