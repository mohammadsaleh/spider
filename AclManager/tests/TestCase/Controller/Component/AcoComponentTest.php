<?php
namespace AclManager\Test\TestCase\Controller\Component;

use AclManager\Controller\Component\AcoComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * AclManager\Controller\Component\AcoComponent Test Case
 */
class AcoComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AclManager\Controller\Component\AcoComponent
     */
    public $Aco;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Aco = new AcoComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Aco);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
