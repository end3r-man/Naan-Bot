<?php

namespace App\Commands;

use App\Models\add_youtube;
use App\Models\User;
use Laracord\Commands\Command;

class channel extends Command
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'channel';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Add Youtube Channel.';

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
        $user = User::where('discord_id', $message->author->id)->latest()->first();

        $links = add_youtube::where('user_id', $user->id)->get();

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
            if (!is_null($links)) {
                $channel = $message->channel_id;

                foreach ($links as $item) {
                    $item->update([
                        'channel_id' => $channel,
                    ]);
                }

                return $this
                    ->message()
                    ->title('✅ Channel Noted')
                    ->content('Notification Will Here!')
                    ->footerText('Sent by நான்')
                    ->send($message);
            } else {
                return $this
                    ->message()
                    ->title('❌ No Channel')
                    ->content('Add A Youtube Channel!')
                    ->footerText('Sent by நான்')
                    ->send($message);
            }
        } else {
            $user = User::where('discord_id', $message->author->id)->latest()->first();

            if (is_null($user)) {
                $user = User::create([
                    'username' => $message->author->username,
                    'discord_id' => $message->author->id,
                ]);
            } else {
                $user->update([
                    'warning' => $user->warning + 1,
                ]);
            }

            return $this
                ->message()
                ->title('❌ Admin Only')
                ->content('Warning +1 Added!')
                ->footerText('Sent by நான்')
                ->send($message);
        }
    }
}
