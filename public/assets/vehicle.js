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
            $("#vehicleDetailDiv").html(response);

            
        }
    })
})

// * Function for viewing work details
$(document).on('click', '.viewVehicleBut', function () {
    var id = $(this).val();
    alert (id);
    $.ajax({
            type: "GET",
            url: "/section/vehicle/details/"+id,
            success: function (response) {
                $("#vehicleDetailDiv").html(response);
            }
        })
});