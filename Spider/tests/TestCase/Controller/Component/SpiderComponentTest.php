<?php
namespace Spider\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use Spider\Controller\Component\SpiderComponent;

/**
 * Spider\Controller\Component\SpiderComponent Test Case
 */
class SpiderComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Spider\Controller\Component\SpiderComponent
     */
    public $Spider;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Spider = new SpiderComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Spider);

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
