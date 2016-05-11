<?php
namespace AclManager\Test\TestCase\Model\Table;

use AclManager\Model\Table\ArosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AclManager\Model\Table\ArosTable Test Case
 */
class ArosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AclManager\Model\Table\ArosTable
     */
    public $Aros;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.acl_manager.aros',
        'plugin.acl_manager.acos',
        'plugin.acl_manager.aros_acos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Aros') ? [] : ['className' => 'AclManager\Model\Table\ArosTable'];
        $this->Aros = TableRegistry::get('Aros', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Aros);

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
