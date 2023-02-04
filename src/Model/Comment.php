<?php

namespace Crimsoncircle\Model;

include __DIR__.'/../bd/Conexion.php';

class Comment
{
    private $bd = false;
    public function __construct(){
        $this->bd = openConection();
    }

    public function add($post_id, $content, $author): array
    {
        $created_at = date("Y-m-d H:i:s");

        $add = transaction($this->bd, "INSERT INTO comment_blog (post_id, content, author, created_at) VALUES ($post_id, '$content', '$author', '$created_at')");
        if($add){
            $id_comment = 0;
            $ultimo_id = consultation($this->bd, "SELECT MAX(id) as id_comment FROM comment_blog WHERE post_id = $post_id");
            if($ultimo_id)
                $id_comment = $ultimo_id[0]['id_comment'];
            $datos_comment = consultation($this->bd, "SELECT post_id, content, author FROM comment_blog WHERE id = $id_comment");
            if($datos_comment){
                return $datos_comment;
            }
        }
        return array('erorr' => true, 'mensaje' => 'No fue posible añadir el comentario.' );
    }

    public function validNewComment($post_id = "", $content = "", $author = "") : bool
    {
        if(empty($post_id) || empty($content) || empty($author))
            return false;
        return true;
    }

    public function getCommentId($id = NULL) : array
    {
        if($id == NULL)
            return array('erorr' => true, 'mensaje' => 'Sin coincidencias.' );
        
        $datos_comment = consultation($this->bd, "SELECT id, post_id, content, author, created_at FROM comment_blog WHERE id = $id");
        if($datos_comment)
            return $datos_comment;
        
        return array('erorr' => true, 'mensaje' => 'Sin coincidencias.' );
    }

    public function getCommensPostId($post_id = NULL, $page = 1) : array
    {  
        if($post_id == NULL)
            return array('erorr' => true, 'mensaje' => 'Sin coicidencias para del blog.' );
        
        $registros = 10;
        $inicio = ($page - 1) * $registros;
        
        $datos_comment = consultation($this->bd, "SELECT id, post_id, content, author, created_at FROM comment_blog WHERE post_id = $post_id ORDER BY id DESC LIMIT $inicio, $registros");
        if($datos_comment)
            return $datos_comment;
        
        return array('erorr' => true, 'mensaje' => 'Sin coincidencias.' );
    }

    public function deleteCommentId($id = NULL) : array
    {
        if($id == NULL)
            return array('erorr' => true, 'mensaje' => 'No se especifico el comentario.' );
        
        $delete_blog = transaction($this->bd, "DELETE FROM comment_blog WHERE id = $id");
        if($delete_blog)
            return array('success' => true, 'mensaje' => 'Comentario eliminado correctamente.');
        
        return array('erorr' => true, 'mensaje' => 'No fue posible eliminar el comentario.' );
    }

    function generateSlug($title) : string
    {   
        return "/".utf8_encode(strtr(utf8_decode($title), utf8_decode("'ÁÉÍÓÚÀÈÌÒÙáéíóúäëïöüàèìòùABCDEFGHIJKLMNOPQRSTUVXYZäëïöüÄËÏÖÜ /"), "_aeiouaeiouaeiouaeiouaeiouabcdefghijklmnopqrstuvxyzaeiouaeiou__"));
    }
}