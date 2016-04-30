<?php
namespace Users\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Users\Model\Table\ActivationKeysTable;

/**
 * Users\Model\Table\ActivationKeysTable Test Case
 */
class ActivationKeysTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.users.activation_keys',
        'plugin.users.users',
        'plugin.users.cities',
        'plugin.users.roles',
        'plugin.users.capabilities',
        'plugin.users.roles_capabilities',
        'plugin.users.user_accounts',
        'plugin.users.user_logins',
        'plugin.users.banks',
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
        $config = TableRegistry::exists('ActivationKeys') ? [] : ['className' => 'Users\Model\Table\ActivationKeysTable'];
        $this->ActivationKeys = TableRegistry::get('ActivationKeys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ActivationKeys);

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
