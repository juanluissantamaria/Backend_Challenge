<?php
namespace Crimsoncircle\Controller;

use Crimsoncircle\Model\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController
{
    public function addComment(Request $request): Response
    {
        $comment = new Comment();
        $post_id = $request->request->get('post_id') != NULL ? $request->request->get('post_id') : '';
        $content = $request->request->get('content') != NULL ? $request->request->get('content') : '';
        $author = $request->request->get('author') != NULL ? $request->request->get('author') : '';
        
        if ($comment->validNewComment($post_id, $content, $author)) {
            $respuesta = $comment->add($post_id, $content, $author);
            return new Response( json_encode( $respuesta));
        }

        return new Response( json_encode( array('erorr' => true, 'mensaje' => 'Alguno de los datos esta vacio, verificalos e intenta nuevamente.' )));
    }

    public function getDeleteCommentId(Request $request, string $id = NULL): Response
    {
        $comment = new Comment();
        if($request->server->get('REQUEST_METHOD') == 'DELETE'){
            return new Response( json_encode( $comment->deleteCommentId($id)));
        }else{
            return new Response( json_encode( $comment->getCommentId($id)));
        }
    }

    public function getCommentsPostId(Request $request, string $pos_id = NULL): Response
    {
        $comment = new Comment();
        $pagina = $request->query->get('page');
        return new Response( json_encode( $comment->getCommensPostId($pos_id, $pagina)));
    }
    
}