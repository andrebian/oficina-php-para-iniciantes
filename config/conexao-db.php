<?php

function abreConexao()
{
    mysql_connect('localhost', 'root', 'root') or die(mysql_error());
    mysql_select_db('blog') or die(mysql_error());
}

function fechaConexao() 
{
    mysql_close();
}