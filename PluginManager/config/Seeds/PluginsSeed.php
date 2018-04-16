<?php
use Migrations\AbstractSeed;

/**
 * Plugins seed.
 */
class PluginsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '3',
                'name' => 'Bird',
                'theme' => 'admin',
                'version' => NULL,
                'new_version' => NULL,
                'weight' => '2',
                'status' => '1',
                'default' => '1',
            ],
            [
                'id' => '5',
                'name' => 'DataTables',
                'theme' => NULL,
                'version' => NULL,
                'new_version' => NULL,
                'weight' => NULL,
                'status' => '1',
                'default' => '0',
            ],
            [
                'id' => '7',
                'name' => 'Migrations',
                'theme' => NULL,
                'version' => NULL,
                'new_version' => NULL,
                'weight' => NULL,
                'status' => '1',
                'default' => '0',
            ],
        ];

        $table = $this->table('spider_plugins_plugins');
        $table->insert($data)->save();
    }
}
