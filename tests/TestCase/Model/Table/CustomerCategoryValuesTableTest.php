<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomerCategoryValuesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomerCategoryValuesTable Test Case
 */
class CustomerCategoryValuesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomerCategoryValuesTable
     */
    public $CustomerCategoryValues;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.customer_category_values',
        'app.customers',
        'app.customer_categories',
        'app.users',
        'app.article_datas',
        'app.accounts',
        'app.departments',
        'app.finances',
        'app.user_department_roles',
        'app.roles',
        'app.follow_datas',
        'app.dropboxes',
        'app.files',
        'app.finance_balances',
        'app.project_issue_solutions',
        'app.tasks',
        'app.cs',
        'app.customer_businesses',
        'app.project_issues',
        'app.project_schedules',
        'app.projects',
        'app.project_progresses',
        'app.customer_category_options'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CustomerCategoryValues') ? [] : ['className' => 'App\Model\Table\CustomerCategoryValuesTable'];
        $this->CustomerCategoryValues = TableRegistry::get('CustomerCategoryValues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerCategoryValues);

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
