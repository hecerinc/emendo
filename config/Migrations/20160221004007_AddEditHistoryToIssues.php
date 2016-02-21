<?php
use Migrations\AbstractMigration;

class AddEditHistoryToIssues extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('issues');
        $table->addColumn('parent_id', 'integer', [
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('is_latest', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
