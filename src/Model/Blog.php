<?php

namespace Crimsoncircle\Model;

include __DIR__.'/../bd/Conexion.php';

class Blog
{
    private $bd = false;
    public function __construct(){
        $this->bd = openConection();
    }

    public function add($title, $content, $author): array
    {
        $created_at = date("Y-m-d H:i:s");
        $slug = $this->generateSlug($title);

        $add = transaction($this->bd, "INSERT INTO blog (title, content, author, slug, created_at) VALUES ('$title', '$content', '$author', '$slug', '$created_at')");
        if($add){
            $id_blog = 0;
            $ultimo_id = consultation($this->bd, "SELECT MAX(id) as id_blog FROM blog WHERE slug = '$slug'");
            if($ultimo_id)
                $id_blog = $ultimo_id[0]['id_blog'];
            $datos_blog = consultation($this->bd, "SELECT title, content, author, slug FROM blog WHERE id = $id_blog");
            if($datos_blog){
                return $datos_blog;
            }
        }
        return array('erorr' => true, 'mensaje' => 'No fue posible añadir el blog.' );
    }

    public function validNewBlog($title = "", $content = "", $author = "") : bool
    {
        if(empty($title) || empty($content) || empty($author))
            return false;
        return true;
    }

    public function getBlogSlug($slug = NULL) : array
    {
        if($slug == NULL)
            return array('erorr' => true, 'mensaje' => 'Sin coincidencias.' );
        
        $datos_blog = consultation($this->bd, "SELECT id, title, content, author, slug, created_at FROM blog WHERE slug = '/$slug'");
        if($datos_blog)
            return $datos_blog;
        
        return array('erorr' => true, 'mensaje' => 'Sin coincidencias.' );
    }

    public function deleteBlogSlug($slug = NULL) : array
    {
        if($slug == NULL)
            return array('erorr' => true, 'mensaje' => 'No se especifico el blog.' );
        
        //$bd = new Conexion();
        $delete_blog = transaction($this->bd, "DELETE FROM blog WHERE slug = '$slug'");
        if($delete_blog)
            return array('success' => true, 'mensaje' => 'Blog eliminado correctamente.');
        
        return array('erorr' => true, 'mensaje' => 'No fue posible eliminar el blog.' );
    }

    function generateSlug($title) : string
    {   
        return "/".utf8_encode(strtr(utf8_decode($title), utf8_decode("'ÁÉÍÓÚÀÈÌÒÙáéíóúäëïöüàèìòùABCDEFGHIJKLMNOPQRSTUVXYZäëïöüÄËÏÖÜ /"), "_aeiouaeiouaeiouaeiouaeiouabcdefghijklmnopqrstuvxyzaeiouaeiou__"));
    }
}