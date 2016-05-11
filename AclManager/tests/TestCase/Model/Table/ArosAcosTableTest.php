<?php
namespace AclManager\Test\TestCase\Model\Table;

use AclManager\Model\Table\ArosAcosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AclManager\Model\Table\ArosAcosTable Test Case
 */
class ArosAcosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AclManager\Model\Table\ArosAcosTable
     */
    public $ArosAcos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.acl_manager.aros_acos',
        'plugin.acl_manager.aros',
        'plugin.acl_manager.acos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ArosAcos') ? [] : ['className' => 'AclManager\Model\Table\ArosAcosTable'];
        $this->ArosAcos = TableRegistry::get('ArosAcos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArosAcos);

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
