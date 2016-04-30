<?php
namespace Users\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Users\Model\Table\AccountDescriptionsTable;

/**
 * Users\Model\Table\AccountDescriptionsTable Test Case
 */
class AccountDescriptionsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.users.account_descriptions',
        'plugin.users.user_accounts',
        'plugin.users.users',
        'plugin.users.cities',
        'plugin.users.roles',
        'plugin.users.capabilities',
        'plugin.users.roles_capabilities',
        'plugin.users.activation_keys',
        'plugin.users.user_logins',
        'plugin.users.reward_requests',
        'plugin.users.users_banks',
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
        $config = TableRegistry::exists('AccountDescriptions') ? [] : ['className' => 'Users\Model\Table\AccountDescriptionsTable'];
        $this->AccountDescriptions = TableRegistry::get('AccountDescriptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccountDescriptions);

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
