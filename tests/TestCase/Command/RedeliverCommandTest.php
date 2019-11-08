<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\RedeliverCommand;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use RuntimeException;

/**
 * App\Command\RedeliverCommand Test Case
 *
 * @uses \App\Command\RedeliverCommand
 */
class RedeliverCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    public $fixtures = [
        'app.Tickets',
        'app.Emails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->useCommandRunner();
    }

    /**
     * Test execute method
     *
     * @return void
     */
    public function testExecuteMissingArg()
    {
        $this->expectException(RuntimeException::class);
        $this->exec('redeliver');
    }

    public function testExecuteWithTicket()
    {
        $this->exec('redeliver --ticket 1');

        $this->assertExitSuccess();
        $this->assertOutputContains('Redelivered all email');
    }

    public function testExecuteWithQuestion()
    {
        $this->exec('redeliver', [
            '1',
        ]);

        $this->assertExitSuccess();
        $this->assertOutputContains('Redelivered all email');
    }
}
