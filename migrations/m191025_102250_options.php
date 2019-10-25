<?php

use yii\db\Migration;

/**
 * Class m191025_102250_options
 */
class m191025_102250_options extends Migration
{
    public function up()
    {
        $this->createTable('options', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'image' => $this->string()->notNull(),
            'position' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(1)
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
        
        $this->createIndex('idx-options_questions', 'options', 'question_id');
        $this->addForeignKey('options_fk_1', 'options', 'question_id', 'questions', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('options_fk_1', 'options');
        $this->dropIndex('idx-options_questions', 'options');
        
        $this->dropTable('options');
    }
}