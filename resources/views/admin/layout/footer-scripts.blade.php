<style>
    .form-select {
        padding: 0 !important;
    }

    .selectize-dropdown .selected {
        background-color: #e30016;
        color: #fff;
    }

    .selectize-control.multi .selectize-input [data-value] {
        background-image: linear-gradient(#e30016, #e30016);
        color: #fff;

    }

    .selectize-control.multi .selectize-input>div {
        border: 0;
    }

    .selectize-control.plugin-remove_button .item .remove {
        border-left: 1px solid white;
    }
</style>
<script>
    const CSRF_TOKEN = "{{ csrf_token() }}"
</script>

<script>
    $('.cancelModel').click(function() {
        $(this).closest('.modal').modal('hide');
    })

    $('.select').selectize({
        plugins: ["remove_button"]
    });
</script>

@if(session('error'))
<script>
    swal({
        text: "{{ session('error') }}",
        icon: 'error',
        timer: 3000,
        buttons: false,
    })
</script>
@endif

@if(session('success'))
<script>
    swal({
        text: "{{ session('success') }}",
        icon: 'success',
        timer: 3000,
        buttons: false,
    })
</script>
@endif


@if(!empty($title))
<script>
    $(document).delegate(".deleteItemRow", "click", function() {
        const row = $(this).closest('tr');
        const target = $(this).data('target');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this {{ $title }}!",
            icon: "warning",
            buttons: [
                'No, cancel it!',
                'Yes, I am sure!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    type: 'delete',
                    url: target,
                    success: function(data) {
                        if (data.status == true) {
                            row.remove();
                            swal({
                                text: data.message,
                                icon: "success",
                                timer: 2000
                            }).then(function(isConfirm) {});
                        } else {
                            swal({
                                text: data.message,
                                icon: "info",
                            })
                        }
                    }
                });
            } else {
                swal("Cancelled", "{{ $title }} is safe :)", "info");
            }
        })
    })
</script>
@endif

<script>
    $("table").delegate(".toggleShowStatus", "click", function() {
        const target = $(this).data('target');
        const type   = $(this).data('type');
        // console.log({type, target})
        $.ajax({
            type: 'POST',
            url: target,
            data: {type},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {}
        });
    });
</script>