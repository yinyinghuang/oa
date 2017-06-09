<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectIssuesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectIssuesTable Test Case
 */
class ProjectIssuesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectIssuesTable
     */
    public $ProjectIssues;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.project_issues',
        'app.tasks',
        'app.project_schedules',
        'app.users',
        'app.project_issue_solutions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ProjectIssues') ? [] : ['className' => 'App\Model\Table\ProjectIssuesTable'];
        $this->ProjectIssues = TableRegistry::get('ProjectIssues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProjectIssues);

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
