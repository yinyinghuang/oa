<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SmsModelsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SmsModelsTable Test Case
 */
class SmsModelsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SmsModelsTable
     */
    public $SmsModels;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sms_models',
        'app.templates',
        'app.sms_variables'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SmsModels') ? [] : ['className' => 'App\Model\Table\SmsModelsTable'];
        $this->SmsModels = TableRegistry::get('SmsModels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SmsModels);

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
