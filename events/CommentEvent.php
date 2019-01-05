<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 03.01.2019
 * Time: 19:40
 */

namespace oboom\comments\events;

use yii\base\Event;
use oboom\comments\models\Comments;
/**
 * Class CommentEvent
 *
 * @package yii2mod\comments\events
 */
class CommentEvent extends Event
{
    /**
     * @var CommentModel
     */
    private $_commentModel;
    /**
     * @return CommentModel
     */
    public function getCommentModel()
    {
        return $this->_commentModel;
    }
    /**
     * @param CommentModel $commentModel
     */
    public function setCommentModel(Comments $commentModel)
    {
        $this->_commentModel = $commentModel;
    }
}