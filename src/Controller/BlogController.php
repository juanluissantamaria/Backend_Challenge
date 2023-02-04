<?php
namespace Crimsoncircle\Controller;

use Crimsoncircle\Model\Blog;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController
{
    public function addBlog(Request $request): Response
    {
        $blog = new Blog();
        $title = $request->request->get('title') != NULL ? $request->request->get('title') : '';
        $content = $request->request->get('content') != NULL ? $request->request->get('content') : '';
        $author = $request->request->get('author') != NULL ? $request->request->get('author') : '';
        
        if ($blog->validNewBlog($title, $content, $author)) {
            $respuesta = $blog->add($title, $content, $author);
            return new Response( json_encode( $respuesta));
        }

        return new Response( json_encode( array('erorr' => true, 'mensaje' => 'Alguno de los datos esta vacio, verificalos e intenta nuevamente.' )));
    }

    public function getDelBlogSlug(Request $request, string $slug = NULL): Response
    {
        $blog = new Blog();
        if($request->server->get('REQUEST_METHOD') == 'DELETE'){
            return new Response( json_encode( $blog->deleteBlogSlug($slug)));
        }else{
            return new Response( json_encode( $blog->getBlogSlug($slug)) );
        }
    }
    
}