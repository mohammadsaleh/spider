<?php
namespace Users\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Users\Model\Table\CapabilitiesTable;

/**
 * Users\Model\Table\CapabilitiesTable Test Case
 */
class CapabilitiesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.users.capabilities',
        'plugin.users.roles',
        'plugin.users.users',
        'plugin.users.cities',
        'plugin.users.activation_keys',
        'plugin.users.user_accounts',
        'plugin.users.user_logins',
        'plugin.users.banks',
        'plugin.users.users_banks',
        'plugin.users.roles_capabilities',
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
        $config = TableRegistry::exists('Capabilities') ? [] : ['className' => 'Users\Model\Table\CapabilitiesTable'];
        $this->Capabilities = TableRegistry::get('Capabilities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Capabilities);

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
