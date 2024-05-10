<?php

namespace App\Commands;

use App\Models\add_youtube;
use App\Models\User;
use Laracord\Commands\Command;

use function Discord\contains;

class addyt extends Command
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'addyt';

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
        $channel = str_replace('addyt', '', $message->content);

        $rid = str_replace('<@1113040924910551091>', '', $channel);

        $link = str_replace(' ', '', $rid);

        if (str_contains($channel, 'https://www.youtube.com/')) {
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

                $user = User::where('discord_id', $message->author->id)->latest()->first();

                if (is_null($user)) {
                    $user = User::create([
                        'username' => $message->author->username,
                        'discord_id' => $message->author->id,
                    ]);
                }

                $flink = add_youtube::where('channel_link', $link)->latest()->first();

                echo $flink;

                if (is_null($flink)) {

                    add_youtube::create([
                        'guild_id' => $message->guild_id,
                        'channel_id' => 12615625,
                        'channel_link' => $link,
                        'user_id' => $user->id,
                    ]);

                    $embedName = "";

                    foreach ($message->embeds as $embed) {
                        $embedName = 'Added' . " " . $embed->title;
                    }

                    return $this
                        ->message()
                        ->title('✅ Channel Added')
                        ->content($embedName)
                        ->footerText('Sent by நான்')
                        ->send($message);

                } else {
                    return $this
                        ->message()
                        ->title('✅ Channel Found')
                        ->content('Already added')
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
        } else {
            return $this
                ->message()
                ->title('Invalid Link ❌')
                ->content('No Channel Found!')
                ->footerText('Sent by நான்')
                ->send($message);
        }
    }
}
