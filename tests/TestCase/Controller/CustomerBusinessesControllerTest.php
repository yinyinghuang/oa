<?php
namespace App\Test\TestCase\Controller;

use App\Controller\CustomerBusinessesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\CustomerBusinessesController Test Case
 */
class CustomerBusinessesControllerTest extends IntegrationTestCase
{

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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
