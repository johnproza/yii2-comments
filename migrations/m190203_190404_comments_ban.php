<?php

use yii\db\Migration;

/**
 * Class m190203_190404_comments_ban
 */
class m190203_190404_comments_ban extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `comments_ban` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `expires` INT NULL,
                `reason` VARCHAR(250) NULL,
                `user_id` INT NULL,
              PRIMARY KEY (`id`),
              INDEX `USER` (`user_id` ASC),
              CONSTRAINT `FK_comments_ban_user`
                FOREIGN KEY (`user_id`)
                REFERENCES `user` (`id`)
                ON DELETE RESTRICT
                ON UPDATE NO ACTION)
            ENGINE = InnoDB
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190203_190404_comments_ban cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190203_190404_comments_ban cannot be reverted.\n";

        return false;
    }
    */
}
