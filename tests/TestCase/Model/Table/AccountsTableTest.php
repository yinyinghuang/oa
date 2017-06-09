<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccountsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccountsTable Test Case
 */
class AccountsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccountsTable
     */
    public $Accounts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.accounts',
        'app.article_datas',
        'app.users',
        'app.departments',
        'app.finances',
        'app.roles',
        'app.finance_reviews',
        'app.tasks',
        'app.cs',
        'app.customer_businesses',
        'app.customers',
        'app.customer_categories',
        'app.project_issue_solutions',
        'app.project_issues',
        'app.project_schedules',
        'app.projects',
        'app.project_progresses',
        'app.dropboxes',
        'app.files',
        'app.follow_datas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Accounts') ? [] : ['className' => 'App\Model\Table\AccountsTable'];
        $this->Accounts = TableRegistry::get('Accounts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Accounts);

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
