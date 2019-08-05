<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server[] $servers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Server
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $ip
 * @property int $ssh_port
 * @property string $sudo_password
 * @property array $meta
 * @property string $php_version
 * @property string|null $database_type
 * @property string $database_password
 * @property string $public_key
 * @property string $private_key
 * @property string $key_password
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $configuring_job_dispatched_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Key[] $keys
 * @property-write mixed $keypair
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Task[] $tasks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereConfiguringJobDispatchedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereDatabasePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereDatabaseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereKeyPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePhpVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePrivateKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePublicKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereSshPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereSudoPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUserId($value)
 */
	class Server extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\Task
 *
 * @property string $id
 * @property string $server_id
 * @property string $name
 * @property string $user
 * @property string $status
 * @property int|null $exit_code
 * @property string $script
 * @property string|null $output
 * @property array $options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereExitCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereScript($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereUser($value)
 */
	class Task extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\Key
 *
 * @property string $id
 * @property string $name
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Key newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Key newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Key query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Key whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Key whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Key whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Key whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Key whereUpdatedAt($value)
 */
	class Key extends \Eloquent {}
}

