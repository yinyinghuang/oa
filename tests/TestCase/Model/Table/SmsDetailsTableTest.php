<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SmsDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SmsDetailsTable Test Case
 */
class SmsDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SmsDetailsTable
     */
    public $SmsDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sms_details',
        'app.sms_templates',
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
        'app.customer_businesses',
        'app.follow_datas',
        'app.dropboxes',
        'app.files',
        'app.finance_balances',
        'app.project_issue_solutions',
        'app.tasks',
        'app.finance_applies',
        'app.project_issues',
        'app.project_schedules',
        'app.projects',
        'app.project_progresses',
        'app.sms_records'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SmsDetails') ? [] : ['className' => 'App\Model\Table\SmsDetailsTable'];
        $this->SmsDetails = TableRegistry::get('SmsDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SmsDetails);

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
