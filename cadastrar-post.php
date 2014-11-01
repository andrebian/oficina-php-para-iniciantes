<?php include './templates/cabecalho.php'; ?>
<?php include './templates/menu.php'; ?>

<?php

    if( isset($_POST) ) {
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        $conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_SANITIZE_STRING);
    }

?>

Informe os dados para o novo post
<br /><br />

<form method="post">
    <label>Título</label>
    <br />
    <input type="text" name="titulo">
    <br /><br />
    <label>Conteúdo</label>
    <br />
    <textarea name="conteudo"  cols="50" rows="10"></textarea>
    <br /><br />
    
    <input type="submit" value="Cadastrar">
    
</form>

<?php include 'templates/rodape.php'; ?>