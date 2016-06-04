<?php
namespace Users\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Users\Model\Table\UsersBanksTable;

/**
 * Users\Model\Table\UsersBanksTable Test Case
 */
class UsersBanksTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.users.users_banks',
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
        'plugin.users.banks',
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
        $config = TableRegistry::exists('UsersBanks') ? [] : ['className' => 'Users\Model\Table\UsersBanksTable'];
        $this->UsersBanks = TableRegistry::get('UsersBanks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersBanks);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
