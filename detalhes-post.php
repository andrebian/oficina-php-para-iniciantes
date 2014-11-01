<?php include './templates/cabecalho.php'; ?>
<?php include './templates/menu.php'; ?>

    <?php 
        require 'model/Post.php'; 
        require 'model/Comment.php';
        
        $postModel = new Post();
        $commentModel = new Comment();

        $postId = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $postModel->setId($postId);

        if( $postId == 0 ) {
            header('Location: /blog');
        }

        $detalhesDoPost = $postModel->detalhes();
        
        $commentModel->setPostId($postId);
        $comentarios = $commentModel->obterComentarios();
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
    
    <br />
    <h4>Comentários deste post</h4>
    <?php if( $comentarios ) : ?>
        <?php foreach($comentarios as $comentario) : ?>
            Em <?php echo date('d/m/Y à\s H:i:s', strtotime($comentario['enviado'])); ?> 
            <?php echo $comentario['nome']; ?> disse:
            <br />
            <?php echo $comentario['comentario']; ?>
        <?php endforeach; ?>
    <?php else : ?>
        Ainda não existem comentários
    <?php endif; ?>
        
    <br />
    <br />
    Deixe seu comentário:
    <br />

<?php include './templates/rodape.php'; ?>