<?php
declare(strict_types=1);

namespace App\Command;

use App\Command\HelloCommand;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Mailer\TransportFactory;

/**
 * Redeliver command.
 */
class RedeliverCommand extends Command
{
    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);
        $parser->addOption('ticket', [
            'help' => 'Ticket to resend for',
            'required' => true,
        ]);
        $parser->setDescription('Resend emails!');

        return $parser;
    }

    public static function defaultName(): string
    {
        return 'redoooo';
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $this->loadModel('Emails');
        $ticket = $args->getOption('ticket');
        if (!$ticket) {
            $ticket = $io->ask('What ticket?');
        }
        $query = $this->Emails->find('forTicket', [
            $ticket,
        ]);
        $transport = TransportFactory::get('default');
        foreach ($query->all() as $email) {
            $io->verbose("Redelivering {$email->id}");
            $email->redeliver($transport);
        }
        $io->success("Redelivered all email for ticket {$args->getOption('ticket')}");
        $this->executeCommand(HelloCommand::class);

        return static::CODE_SUCCESS;
    }
}
