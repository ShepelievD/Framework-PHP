<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/15/14
 * Time: 3:19 PM
 */

namespace Blog\Controller;

use Framework\Controller\Controller;
use Framework\Response\JsonResponse;

class TestController extends Controller
{
    public function redirectAction()
    {
        return $this->redirect('/');
    }

    public function getJsonAction()
    {
        return new JsonResponse(array('body' => 'Hello World'));
    }
} 