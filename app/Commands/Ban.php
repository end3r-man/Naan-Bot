<?php

namespace App\Commands;

use Discord\Parts\Guild\Guild;
use Discord\Parts\Guild\Role;
use Discord\Parts\Permissions\ChannelPermission;
use Discord\Parts\Permissions\Permission;
use Discord\Parts\Permissions\RolePermission;
use Laracord\Commands\Command;
use Laracord\Console\Commands\AdminCommand;

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
        if ($message->guild->ban_members = true) {
            return $this
            ->message()
            ->title('Ban')
            ->content('This Will Ban Others, man!')
            ->send($message);
        } else {
            return $this
            ->message()
            ->title('Admin Only')
            ->content('This Will Ban You, man!')
            ->send($message);
        }
        
    }
}
