<?php
namespace AclManager\Test\TestCase\Controller\Component;

use AclManager\Controller\Component\AroComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * AclManager\Controller\Component\AroComponent Test Case
 */
class AroComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AclManager\Controller\Component\AroComponent
     */
    public $Aro;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Aro = new AroComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Aro);

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
