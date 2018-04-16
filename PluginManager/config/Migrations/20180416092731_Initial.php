<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('spider_plugins_plugins')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('theme', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('version', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('new_version', 'string', [
                'comment' => 'set to 1 when arrive new version, default is 0',
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('weight', 'tinyinteger', [
                'default' => null,
                'limit' => 4,
                'null' => true,
            ])
            ->addColumn('status', 'tinyinteger', [
                'comment' => '0=deactive
1=active
',
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('default', 'boolean', [
                'comment' => 'is default theme (admin or front) or not',
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->create();
    }

    public function down()
    {
        $this->dropTable('spider_plugins_plugins');
    }
}
