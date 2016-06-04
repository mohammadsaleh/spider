<?php
namespace Users\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Users\Model\Table\BanksTable;

/**
 * Users\Model\Table\BanksTable Test Case
 */
class BanksTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.users.banks',
        'plugin.users.users',
        'plugin.users.cities',
        'plugin.AclManager.Roles',
        'plugin.users.capabilities',
        'plugin.AclManager.Roles_capabilities',
        'plugin.users.activation_keys',
        'plugin.users.user_accounts',
        'plugin.users.account_descriptions',
        'plugin.users.user_logins',
        'plugin.users.reward_requests',
        'plugin.users.users_banks',
        'plugin.users.users_capabilities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Banks') ? [] : ['className' => 'Users\Model\Table\BanksTable'];
        $this->Banks = TableRegistry::get('Banks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Banks);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
