<?php
namespace Users\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Users\Model\Table\UsersCapabilitiesTable;

/**
 * Users\Model\Table\UsersCapabilitiesTable Test Case
 */
class UsersCapabilitiesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.users.users_capabilities',
        'plugin.users.users',
        'plugin.users.cities',
        'plugin.users.roles',
        'plugin.users.capabilities',
        'plugin.users.roles_capabilities',
        'plugin.users.activation_keys',
        'plugin.users.user_accounts',
        'plugin.users.user_logins',
        'plugin.users.banks',
        'plugin.users.users_banks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsersCapabilities') ? [] : ['className' => 'Users\Model\Table\UsersCapabilitiesTable'];
        $this->UsersCapabilities = TableRegistry::get('UsersCapabilities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersCapabilities);

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
