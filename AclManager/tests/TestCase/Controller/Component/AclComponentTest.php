<?php
namespace AclManager\Test\TestCase\Controller\Component;

use AclManager\Controller\Component\AclComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * AclManager\Controller\Component\AclComponent Test Case
 */
class AclComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AclManager\Controller\Component\AclComponent
     */
    public $Acl;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Acl = new AclComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Acl);

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
