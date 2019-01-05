<?php

use yii\db\Migration;

/**
 * Class m181227_145926_comments
 */
class m181227_145926_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TABLE IF NOT EXISTS `comments` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `content` TEXT NOT NULL,
              `created_by` INT NOT NULL,
              `updated_by` INT NOT NULL,
              `relatedTo` VARCHAR(500) NULL,
              `status` SMALLINT(6) NULL,
              `created_at` INT NULL,
              `updated_at` INT NULL,
              `entity` CHAR(10) NULL,
              `entityId` INT NULL,
              `like` SMALLINT NULL,
              `dislike` SMALLINT NULL,
              `parent` INT NULL DEFAULT 0,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB 
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181227_145926_comments cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->execute("
        CREATE TABLE IF NOT EXISTS `comments` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `content` TEXT NOT NULL,
              `created_by` INT NOT NULL,
              `updated_by` INT NOT NULL,
              `relatedTo` VARCHAR(500) NULL,
              `status` SMALLINT(6) NULL,
              `created_at` INT NULL,
              `updated_at` INT NULL,
              `entity` CHAR(10) NULL,
              `entityId` INT NULL,
              `like` SMALLINT NULL,
              `dislike` SMALLINT NULL,
              `parent` INT NULL DEFAULT 0,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB 
        ");
    }

    /*
    public function down()
    {
        echo "m181227_145926_comments cannot be reverted.\n";

        return false;
    }
    */
}
