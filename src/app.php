<?php
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('leap_year', new Routing\Route('/backend_challenge/is_leap_year/{year}', [
    'year' => null,
    '_controller' => 'Crimsoncircle\Controller\LeapYearController::index',
]));

// Post Blog
$routes->add('add_blog_spot', new Routing\Route('/backend_challenge/blog', [
    '_controller' => 'Crimsoncircle\Controller\BlogController::addBlog',
], array(), array(), '', array(), array('POST')  ));

$routes->add('get_del_blog_spot', new Routing\Route('/backend_challenge/blog/{slug}', [
    'slug' => null,
    '_controller' => 'Crimsoncircle\Controller\BlogController::getDelBlogSlug',
]));

// Comentarios
$routes->add('add_comment_blog', new Routing\Route('/backend_challenge/comment', [
    '_controller' => 'Crimsoncircle\Controller\CommentController::addComment',
], array(), array(), '', array(), array('POST')  ));

$routes->add('get_delete_comment_spot', new Routing\Route('/backend_challenge/comment/{id}', [
    'id' => null,
    '_controller' => 'Crimsoncircle\Controller\CommentController::getDeleteCommentId',
]));

$routes->add('get_comments_blog_spot', new Routing\Route('/backend_challenge/comment/post/{pos_id}', [
    'pos_id' => null,
    '_controller' => 'Crimsoncircle\Controller\CommentController::getCommentsPostId',
]));

return $routes;

