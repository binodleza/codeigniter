var app = {

    getAddressFromLocationForUpdate: function (location, fillAddress, num) {
        if ($.trim(location) != "") {
            if (fillAddress == 0)
                $('#searchAddress').val("LOCATING...");
            else {
                $('.global-loader').show();
            }
            $.ajax({
                type: 'GET',
                url: baseUrl + 'listings/get-address-in-update',
                data: {
                    'location': location,
                    'fillAddress': fillAddress
                },
                dataType: 'json',
                success: function (res) {
                    if (res.status == 200) {
                        if (res.addressStr != "") {
                            $('#searchAddress' + num).val(res.addressStr);
                        }

                    }
                    $('.global-loader').hide();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                }
            });
        }
    },



    changeStatus: function (url, id) {
        $.ajax({
            type: "GET",
            url: baseUrl + url,
            data: {
                "id": id
            },
            success: function (res) {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $(".global-loader").hide();
                alert(jqXHR.responseText);
            }
        });
    },

    cancelTrainerBookingSlot: function (id, slot_id) {
        swal({
            title: "Are you sure you want to cancel this booking slot?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }, function (isConfirm) {
            if (isConfirm) {
                //$(".global-loader").show();
                $.ajax({
                    type: "POST",
                    url: baseUrl + 'payments/cancel-trainer-slot',
                    data: {
                        "id": id,
                        "slot_id": slot_id,
                    },
                }).done(function (res) {
                    $(".global-loader").hide();
                    var obj = $.parseJSON(res);
                    if (obj.status == 200) {
                        location.reload();
                        /*swal("", obj.msg, 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 3000)*/
                    } else if (obj.status == 201) {
                        swal("", obj.msg, 'warning');
                    } else {
                        swal("", obj.msg, 'error');
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    $(".global-loader").hide();
                    console.log(jqXHR.responseText);
                }).always(function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                })
            }
        });
    },


};


$('.onlyNumber').keyup(function (event) {
    var valueNumber = this.value;
    if (isNaN(valueNumber)) {
        $(this).val("");
    }
});
setTimeout(function(){ $('.hideSomeTime').hide(2000) }, 3000);




