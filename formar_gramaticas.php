<?php
if (!isset($_POST['data'])) {
    header('Location: index.html');
}

$dadosNoTerminais = $_POST['data']['NoTerminais'];
$dadosTerminais = $_POST['data']['Terminais'];
$todasVariaveis = array_merge($dadosNoTerminais, $dadosTerminais);
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <script src="js/jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <script>

            var boxClicado = {};
            $(function() {
                $('.variaveis').click(function() {
                    var objeto = getObjetoClicado();
                    var valorAntigo = $(objeto).val();
                    var valor = $(this).val();
                    var valorNovo = valorAntigo + valor; // pega o valor que ja tinha no input e concatena com o valor clicado
                    $(objeto).val(valorNovo);
                })

                $('.botaoLimpar').click(function() {
                    var objeto = getObjetoClicado();
                    $(objeto).val('');
                })

                $('#AdicionarGramatica').click(function() {
                    var html = '<input readonly class="box" name="data[GramaticaVariavel][Esquerdo][]" type="text" />';
                    html += ' => ';
                    html += '<input readonly class="box" name="data[GramaticaVariavel][Direito][]" type="text" /> ';
                    html += '<br /><br />';
                    $(html).insertBefore($(this));
                })

            });

            $(document).on('click', '.box', function() {
                $('.box').removeClass('boxClicado'); // remove background-color do outro box
                setObjetoClicado($(this));
                $(this).addClass('boxClicado');

            });

            function setObjetoClicado(objeto) {
                boxClicado = objeto;
            }

            function getObjetoClicado() {
                if (jQuery.isEmptyObject(boxClicado)) {
                    alert('Clique em algum box primeiro!');
                    return false;
                }

                return boxClicado;
            }

        </script>
    </head>
    <body>
        <h1>Forme as gramáticas</h1>
        <p>Clique primeiro em um box e depois em alguma das variáveis abaixo.<br />
            Obs: O símbolo inicial será o valor do 1º box.
        </p>
        <form action="resultados.php" method="post">

            <?php
            echo 'NT: ';
            foreach ($dadosNoTerminais as $noTerminal) {
                echo '<input class="variaveis" readonly type="button" value="' . $noTerminal . '">';
            }

            echo '<br /><br />';

            echo 'T: ';
            foreach ($dadosTerminais as $Terminal) {
                echo '<input class="variaveis" readonly type="button" value="' . $Terminal . '">';
            }

            echo '<br /><br />';
            echo '<input class="variaveis" readonly type="button" value="X">';
            echo '<input class="variaveis" readonly type="button" value="|">';
            ?>

            <br /><br /><br />
            <input readonly class="box" name="data[GramaticaVariavel][Esquerdo][]" type="text" />
            => 
            <input readonly class="box" name="data[GramaticaVariavel][Direito][]" type="text" /> 

            <br /><br />
            <input id="AdicionarGramatica" type="button" value="Adicionar mais uma Gramatica">
            <input class="botaoLimpar" value="Limpar Box Selecionado" type="button" />
            <br /><br /><br /><br /><br />
            <?php
            foreach ($dadosTerminais as $Terminal) {
                echo '<input type="hidden" name="data[Terminais][]" value="' . $Terminal . '" />';
            }
            ?>    
            <input type="submit">
        </form>
    </body>
</html>




