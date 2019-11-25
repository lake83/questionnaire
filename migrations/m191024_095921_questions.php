<?php

use yii\db\Migration;

/**
 * Class m191024_095921_questions
 */
class m191024_095921_questions extends Migration
{
    public function up()
    {
        $this->createTable('questions', [
            'id' => $this->primaryKey(),
            'questionnaire_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'type' => $this->integer(1)->notNull(),
            'info' => $this->string(100)->notNull(),
            'hint' => $this->string()->notNull(),
            'image' => $this->string()->notNull(),
            'slider' => $this->string()->notNull(),
            'position' => $this->integer()->notNull(),
            'is_required' => $this->boolean()->defaultValue(1),
            'is_several' => $this->boolean()->defaultValue(1),
            'is_active' => $this->boolean()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull()
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
        
        $this->createIndex('idx-questions_questionnaire', 'questions', 'questionnaire_id');
        $this->addForeignKey('questions_fk_1', 'questions', 'questionnaire_id', 'questionnaires', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('questions_fk_1', 'questions');
        $this->dropIndex('idx-questions_questionnaire', 'questions');
        
        $this->dropTable('questions');
    }
}