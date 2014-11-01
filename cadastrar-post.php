<?php include './templates/cabecalho.php'; ?>
<?php include './templates/menu.php'; ?>

<?php

    $postId = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) : 0;
    $detalhes = array(
        'id' => 0,
        'titulo' => '',
        'conteudo' => ''
    );
    
    require './model/Post.php';
        
    $postModel = new Post();
    if( $postId > 0 ) {
        $postModel->setId($postId);
        $detalhes = $postModel->detalhes();
    }

    if( isset($_POST['titulo']) ) {
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        $conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_SANITIZE_STRING);
        
        if( $postModel->salva($titulo, $conteudo, $postId) ) {
            echo '<strong style="color: #090">Dados do post salvos com sucesso</strong>';
        } else {
            echo '<strong style="color: #f00">Não foi possível gravar os dados do post</strong>';
        }
        echo '<br /><br />';
    }

?>

Informe os dados para o novo post
<br /><br />

<form method="post">
    <label>Título</label>
    <br />
    <input type="text" name="titulo" value="<?php echo $detalhes['titulo']; ?>">
    <br /><br />
    <label>Conteúdo</label>
    <br />
    <textarea name="conteudo"  cols="50" rows="10"><?php echo $detalhes['conteudo']; ?></textarea>
    <br /><br />
    
    <input type="submit" value="Gravar">
    
</form>

<?php include 'templates/rodape.php'; ?>