<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomerCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomerCategoriesTable Test Case
 */
class CustomerCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomerCategoriesTable
     */
    public $CustomerCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.customer_categories',
        'app.customers',
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
        $config = TableRegistry::exists('CustomerCategories') ? [] : ['className' => 'App\Model\Table\CustomerCategoriesTable'];
        $this->CustomerCategories = TableRegistry::get('CustomerCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerCategories);

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
