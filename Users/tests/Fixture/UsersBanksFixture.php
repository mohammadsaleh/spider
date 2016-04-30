<?php
namespace Users\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersBanksFixture
 *
 */
class UsersBanksFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bank_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'account_number' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => 'شماره حساب', 'precision' => null, 'fixed' => null],
        'card_number' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => 'شماره کارت', 'precision' => null, 'fixed' => null],
        'iban_number' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => 'شماره شبا', 'precision' => null, 'fixed' => null],
        'default' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'حساب پیشفرض', 'precision' => null],
        'status' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '0=تایید نشده
1=تایید شده', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'bank_id' => ['type' => 'index', 'columns' => ['bank_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'users_banks_ibfk_1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'users_banks_ibfk_2' => ['type' => 'foreign', 'columns' => ['bank_id'], 'references' => ['banks', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'user_id' => 1,
            'bank_id' => 1,
            'account_number' => 'Lorem ipsum dolor sit amet',
            'card_number' => 'Lorem ipsum dolor sit amet',
            'iban_number' => 'Lorem ipsum dolor sit amet',
            'default' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'status' => 1,
            'created' => 1445792734
        ],
    ];
}
