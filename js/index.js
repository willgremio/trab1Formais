$(function() {
    $("#NoTerminais, #Terminais").keyup(function() {
        var numero = $(this).val();
        if ($.isNumeric(numero)) {
            var html = 'Informe o símbolo de cada um:<br />';
            var tipo = $(this).data('tipo');
            var classe = 'terminais';
            if (tipo == 'NoTerminais') {
                classe = 'no_terminais';
            }

            for (var i = 1; i <= numero; i++) {
                html += i + ': <input maxlength="1" type="text" class="' + classe + '" name="data[' + tipo + '][]" /><br />';
            }

            $('#Inputs' + tipo).html(html);
        }
    })
});


$(document).on('keyup', '.no_terminais', function() {
    var variavel = $(this).val();
    $(this).val(variavel.toUpperCase());
})