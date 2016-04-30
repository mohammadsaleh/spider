<?php
namespace Users\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Users\Model\Table\UserAccountsTable;

/**
 * Users\Model\Table\UserAccountsTable Test Case
 */
class UserAccountsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.users.user_accounts',
        'plugin.users.users',
        'plugin.users.cities',
        'plugin.users.roles',
        'plugin.users.capabilities',
        'plugin.users.roles_capabilities',
        'plugin.users.activation_keys',
        'plugin.users.user_logins',
        'plugin.users.banks',
        'plugin.users.users_banks',
        'plugin.users.users_capabilities',
        'plugin.users.account_descriptions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserAccounts') ? [] : ['className' => 'Users\Model\Table\UserAccountsTable'];
        $this->UserAccounts = TableRegistry::get('UserAccounts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserAccounts);

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
