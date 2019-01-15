<?php

use yii\db\Migration;

/**
 * Class m190115_094504_vote
 */
class m190115_094504_vote extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
          CREATE TABLE IF NOT EXISTS `comments_vote` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `user` INT NOT NULL,
              `created_at` INT NOT NULL,
              `vote_type` TINYINT(2) NULL DEFAULT 0,
              `comments_id` INT NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `FK_vote_comments_idx` (`comments_id` ASC),
              CONSTRAINT `FK_vote_comments`
                FOREIGN KEY (`comments_id`)
                REFERENCES `comments` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190115_094504_vote cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190115_094504_vote cannot be reverted.\n";

        return false;
    }
    */
}
