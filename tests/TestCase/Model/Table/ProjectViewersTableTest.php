<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectViewersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectViewersTable Test Case
 */
class ProjectViewersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectViewersTable
     */
    public $ProjectViewers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.project_viewers',
        'app.projects',
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
        'app.project_schedules',
        'app.project_progresses',
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
        $config = TableRegistry::exists('ProjectViewers') ? [] : ['className' => 'App\Model\Table\ProjectViewersTable'];
        $this->ProjectViewers = TableRegistry::get('ProjectViewers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProjectViewers);

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
