<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserDepartmentRolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserDepartmentRolesTable Test Case
 */
class UserDepartmentRolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserDepartmentRolesTable
     */
    public $UserDepartmentRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_department_roles',
        'app.users',
        'app.departments',
        'app.accounts',
        'app.article_datas',
        'app.follow_datas',
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
        'app.files'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserDepartmentRoles') ? [] : ['className' => 'App\Model\Table\UserDepartmentRolesTable'];
        $this->UserDepartmentRoles = TableRegistry::get('UserDepartmentRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserDepartmentRoles);

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
