<?php include './templates/cabecalho.php'; ?>
<?php include './templates/menu.php'; ?>

    <?php 
        require 'model/Post.php'; 
        $postModel = new Post();

        $postId = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $postModel->setId($postId);

        if( $postId == 0 ) {
            header('Location: /blog');
        }

        $detalhesDoPost = $postModel->detalhes();
    ?>
    <h1><?php echo $detalhesDoPost['titulo']; ?></h1>
    Criado em: <?php echo date('d/m/Y H:i:s', strtotime($detalhesDoPost['criado'])); ?>
    <br />
    Última atualização: <?php echo date('d/m/Y H:i:s', strtotime($detalhesDoPost['atualizado'])); ?>
    <br /><br />
    <?php echo $detalhesDoPost['conteudo']; ?>
    <br /><br />
    <a href="<?php echo $postModel->obterLink(true); ?>">Editar</a> | 
    <a href="<?php echo $postModel->linkRemover(); ?>" 
       onclick="return confirm('Deseja realmente remover este post?');">Remover</a>

<?php include './templates/rodape.php'; ?>