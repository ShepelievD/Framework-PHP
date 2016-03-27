<?php

namespace CMS\Controller;


use Framework\Controller\Controller;
use Blog\Model\Post;
use Framework\Validation\Validator;
use Framework\Exception\DatabaseException;
use Framework\Exception\HttpNotFoundException;

/**
 * Class BlogController
 * @package CMS\Controller
 */


class BlogController extends Controller {

    /**
     * Serves for editing post
     *
     * @route /posts/{$id}/edit
     * @param $id
     * @return \Framework\Response\Response|\Framework\Response\ResponseRedirect
     * @throws HttpNotFoundException
     */

    function editAction( $id ){

        if ( $this->getRequest()->isPost() ) {
            try{
                $post = new Post();
                $date = new \DateTime();

                $post->id = (int) $id;
                $post->title = $this->getRequest()->post('title');
                $post->content = trim($this->getRequest()->post('content'));
                $post->date = $date->format('Y-m-d H:i:s');

                $validator = new Validator($post);

                if ($validator->isValid()) {
                    $post->save();
                    return $this->redirect( $this->generateRoute('home'), 'The data has been update successfully' );
                }
                else {
                    $error = $validator->getErrors();
                }
            }
            catch(DatabaseException $e) {
                $error = $e->getMessage();
            }
        }

        if (!$post = Post::find((int)$id)) {
            throw new HttpNotFoundException('Page Not Found!');
        }

        $date['post'] = $post;
        $date['action'] = $this->generateRoute('edit_post', $post->id);
        $date['errors'] = isset($error) ? $error : null;

        return $this->render( 'edit.html', $date );
    }

    /**
     * Serves for removing post
     *
     * @route /posts/{$id}/remove
     * @param $id
     * @return \Framework\Response\ResponseRedirect
     */

    function removeAction( $id ) {
        Post::remove( $id );
        return $this->redirect( '/', 'The post has been deleted' );
    }
}