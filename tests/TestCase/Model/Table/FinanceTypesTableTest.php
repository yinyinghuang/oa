<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FinanceTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FinanceTypesTable Test Case
 */
class FinanceTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FinanceTypesTable
     */
    public $FinanceTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.finance_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('FinanceTypes') ? [] : ['className' => 'App\Model\Table\FinanceTypesTable'];
        $this->FinanceTypes = TableRegistry::get('FinanceTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FinanceTypes);

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
