
$("#client_create").parsley();
$("#client_create").on("submit", function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    if ($("#client_create").parsley().isValid()) {
        $.ajax({
            url: AdminbaseURL + "/product/store",
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
                                AdminbaseURL + "/product/list"
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
                data: 'type',
                name: 'type',
                searchable: true
            }, {
                data: 'address_1',
                name: 'address_1',
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
                data: 'billing_email_id',
                name: 'billing_email_id',
                searchable: true
            }, {
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
                `;
                },
                searchable: false
            }


        ],

    });
}


$("#client_Update").parsley();
$("#client_Update").on("submit", function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    if ($("#client_Update").parsley().isValid()) {
        $.ajax({
            url: AdminbaseURL + "/product/update",
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
                            location.reload();
                            // $(location).attr(
                            //     "href",
                            //     AdminbaseURL + "/product/list/"
                            // );
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



$(document).on("click", ".document_table  .deleterow", function (event) {
    event.preventDefault();
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
            var doc_id = $(this).attr('data-id');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            if (doc_id && doc_id != '') {
                $.ajax({
                    url: AdminbaseURL  + "/product/delete",
                    method: "POST",
                    data: { doc_id: doc_id },
                    beforeSend: function () {
                    },
                    success: function (data) {
                        if (data.status == true) {
                            $('#my_table').DataTable().ajax.reload();
                            swal({
                                title: "",
                                text: data.message,
                                icon: "success",
                            });

                        } else {
                            swal({
                                title: "",
                                text: 'Something went wrong!',
                                icon: "error",
                            });

                        }

                    }
                });
            }

        } else {

        }
    });
});
