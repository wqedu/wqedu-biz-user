<?php

use Phpmig\Migration\Migration;

class UserProduct extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $biz = $this->getContainer();
        $connection = $biz['db'];
        $connection->exec("
            CREATE TABLE IF NOT EXISTS `user_product` (
              `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
              `userId` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '用户ID',
              `productType` enum('book','course','quiz') DEFAULT 'course' COMMENT '目标产品类型',
              `productId` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '目标产品ID',
              `role` enum('admin','teacher','student') DEFAULT 'student' COMMENT '权限角色',
              `createdTime` int(10) unsigned DEFAULT 0,
              `updatedTime` int(10) unsigned DEFAULT 0,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户产品权限表';
        ");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $biz = $this->getContainer();
        $connection = $biz['db'];
        $connection->exec("
            DROP TABLE `user_product`;
        ");
    }
}
