<?php

require dirname(__DIR__) . '/config/conexao-db.php';

class Post
{
    
    private $id = 0;
    
    public function __construct() 
    {
        abreConexao();
    }
    
    public function __destruct() 
    {
        fechaConexao();
    }
    
    public function salva($titulo, $conteudo, $id = 0)
    {
        $registroSalvo = false;
        $criado = date('Y-m-d H:i:s');
        $atualizado = $criado;
        
        $sql = "INSERT INTO posts (titulo, conteudo, criado, atualizado) VALUES ";
        $sql .= "('{$titulo}', '{$conteudo}', '{$criado}', '{$atualizado}')";
        
        if( $id > 0 ) {
            $sql = "UPDATE posts SET titulo='{$titulo}', conteudo='{$conteudo}', ";
            $sql .= "atualizado='{$atualizado}' WHERE id={$id}";
        }
        
        mysql_query($sql);
        if( mysql_affected_rows() && !mysql_error() ) {
            $registroSalvo = true;
        }
        
        return $registroSalvo;
    }
    
    public function listarPosts()
    {        
        $posts = array();
        
        $res = mysql_query("SELECT * FROM posts ORDER By criado DESC");
        
        if( mysql_affected_rows() && !mysql_error() ) {
            while($fila = mysql_fetch_assoc($res)) {
                $posts[] = $fila;
            }
        }
        
        return $posts;
    }
    
    public function resumo($conteudo, $palavras = 30)
    {
        $resumo = "";
        
        $conteudo = explode(" ", $conteudo);
        for($cont = 0; $cont <= $palavras; $cont++) {
            $resumo .= $conteudo[$cont] . " ";
        }
        
        if( count($conteudo) >= $palavras ) {
            $resumo .= ' ... <a href="'.$this->obterLink().'">[continue lendo]</a>';
        }
        
        return $resumo;
    }
    
    public function obterLink($editar = false)
    {
        if( $editar ) {
            return '/blog/cadastrar-post.php?id=' . $this->id;
        }
        return '/blog/detalhes-post.php?id=' . $this->id;
    }
    
    public function linkRemover()
    {
        return '/blog/remover-post.php?id=' . $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function detalhes()
    {
        $detalhesDoPost = array();
        
        if( $this->id > 0 ) {
            
            $res = mysql_query("SELECT * FROM posts WHERE id=" . $this->id);
            
            if( mysql_affected_rows() && !mysql_error()) {
                while($detalhes = mysql_fetch_assoc($res)) {
                    $detalhesDoPost = $detalhes;
                }
            }
        }
        
        return $detalhesDoPost;
    }
    
    public function deleta()
    {
        $removido = false;
        
        if( $this->id > 0 ) {
            
            mysql_query("DELETE FROM posts WHERE id=" . $this->id);
            if( mysql_affected_rows() && !mysql_error() ) {
                $removido = true;
            }
        }
        
        return $removido;
    }
    
}
