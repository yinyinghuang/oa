<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RolesTable Test Case
 */
class RolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RolesTable
     */
    public $Roles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.roles',
        'app.finances',
        'app.users',
        'app.departments',
        'app.accounts',
        'app.article_datas',
        'app.follow_datas',
        'app.user_department_roles',
        'app.customers',
        'app.customer_categories',
        'app.customer_businesses',
        'app.tasks',
        'app.cs',
        'app.project_issue_solutions',
        'app.project_issues',
        'app.project_schedules',
        'app.projects',
        'app.project_progresses',
        'app.dropboxes',
        'app.files',
        'app.finance_reviews'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Roles') ? [] : ['className' => 'App\Model\Table\RolesTable'];
        $this->Roles = TableRegistry::get('Roles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Roles);

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
