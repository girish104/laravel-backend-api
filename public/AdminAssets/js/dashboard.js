$("#admin_user_form").parsley();
$("#admin_user_form").on("submit", function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    if ($("#admin_user_form").parsley().isValid()) {
        $.ajax({
            url: AdminbaseURL + "/user/update",
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
                    }).then(function() {
                        window.location.href = AdminbaseURL+'/user/list';
                      })
                } else {
                    swal({
                        text: data.message,
                        icon: "info",
                    });
                }


            },
        });
    }
});