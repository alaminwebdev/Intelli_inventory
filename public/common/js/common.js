
$.widget.bridge('uibutton', $.ui.button)

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('.select2').select2();
    $('#sb-data-table').DataTable({
        "pageLength": 25
    });

    $('#product-data-table').DataTable({
        "pageLength": 25,
        "columnDefs": [
            { "orderable": false, "targets": "_all" } // Disable ordering on the first column
        ]
    });

    $('.singledatepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        // drops: "up",
        autoApply: true,
        locale: {
            format: 'DD-MM-YYYY',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            firstDay: 0
        },
        minDate: '01/01/1930',
    },
        function (start) {
            this.element.val(start.format('DD-MM-YYYY'));
            this.element.parent().parent().removeClass('has-error');
        },
        function (chosen_date) {
            this.element.val(chosen_date.format('DD-MM-YYYY'));
        });

    $('.singledatepicker').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });

    $('.singledatefromtoday').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        // drops: "up",
        autoApply: true,
        locale: {
            format: 'DD-MM-YYYY',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            firstDay: 0
        },
        minDate: moment(), // Set minimum date to today
    },
        function (start) {
            this.element.val(start.format('DD-MM-YYYY'));
            this.element.parent().parent().removeClass('has-error');
        },
        function (chosen_date) {
            this.element.val(chosen_date.format('DD-MM-YYYY'));
        });

    $('.singledatefromtoday').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });

    $(document).on('click', '.destroy', function () {
        var thisBtn = $(this);
        var url = $(thisBtn).data('route');
        var id = $(thisBtn).data('id');

        Swal.fire({
            icon: 'error',
            iconHtml: '<i class="fa fa-trash"></i>',
            title: 'মুছে ফেলুন',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ, এটি মুছুন!',
            cancelButtonText: 'না, বাতিল!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return $.ajax({
                    'url': url,
                    'type': 'POST',
                    'data': {
                        _token: $('[name=csrf-token]').attr('content'),
                        id: id
                    },
                }).then(response => {
                    if (response.status != 'success') {
                        throw new Error(response.message)
                    }
                    return response;
                })
                    .catch(error => {
                        Swal.showValidationMessage(error.message ? error.message : error.responseJSON.message)
                    })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: "success",
                    title: 'সফলভাবে মুছে ফেলা হয়েছে',
                });
                $(thisBtn).parents('tr').hide('');

            }
        });
    });
});