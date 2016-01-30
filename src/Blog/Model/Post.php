<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/16/14
 * Time: 11:36 AM
 */

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

class Post extends ActiveRecord
{
    public $title;
    public $content;
    public $date;

    public static function getTable()
    {
        return 'posts';
    }

    public function getRules()
    {
        return array(
            'title'   => array(
                new NotBlank(),
                new Length(4, 100)
            ),
            'content' => array(new NotBlank())
        );
    }
}