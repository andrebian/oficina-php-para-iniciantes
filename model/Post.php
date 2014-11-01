<?php

require dirname(__DIR__) . '/config/conexao-db.php';

class Post
{
    public function salva($titulo, $conteudo, $id = null)
    {
        abreConexao();
        
        $registroSalvo = false;
        $criado = date('Y-m-d H:i:s');
        $atualizado = $criado;
        
        $sql = "INSERT INTO posts (titulo, conteudo, criado, atualizado) VALUES ";
        $sql .= "('{$titulo}', '{$conteudo}', '{$criado}', '{$atualizado}')";
        
        if( !empty($id) && is_int($id) ) {
            $sql = "UPDATE posts SET titulo='{$titulo}', conteudo='{$conteudo}', ";
            $sql .= "atualizado='{$atualizado}' WHERE id={$id}";
        }
        
        mysql_query($sql);
        if( mysql_affected_rows() && !mysql_error() ) {
            $registroSalvo = true;
        }
        
        fechaConexao();
        return $registroSalvo;
    }
}
