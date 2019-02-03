<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 03.02.2019
 * Time: 22:17
 */
namespace oboom\comments\console;
use yii\console\Controller;

class CommentsController extends Controller {

    public function actionIndex() {
        echo "cron service runnning";
    }

    public function actionMail($to) {
        echo "Sending mail to " . $to;
    }

}