<?php

namespace Domain\User\Services;

use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Subscription\Plan;

class RegisterUser
{
    /**
     * @var string
     */
    protected $project;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string|null
     */
    protected $company;

    /**
     * @param StoreRequest $request
     * @return User
     * @throws \Throwable
     */
    public static function fromRequest(StoreRequest $request)
    {
        $data = $request->validated();

        return (new static($data['project_name'], $data['name'], $data['email'], $data['password']))->register();
    }

    /**
     * @param string $project
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string|null $company
     */
    public function __construct(string $project, string $name, string $email, string $password, ?string $company = null)
    {
        $this->project = $project;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->company = $company;
    }

    /**
     * @return User
     * @throws \Throwable
     */
    public function register(): User
    {
        return DB::transaction(function () {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'company' => $this->company,
                'password' => Hash::make($this->password),
            ]);

            $team = User\Team::create([
                'name' => $this->project,
                'owner_id' => $user->id
            ]);

            $owner = User\Role::where('name', 'owner')->firstOrFail();
            $user->attachRole($owner, $team);

            $team->subscribeTo(
                Plan::findByName(
                    config('auth.subscription.default_plan')
                )
            );

            return $user;
        });
    }
}