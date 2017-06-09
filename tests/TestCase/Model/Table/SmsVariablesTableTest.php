<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SmsVariablesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SmsVariablesTable Test Case
 */
class SmsVariablesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SmsVariablesTable
     */
    public $SmsVariables;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sms_variables',
        'app.sms_models'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SmsVariables') ? [] : ['className' => 'App\Model\Table\SmsVariablesTable'];
        $this->SmsVariables = TableRegistry::get('SmsVariables', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SmsVariables);

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
