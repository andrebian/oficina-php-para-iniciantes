<?php include './templates/cabecalho.php'; ?>
<?php include './templates/menu.php'; ?>
<?php 
    require 'model/Post.php'; 
    require 'model/Comment.php';
        
    $postModel = new Post();
    $commentModel = new Comment();
    
    $posts = $postModel->listarPosts();

    if( $posts ) {
        foreach($posts as $post) {
            $postModel->setId($post['id']);
            $commentModel->setPostId($post['id']);
            
            $quantidadeComentarios = $commentModel->quantidadeComentarios();
            
            echo '<a href="'.$postModel->obterLink().'"><strong>'.$post['titulo'].'</strong></a>';
            echo '<br />';
            echo 'Postado em: ' . date('d/m/Y', strtotime($post['criado'])) . ' ';
            echo 'às ' . date('H:i:s', strtotime($post['criado'])); 
            echo ' - (' . $quantidadeComentarios . ') comentários';
            echo '<br />';  
            echo $postModel->resumo($post['conteudo'], 40);
            echo '<br /><br /><hr>';
        }
    }  
?>    

<?php include './templates/rodape.php'; ?>