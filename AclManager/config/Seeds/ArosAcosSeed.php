<?php
use Migrations\AbstractSeed;

/**
 * ArosAcos seed.
 */
class ArosAcosSeed extends AbstractSeed
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
                'id' => '588',
                'aro_id' => '1',
                'aco_id' => '88',
                'deny' => NULL,
            ],
            [
                'id' => '1316',
                'aro_id' => '1',
                'aco_id' => '94',
                'deny' => NULL,
            ],
            [
                'id' => '1317',
                'aro_id' => '1',
                'aco_id' => '92',
                'deny' => NULL,
            ],
            [
                'id' => '1318',
                'aro_id' => '1',
                'aco_id' => '93',
                'deny' => NULL,
            ],
            [
                'id' => '1319',
                'aro_id' => '1',
                'aco_id' => '97',
                'deny' => NULL,
            ],
            [
                'id' => '1320',
                'aro_id' => '1',
                'aco_id' => '99',
                'deny' => NULL,
            ],
            [
                'id' => '1321',
                'aro_id' => '1',
                'aco_id' => '98',
                'deny' => NULL,
            ],
            [
                'id' => '1322',
                'aro_id' => '1',
                'aco_id' => '95',
                'deny' => NULL,
            ],
            [
                'id' => '1323',
                'aro_id' => '1',
                'aco_id' => '96',
                'deny' => NULL,
            ],
            [
                'id' => '1324',
                'aro_id' => '1',
                'aco_id' => '121',
                'deny' => NULL,
            ],
            [
                'id' => '1325',
                'aro_id' => '1',
                'aco_id' => '91',
                'deny' => NULL,
            ],
            [
                'id' => '1326',
                'aro_id' => '1',
                'aco_id' => '102',
                'deny' => NULL,
            ],
            [
                'id' => '1327',
                'aro_id' => '1',
                'aco_id' => '104',
                'deny' => NULL,
            ],
            [
                'id' => '1328',
                'aro_id' => '1',
                'aco_id' => '103',
                'deny' => NULL,
            ],
            [
                'id' => '1329',
                'aro_id' => '1',
                'aco_id' => '100',
                'deny' => NULL,
            ],
            [
                'id' => '1330',
                'aro_id' => '1',
                'aco_id' => '101',
                'deny' => NULL,
            ],
            [
                'id' => '1331',
                'aro_id' => '1',
                'aco_id' => '90',
                'deny' => NULL,
            ],
            [
                'id' => '1332',
                'aro_id' => '1',
                'aco_id' => '116',
                'deny' => NULL,
            ],
            [
                'id' => '1333',
                'aro_id' => '1',
                'aco_id' => '118',
                'deny' => NULL,
            ],
            [
                'id' => '1334',
                'aro_id' => '1',
                'aco_id' => '117',
                'deny' => NULL,
            ],
            [
                'id' => '1335',
                'aro_id' => '1',
                'aco_id' => '114',
                'deny' => NULL,
            ],
            [
                'id' => '1336',
                'aro_id' => '1',
                'aco_id' => '113',
                'deny' => NULL,
            ],
            [
                'id' => '1337',
                'aro_id' => '1',
                'aco_id' => '119',
                'deny' => NULL,
            ],
            [
                'id' => '1338',
                'aro_id' => '1',
                'aco_id' => '120',
                'deny' => NULL,
            ],
            [
                'id' => '1339',
                'aro_id' => '1',
                'aco_id' => '115',
                'deny' => NULL,
            ],
            [
                'id' => '1340',
                'aro_id' => '1',
                'aco_id' => '107',
                'deny' => NULL,
            ],
            [
                'id' => '1341',
                'aro_id' => '1',
                'aco_id' => '106',
                'deny' => NULL,
            ],
            [
                'id' => '1342',
                'aro_id' => '1',
                'aco_id' => '109',
                'deny' => NULL,
            ],
            [
                'id' => '1343',
                'aro_id' => '1',
                'aco_id' => '108',
                'deny' => NULL,
            ],
            [
                'id' => '1344',
                'aro_id' => '1',
                'aco_id' => '110',
                'deny' => NULL,
            ],
            [
                'id' => '1345',
                'aro_id' => '1',
                'aco_id' => '105',
                'deny' => NULL,
            ],
            [
                'id' => '1346',
                'aro_id' => '1',
                'aco_id' => '111',
                'deny' => NULL,
            ],
            [
                'id' => '1347',
                'aro_id' => '1',
                'aco_id' => '112',
                'deny' => NULL,
            ],
            [
                'id' => '1348',
                'aro_id' => '1',
                'aco_id' => '43',
                'deny' => NULL,
            ],
            [
                'id' => '1349',
                'aro_id' => '1',
                'aco_id' => '89',
                'deny' => NULL,
            ],
            [
                'id' => '1350',
                'aro_id' => '38',
                'aco_id' => '43',
                'deny' => NULL,
            ],
            [
                'id' => '1351',
                'aro_id' => '38',
                'aco_id' => '89',
                'deny' => NULL,
            ],
        ];

        $table = $this->table('spider_aclmanager_aros_acos');
        $table->insert($data)->save();
    }
}
