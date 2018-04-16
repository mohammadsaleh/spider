<?php
use Migrations\AbstractSeed;

/**
 * Roles seed.
 */
class RolesSeed extends AbstractSeed
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
                'parent_id' => NULL,
                'name' => 'public',
                'title' => 'کاربر عمومی',
                'description' => NULL,
                'lft' => '1',
                'rght' => '8',
            ],
            [
                'id' => '2',
                'parent_id' => '1',
                'name' => 'registered',
                'title' => 'کاربر ثبت نام شده',
                'description' => NULL,
                'lft' => '2',
                'rght' => '7',
            ],
            [
                'id' => '3',
                'parent_id' => '2',
                'name' => 'admin',
                'title' => 'مدیر',
                'description' => NULL,
                'lft' => '3',
                'rght' => '6',
            ],
            [
                'id' => '4',
                'parent_id' => '3',
                'name' => 'superadmin',
                'title' => 'مدیرکل',
                'description' => NULL,
                'lft' => '4',
                'rght' => '5',
            ],
        ];

        $table = $this->table('spider_aclmanager_roles');
        $table->insert($data)->save();
    }
}
