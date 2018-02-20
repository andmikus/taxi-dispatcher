{!! $autocompleteHelper->renderJavascript($origAutocomplete); !!}
{!! $autocompleteHelper->renderJavascript($destAutocomplete); !!}
{!! $dataTable->scripts() !!}

<script type="text/javascript">
    $('#order-form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $('.address-input').each(function() {
        var target = $(this).attr('id');
        $('#'+target).change(function() {
            if ($(this).val() == '') {
                $(this).removeClass('is-valid');
                $('#'+target+'-location-feedback').html('');
                $('#'+target+'-location').val('');
            }
        });
    });

</script>