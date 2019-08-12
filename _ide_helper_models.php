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
 * App\Models\Server
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $ip
 * @property int $ssh_port
 * @property string|null $sudo_password
 * @property array|null $meta
 * @property array|null $os_information
 * @property string $php_version
 * @property string|null $database_type
 * @property string $database_password
 * @property string|null $webserver_type
 * @property string $public_key
 * @property string $private_key
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $configuring_job_dispatched_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\CronJob[] $cronJobs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Database[] $databases
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Event[] $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Firewall\Rule[] $firewallRules
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\PublicKey[] $keys
 * @property-write mixed $keypair
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Site[] $sites
 * @property-read \App\Models\Server\Task $task
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereOsInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePhpVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePrivateKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePublicKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereSshPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereSudoPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereWebserverType($value)
 */
	class Server extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CallbackLog
 *
 * @property string $id
 * @property string $source
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog whereUpdatedAt($value)
 */
	class CallbackLog extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\CronJob
 *
 * @property string $id
 * @property string $server_id
 * @property string|null $name
 * @property string $command
 * @property string $user
 * @property string $cron
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob whereCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob whereCron($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\CronJob whereUser($value)
 */
	class CronJob extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\PublicKey
 *
 * @property string $id
 * @property string $server_id
 * @property string $name
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\PublicKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\PublicKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\PublicKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\PublicKey whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\PublicKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\PublicKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\PublicKey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\PublicKey whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\PublicKey whereUpdatedAt($value)
 */
	class PublicKey extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\Database
 *
 * @property string $id
 * @property string $server_id
 * @property string $name
 * @property string $password
 * @property string $character_set
 * @property string $collation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database whereCharacterSet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database whereCollation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Database whereUpdatedAt($value)
 */
	class Database extends \Eloquent {}
}

namespace App\Models\Server\Site{
/**
 * App\Models\Server\Site\Deployment
 *
 * @property string $id
 * @property string $server_site_id
 * @property string|null $initiator_id
 * @property string|null $branch
 * @property string $commit_hash
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $initiator
 * @property-read \App\Models\Server\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment whereBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment whereCommitHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment whereInitiatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment whereServerSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site\Deployment whereUpdatedAt($value)
 */
	class Deployment extends \Eloquent {}
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
 * @property string|null $owner_type
 * @property string|null $owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Task[] $owner
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereScript($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task whereUser($value)
 */
	class Task extends \Eloquent {}
}

namespace App\Models\Server\Firewall{
/**
 * App\Models\Server\Firewall\Rule
 *
 * @property string $id
 * @property string $server_id
 * @property int $editable
 * @property string $name
 * @property string|null $port
 * @property string|null $protocol
 * @property string|null $from
 * @property string $policy
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule whereEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule wherePolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule whereProtocol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule whereUpdatedAt($value)
 */
	class Rule extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\Site
 *
 * @property string $id
 * @property string $server_id
 * @property string $token
 * @property string $domain
 * @property array|null $aliases
 * @property array|null $environment
 * @property string $public_dir
 * @property string|null $repository
 * @property string|null $repository_provider
 * @property string|null $repository_branch
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Site\Deployment[] $deployments
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereAliases($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereEnvironment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site wherePublicDir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereRepository($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereRepositoryBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereRepositoryProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereUpdatedAt($value)
 */
	class Site extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\Event
 *
 * @property string $id
 * @property string $server_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereUpdatedAt($value)
 */
	class Event extends \Eloquent {}
}

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server[] $servers
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
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

