<?php
use Migrations\AbstractMigration;

class AddIsPrivateToIssues extends AbstractMigration
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
        $table->addColumn('is_private', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->update();
    }
}
