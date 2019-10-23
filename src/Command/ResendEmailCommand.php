<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * ResendEmail command.
 */
class ResendEmailCommand extends Command
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
        $parser
            ->addOption('ticket', [
                'required' => true,
                'help' => 'The id of the ticket to resend emails for.'
            ])
            ->addOption('recipient', [
                'default' => '*',
                'help' => 'The recipient to resend to. Can be `*` to resend all messages.'
            ]);

        return $parser;
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
        $this->loadModel('Tickets');
        $this->loadModel('Emails');

        $ticket = $this->Tickets->get($args->getOption('ticket'), [
            'contain' => ['Emails']
        ]);
        $target = $args->getOption('recipient');
        $emails = collection($ticket->emails)->filter(function ($email) use ($target) {
            if ($target == '*') {
                return true;
            }
            return $target == $email->to_email;
        });
        foreach ($emails as $email) {
            $io->out("Resending email to {$email->to_email}");
            // Resend the email
        }
        $io->out('<success>Complete</success>');

        return static::CODE_SUCCESS;
    }
}
