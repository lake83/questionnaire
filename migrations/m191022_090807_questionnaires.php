<?php

use yii\db\Migration;

/**
 * Class m191022_090807_questionnaires
 */
class m191022_090807_questionnaires extends Migration
{
    public function up()
    {
        $this->createTable('questionnaires', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'is_column' => $this->boolean()->defaultValue(1),
            'person_name' => $this->string()->notNull(),
            'person_image' => $this->string()->notNull(),
            'person_post' => $this->string(100)->notNull(),
            'is_discount' => $this->boolean()->defaultValue(1),
            'discount_type' => $this->integer(1)->notNull()->defaultValue(1)->comment('1-процент,2-сумма'),
            'discount_value' => $this->float()->notNull(),
            'discount_info' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
    }

    public function down()
    {
        $this->dropTable('questionnaires');
    }
}