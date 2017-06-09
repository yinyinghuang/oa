<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DropboxesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DropboxesTable Test Case
 */
class DropboxesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DropboxesTable
     */
    public $Dropboxes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dropboxes',
        'app.files',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Dropboxes') ? [] : ['className' => 'App\Model\Table\DropboxesTable'];
        $this->Dropboxes = TableRegistry::get('Dropboxes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Dropboxes);

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
