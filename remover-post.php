<?php

require 'model/Post.php';
$postModel = new Post();

$postId = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$postModel->setId($postId);
if( $postModel->deleta() ) {
    echo '<script>alert("Post removido com sucesso!"); window.location.href="/blog"</script>';
}