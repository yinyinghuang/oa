<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomerBusinessesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomerBusinessesTable Test Case
 */
class CustomerBusinessesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomerBusinessesTable
     */
    public $CustomerBusinesses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.customer_businesses',
        'app.customers',
        'app.customer_categories',
        'app.customer_category_options',
        'app.customer_category_values',
        'app.users',
        'app.article_datas',
        'app.accounts',
        'app.departments',
        'app.user_department_roles',
        'app.roles',
        'app.finances',
        'app.follow_datas',
        'app.dropboxes',
        'app.files',
        'app.finance_balances',
        'app.project_issue_solutions',
        'app.tasks',
        'app.cs',
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
        $config = TableRegistry::exists('CustomerBusinesses') ? [] : ['className' => 'App\Model\Table\CustomerBusinessesTable'];
        $this->CustomerBusinesses = TableRegistry::get('CustomerBusinesses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerBusinesses);

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
