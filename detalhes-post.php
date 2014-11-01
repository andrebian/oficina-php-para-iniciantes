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
        
        if( isset($_POST['comentario']) ) {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_STRING);
            
            if( !empty($nome) && !empty($email) && !empty($comentario) ) {
                if( $commentModel->salva($nome, $email, $comentario, $postId) ) { ?>
                    <script>
                        alert("Seu comentário foi enviado com sucesso!");
                        window.location.href="/blog/detalhes-post.php?id=<?php echo $postId; ?>";
                    </script>
                <?php 
                } else { ?>
                    <strong style="color: #f00;">Não foi possível cadastrar seu comentário</strong>
                <?php
                }
            } else { ?>
                <strong style="color: #f00;">Por favor preencha todos os campos</strong>
            <?php
            }
        }
        
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
            <hr>
        <?php endforeach; ?>
    <?php else : ?>
        Ainda não existem comentários
    <?php endif; ?>
        
    <br />
    <br />
    Deixe seu comentário:
    <br /><br />
    
    <form method="post">
        <label>Nome</label>
        <br />
        <input type="text" name="nome">
        <br /><br />
        <label>Email</label>
        <br />
        <input type="text" name="email">
        <br /><br />
        <label>Seu comentário</label>
        <br />
        <textarea name="comentario" cols="30" rows="5"></textarea>
        <br /><br />
        <input type="submit" value="Enviar comentário">
        <br />
        * Todos os campos são de preenchimento obrigatórios
    </form>

<?php include './templates/rodape.php'; ?>