<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectProgressesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectProgressesTable Test Case
 */
class ProjectProgressesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectProgressesTable
     */
    public $ProjectProgresses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.project_progresses',
        'app.project_schedules',
        'app.tasks',
        'app.users',
        'app.article_datas',
        'app.accounts',
        'app.departments',
        'app.user_department_roles',
        'app.roles',
        'app.finances',
        'app.finance_types',
        'app.customer_incomes',
        'app.customers',
        'app.customer_categories',
        'app.customer_category_options',
        'app.customer_category_values',
        'app.sms_details',
        'app.sms_templates',
        'app.sms_records',
        'app.customer_businesses',
        'app.follow_datas',
        'app.dropboxes',
        'app.files',
        'app.finance_balances',
        'app.project_issue_solutions',
        'app.project_issues',
        'app.projects',
        'app.finance_applies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ProjectProgresses') ? [] : ['className' => 'App\Model\Table\ProjectProgressesTable'];
        $this->ProjectProgresses = TableRegistry::get('ProjectProgresses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProjectProgresses);

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
