<?php

require_once dirname(__DIR__) . '/config/conexao-db.php';

class Comment
{
    private $postId;
    
    public function __construct() 
    {
        abreConexao();
    }
    
    public function __destruct() 
    {
        fechaConexao();
    }
    
    public function setPostId($postId)
    {
        $this->postId = $postId;
    }
    
    public function obterComentarios()
    {
        $comentarios = array();
        
        $sql = "SELECT * FROM comentarios WHERE post_id=" . $this->postId;
        $res = mysql_query($sql) or die(mysql_error());
        
        if( mysql_affected_rows() && !mysql_error() ) {
            while($comentario = mysql_fetch_assoc($res)) {
                $comentarios[] = $comentario;
            }
        }
        
        return $comentarios;
    }
    
    public function salva($nome, $email, $comentario, $postId)
    {
        $data = date('Y-m-d H:i:s');
        $sql = "INSERT INTO comentarios (post_id, nome, email, comentario, enviado) VALUES ";
        $sql .= "({$postId}, '{$nome}', '{$email}', '{$comentario}', '{$data}')";
        
        mysql_query($sql);
        
        if( mysql_affected_rows() && !mysql_error() ) {
            return true;
        }
        return false;
    }
    
}