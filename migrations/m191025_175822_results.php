<?php

use yii\db\Migration;

/**
 * Class m191025_175822_results
 */
class m191025_175822_results extends Migration
{
    public function up()
    {
        $this->createTable('results', [
            'id' => $this->primaryKey(),
            'questionnaire_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string(20)->notNull(),
            'questions' => $this->text()->notNull(),
            'discount' => $this->string(20)->notNull(),
            'referrer' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
    }

    public function down()
    {
        $this->dropTable('results');
    }
}