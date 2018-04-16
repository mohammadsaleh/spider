<?php
use Migrations\AbstractSeed;

/**
 * Aros seed.
 */
class ArosSeed extends AbstractSeed
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
                'id' => '1',
                'model' => 'roles',
                'foreign_key' => '4',
            ],
            [
                'id' => '36',
                'model' => 'users',
                'foreign_key' => '4',
            ],
            [
                'id' => '37',
                'model' => 'users',
                'foreign_key' => '1',
            ],
            [
                'id' => '38',
                'model' => 'roles',
                'foreign_key' => '1',
            ],
            [
                'id' => '39',
                'model' => 'users',
                'foreign_key' => '2',
            ],
            [
                'id' => '40',
                'model' => 'users',
                'foreign_key' => '3',
            ],
        ];

        $table = $this->table('spider_aclmanager_aros');
        $table->insert($data)->save();
    }
}
