<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\User{
/**
 * App\Models\User\Role
 *
 * @property string $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\Team
 *
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string $owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property-read string $email
 * @property-read \App\Models\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team whereCardBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team whereCardLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Team whereUpdatedAt($value)
 */
	class Team extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\Subscription
 *
 * @property string $id
 * @property string $team_id
 * @property string $name
 * @property string|null $stripe_id
 * @property string|null $stripe_status
 * @property string $stripe_plan
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $trial_ends_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User\Team $owner
 * @property-read \App\Models\Subscription\Plan $plan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription\Usage[] $usage
 * @property-read int|null $usage_count
 * @property-read \App\Models\User\Team $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription cancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription ended()
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription incomplete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription notCancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription notOnGracePeriod()
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription notOnTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription onGracePeriod()
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription onTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription pastDue()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Laravel\Cashier\Subscription recurring()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereStripePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereStripeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Subscription whereUpdatedAt($value)
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\Permission
 *
 * @property string $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models\User{
/**
 * App\Models\User\SourceProvider
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $type
 * @property string $access_token
 * @property string $provider_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider whereProviderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\SourceProvider whereUserId($value)
 */
	class SourceProvider extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Script
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string|null $description
 * @property bool $public
 * @property bool $multiple_execution
 * @property string $script
 * @property array|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server[] $servers
 * @property-read int|null $servers_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script onlyPublic()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script whereMultipleExecution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script whereScript($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Script whereUserId($value)
 */
	class Script extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Server
 *
 * @property string $id
 * @property string $user_id
 * @property string $team_id
 * @property string $name
 * @property string $ip
 * @property int $ssh_port
 * @property string|null $sudo_password
 * @property array|null $meta
 * @property array|null $os_information
 * @property string $public_key
 * @property string $private_key
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $configuring_job_dispatched_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Action[] $actions
 * @property-read int|null $actions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Alert[] $alerts
 * @property-read int|null $alerts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Event[] $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Firewall\Rule[] $firewallRules
 * @property-read int|null $firewall_rules_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Module[] $modules
 * @property-read int|null $modules_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Ping[] $pings
 * @property-read int|null $pings_count
 * @property-write mixed $keypair
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Site[] $sites
 * @property-read int|null $sites_count
 * @property-read \App\Models\Server\Task $task
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Task[] $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User\Team $team
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server configured()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereConfiguringJobDispatchedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereOsInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePrivateKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePublicKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereSshPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereSudoPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server withMonitoring()
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
 * App\Models\Server\Record
 *
 * @property string $id
 * @property string $server_id
 * @property string $module_id
 * @property string $model
 * @property string|null $feature
 * @property string $key
 * @property array|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server\Module $module
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record forServer(\App\Models\Server $server)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record whereFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Record whereUpdatedAt($value)
 */
	class Record extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\Action
 *
 * @property string $id
 * @property string $server_id
 * @property string $module
 * @property string $class
 * @property string $action
 * @property array|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action forServer(\App\Models\Server $server)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Action whereUpdatedAt($value)
 */
	class Action extends \Eloquent {}
}

namespace App\Models\Server\User{
/**
 * App\Models\Server\User\PublicKey
 *
 * @property string $id
 * @property string $server_user_id
 * @property string $name
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User\PublicKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User\PublicKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User\PublicKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User\PublicKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User\PublicKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User\PublicKey whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User\PublicKey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User\PublicKey whereServerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User\PublicKey whereUpdatedAt($value)
 */
	class PublicKey extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\Module
 *
 * @property string $id
 * @property string $server_id
 * @property string $name
 * @property string $status
 * @property array|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module forServer(\App\Models\Server $server)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Module whereUpdatedAt($value)
 */
	class Module extends \Eloquent {}
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
 * @property-read \App\Models\Server\Task|null $owner
 * @property-read \App\Models\Server $server
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task for($class)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task forServer(\App\Models\Server $server)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Server\Task newModelQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Server\Task newQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Server\Task query()
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Task withCacheCooldownSeconds($seconds = null)
 */
	class Task extends \Eloquent {}
}

namespace App\Models\Server\Firewall{
/**
 * App\Models\Server\Firewall\Rule
 *
 * @property string $id
 * @property string $server_id
 * @property bool $editable
 * @property string $name
 * @property string|null $port
 * @property string|null $protocol
 * @property string|null $from
 * @property string $policy
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Firewall\Rule forServer(\App\Models\Server $server)
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
 * App\Models\Server\Alert
 *
 * @property string $id
 * @property string $server_id
 * @property string $level
 * @property string $type
 * @property string $exception
 * @property array $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert forServer(\App\Models\Server $server)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert whereException($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Alert whereUpdatedAt($value)
 */
	class Alert extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\Deployment
 *
 * @property string $id
 * @property string $server_id
 * @property string|null $owner_type
 * @property string|null $owner_id
 * @property string|null $initiator_id
 * @property string|null $branch
 * @property string $commit_hash
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $initiator
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $owner
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment forServer(\App\Models\Server $server)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment whereBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment whereCommitHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment whereInitiatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Deployment whereUpdatedAt($value)
 */
	class Deployment extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\Site
 *
 * @property string $id
 * @property string $server_id
 * @property string $module_id
 * @property string $user_id
 * @property string $token
 * @property string $domain
 * @property array|null $aliases
 * @property array|null $environment
 * @property string $public_dir
 * @property string|null $repository
 * @property string|null $repository_provider
 * @property string|null $repository_branch
 * @property bool $use_ssl
 * @property \Illuminate\Support\Carbon|null $domain_expires_at
 * @property \Illuminate\Support\Carbon|null $ssl_certificate_expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Deployment[] $deployments
 * @property-read int|null $deployments_count
 * @property-read \App\Models\Server $server
 * @property-read \App\Models\User\SourceProvider|null $sourceProvider
 * @property-read \App\Models\Server\Task $task
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site forServer(\App\Models\Server $server)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereAliases($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereDomainExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereEnvironment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site wherePublicDir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereRepository($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereRepositoryBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereRepositoryProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereSslCertificateExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereUseSsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Site withMonitoring()
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
 * @property array|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Event whereUpdatedAt($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\Ping
 *
 * @property string $server_id
 * @property bool $success
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Server $server
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Ping forServer(\App\Models\Server $server)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Ping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Ping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Ping query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Ping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Ping whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\Ping whereSuccess($value)
 */
	class Ping extends \Eloquent {}
}

namespace App\Models\Server{
/**
 * App\Models\Server\User
 *
 * @property string $id
 * @property string $server_id
 * @property string $name
 * @property mixed|string $sudo_password
 * @property string $public_key
 * @property string $private_key
 * @property string|null $home_dir
 * @property bool $sudo
 * @property bool $is_system
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\User\PublicKey[] $keys
 * @property-read int|null $keys_count
 * @property-read \App\Models\Server $server
 * @property-write mixed $keypair
 * @property-read \App\Models\Server\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User forServer(\App\Models\Server $server)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User whereHomeDir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User whereIsSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User wherePrivateKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User wherePublicKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User whereSudo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User whereSudoPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models\Subscription{
/**
 * App\Models\Subscription\Plan
 *
 * @property string $id
 * @property string $name
 * @property bool $is_active
 * @property float $price
 * @property string $currency
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription\Plan\Feature[] $features
 * @property-read int|null $features_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan disableCache()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Subscription\Plan newModelQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Subscription\Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan onlyActive()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Subscription\Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan withCacheCooldownSeconds($seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan withMonitoring()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan withoutFree()
 */
	class Plan extends \Eloquent {}
}

namespace App\Models\Subscription{
/**
 * App\Models\Subscription\Usage
 *
 * @property string $id
 * @property string $team_id
 * @property string $code
 * @property int $used
 * @property \Illuminate\Support\Carbon|null $valid_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Usage byFeature($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Usage disableCache()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Subscription\Usage newModelQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Subscription\Usage newQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Subscription\Usage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Usage whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Usage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Usage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Usage whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Usage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Usage whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Usage whereValidUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Usage withCacheCooldownSeconds($seconds = null)
 */
	class Usage extends \Eloquent {}
}

namespace App\Models\Subscription\Plan{
/**
 * App\Models\Subscription\Plan\Feature
 *
 * @property string $id
 * @property int $plan_id
 * @property string $code
 * @property string $value
 * @property bool $renewable
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Subscription\Plan $plan
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature disableCache()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Subscription\Plan\Feature newModelQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Subscription\Plan\Feature newQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Subscription\Plan\Feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature whereRenewable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription\Plan\Feature withCacheCooldownSeconds($seconds = null)
 */
	class Feature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string|null $company
 * @property string|null $address
 * @property string $email
 * @property string $lang
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $last_alert_received_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\Team[] $rolesTeams
 * @property-read int|null $roles_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Script[] $scripts
 * @property-read int|null $scripts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server[] $servers
 * @property-read int|null $servers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Server\Site[] $sites
 * @property-read int|null $sites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\SourceProvider[] $sourceProviders
 * @property-read int|null $source_providers_count
 * @property-read \App\Models\User\Team $team
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastAlertReceivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

