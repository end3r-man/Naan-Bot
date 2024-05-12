<?php

namespace App\Commands;

use Illuminate\Support\Facades\Log;
use Laracord\Commands\Command;

class Ban extends Command
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'ban';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'The ban command.';

    /**
     * Determines whether the command requires admin permissions.
     *
     * @var bool
     */
    protected $admin = false;

    /**
     * Determines whether the command should be displayed in the commands list.
     *
     * @var bool
     */
    protected $hidden = false;

    /**
     * Handle the command.
     *
     * @param  \Discord\Parts\Channel\Message  $message
     * @param  array  $args
     * @return void
     */
    public function handle($message, $args)
    {

        $user = $args[0] ?? null;

        $logLine = trim($user);
        $logLine = str_replace(['[', ']'], '', $logLine);
        $logParts = explode(' ', $logLine, 4);

        $use = str_replace(['<@', '>', '"', '<>'], '', $logParts[0]);

        $admin = false;

        foreach ($message->guild->members as $member) {
            if ($member->user->id == $message->author->id) {
                foreach ($member->roles as $role) {
                    if ($role->permissions->administrator) {
                        $admin = true;
                        break 2;
                    }
                }
            }
        }

        if ($admin) {

            $mem = $message->guild->members->get('id', $use);
            
            $message->guild->members->kick($mem, 'Goodbye!');

            return $this
                ->message()
                ->title('✅ Will Be Banned')
                ->content('User Will Banned Soon')
                ->footerText('Sent by நான்')
                ->send($message);

        } elseif ($admin == false) {
            return $this
                ->message()
                ->title('❌ Admin Only')
                ->content('Warning +1 Added!')
                ->footerText('Sent by நான்')
                ->send($message);
        }
    }
}
