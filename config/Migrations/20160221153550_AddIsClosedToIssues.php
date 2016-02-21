<?php
use Migrations\AbstractMigration;

class AddIsClosedToIssues extends AbstractMigration
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
        $table->addColumn('is_closed', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->update();
    }
}
