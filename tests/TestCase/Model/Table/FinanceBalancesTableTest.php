<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FinanceBalancesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FinanceBalancesTable Test Case
 */
class FinanceBalancesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FinanceBalancesTable
     */
    public $FinanceBalances;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.finance_balances',
        'app.users',
        'app.article_datas',
        'app.accounts',
        'app.departments',
        'app.user_department_roles',
        'app.roles',
        'app.finances',
        'app.follow_datas',
        'app.customers',
        'app.customer_categories',
        'app.customer_category_options',
        'app.customer_category_values',
        'app.customer_businesses',
        'app.dropboxes',
        'app.files',
        'app.project_issue_solutions',
        'app.tasks',
        'app.project_issues',
        'app.project_schedules',
        'app.projects',
        'app.project_progresses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('FinanceBalances') ? [] : ['className' => 'App\Model\Table\FinanceBalancesTable'];
        $this->FinanceBalances = TableRegistry::get('FinanceBalances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FinanceBalances);

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
