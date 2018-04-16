<?php
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
                'username' => 'superadmin',
                'password' => '$2y$10$cqC39uic1CvRduur1HM5LepCUEZPFTvaEm/A3iFvO/5.pyUuqmIQy',
                'firstname' => 'Mohammad Saleh',
                'lastname' => 'Sayari',
                'alias' => '',
                'mobile' => '09152225154',
                'birthday' => '1366/11/16',
                'avatar' => '',
                'status' => '1',
                'created' => '2017-05-07 14:04:51',
            ],
        ];

        $table = $this->table('spider_users_users');
        $table->insert($data)->save();
    }
}
