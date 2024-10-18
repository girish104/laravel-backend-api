
$("#service_create").parsley();
$("#service_create").on("submit", function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    if ($("#service_create").parsley().isValid()) {
        $.ajax({
            url: AdminbaseURL + "/service-provider/store",
            method: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".admin_loader").show();
            },
            success: function (data) {
                $(".admin_loader").hide();

                if (data.status == true) {
                    swal({
                        text: data.message,
                        icon: "success",
                    }).then(function (isConfirm) {
                        if (isConfirm) {
                            $(location).attr(
                                "href",
                                AdminbaseURL + "/service-provider/list/"
                            );
                        } 
                    });
                } else {
                    swal({
                        text: data.message,
                        icon: "info",
                    })
                }

            },
        });
    }
});



const service_provider_list = (url) => {
    $("#my_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: url,

        columns: [{
                "data": 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'company_name',
                name: 'company_name',
                searchable: true
            }, {
                data: 'deal_in',
                name: 'deal_in',
                searchable: true
            }, {
                data: 'address_1',
                name: 'address_1',
                searchable: true
            }, {
                data: 'coverage',
                name: 'coverage',
                searchable: true
            }, {
                data: 'category_id',
                name: 'category_id',
                searchable: true
            }, {
                data: 'service_provider_type',
                name: 'service_provider_type',
                searchable: true
            }, {
                data: 'contact_number',
                name: 'contact_number',
                searchable: true
            }, {
                data: 'contact_name',
                name: 'contact_name',
                searchable: true
            }, {
                data: 'alternate_contact_number',
                name: 'alternate_contact_number',
                searchable: true
            }, {
                data: 'official_email_id',
                name: 'official_email_id',
                searchable: true
            }, {
                data: 'costing_behaviour',
                name: 'costing_behaviour',
                searchable: true
            }, {
                data: 'shop_type',
                name: 'shop_type',
                searchable: true
            },  {
                data: 'status',
                name: 'status',
                searchable: true
            }, {
                data: 'updated_at',
                name: 'updated_at',
                searchable: true
            }, {
                "mRender": function(data, type, row) {
                    return `<a href="${row.route_show}" class="btn btn-primary  btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    
                    <a href="javascript:void(0)" class="btn btn-danger  btn-sm" onclick="deleteDoctor(${row.id})"><i class="fa fa-trash" aria-hidden="true"></i></a>`;
                },
                searchable: false
            }


        ],

    });
}

const deleteDoctor = (id)=>{
    swal({
        title: 'Are you sure ',
        text: "want to delete ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3f51b5',
        cancelButtonColor: '#ff4081',
        confirmButtonText: 'Great ',
        buttons: {
            cancel: {
                text: "Cancel",
                value: false,
                visible: true,
                className: "btn btn-danger",
                closeModal: true,
            },
            confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "btn btn-primary",
                closeModal: true
            }
        }
    }).then((willDelete) => {
        if (willDelete) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: AdminbaseURL + "/doctor/delete",
                data: { id: id }
            }).done(function(data) {
                if (data.status == true) {
                    swal({
                        text: data.message,
                        icon: "success",
                    }).then(function(isConfirm) {
                        if (isConfirm) {
                            location.reload();
                        }
                    });
                }else{
                    swal({
                        text: data.message,
                        icon: "error",
                    })
                }

            });

        } else {

        }
    });

}


$("#service_update").parsley();
$("#service_update").on("submit", function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    if ($("#service_update").parsley().isValid()) {
        $.ajax({
            url: AdminbaseURL + "/service-provider/update",
            method: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".admin_loader").show();
            },
            success: function (data) {
                $(".admin_loader").hide();

                if (data.status == true) {
                    swal({
                        text: data.message,
                        icon: "success",
                    }).then(function (isConfirm) {
                        if (isConfirm) {
                            $(location).attr(
                                "href",
                                AdminbaseURL + "/service-provider/list/"
                            );
                        } 
                    });
                } else {
                    swal({
                        text: data.message,
                        icon: "info",
                    })
                }


            },
        });
    }
});
