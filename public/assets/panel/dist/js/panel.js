// datatable
$(function () {
    //Initialize boostrap switch elements
    $("input[data-bootstrap-switch]").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    $('.custom-data-table').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });

    $('.confirm-button').click(function () {
        const msg = $(this).attr('data-msg');
        const href = $(this).attr('data-href');
        if (msg == undefined) {
            msg = '';
        }
        if (href == undefined) {
            href = '#';
        }
        $('#modal-confirm-msg').html(msg);
        $('#modal-confirm-btn').attr('href', href);
    });
    //Initialize select2 elements
    $('.select2').select2();
    //Initialize select2 elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
    //Date range picker
    $('.date-picker').daterangepicker({
        format: 'DD/MM/YYYY'
    });
    //Date range picker
    $('.date-range-picker').daterangepicker();
    //Date range picker with time picker
    $('.datetime-range-picker').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'DD/MM/YYYY hh:mm A'
        }
    });
    //Timepicker
    $('.time-picker').daterangepicker({
        format: 'LT'
    });
    // Summernote
    $('.summernote').summernote({
        height: 200,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['insert', ['ltr', 'rtl']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']],
        ], callbacks: {
            onKeydown: function (e) {
                let html = $(this).val();
                html.replace('<p>', '').replace('</p>', '');
                $(this).val(html);
                console.log(html)
            }
        }
    });
});

/**
 * slugify text
 * @param {*} source 
 * @param {*} target 
 */
function slugify_text(source, target) {
    $('#' + target).slugify(source);
}
