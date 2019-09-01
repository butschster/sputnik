<?php

namespace App\Console\Commands\Fake;

use App\Models\Server;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Contracts\Request\RequestSignatureHandler;

class FakeServerInstallator extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'fake:server-install {server}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run fake server installer';

    /**
     * @var RequestSignatureHandler
     */
    protected $signatureHandler;

    /**
     * @var Client
     */
    protected $client;

    public function __construct(RequestSignatureHandler $signatureHandler, Client $client)
    {
        parent::__construct();

        $this->signatureHandler = $signatureHandler;
        $this->client = $client;
    }

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        $server = Server::findOrFail($this->argument('server'));

        if ($server->isPending()) {
            $this->sentRequest('server.keys_installed', ['server_id' => $server->id]);
            sleep(10);
            $this->sentRequest('server.information', ['server_id' => $server->id, 'os' => 'Ubuntu', 'version' => '18.04', 'architecture' => '64']);
            sleep(10);
        }

        $server->refresh();

        if ($server->isConfiguring()) {
            $events = [
                'ssh.configured' => 10,
                'users.created' => 20,
                'supervisor.installed' => 30,
                'firewall.configured' => 40,
                'swap.created' => 50,
                'base.installed' => 60,
                'php.installed' => 80,
                'database.installed' => 80,
            ];

            foreach ($events as $event => $progress) {
                $this->sentRequest('server.event', [
                    'server_id' => $server->id, 'message' => $event, 'progress' => $progress,
                ]);
                sleep(2);
            }
        }

        $server->refresh();

        $server->markAsConfigured();
    }

    /**
     * @param string $action
     * @param array $parameters
     * @param int $lifeTime
     * @return int|\Psr\Http\Message\ResponseInterface
     */
    public function sentRequest(string $action, array $parameters = [], int $lifeTime = 60): \Psr\Http\Message\ResponseInterface
    {
        $parameters = array_merge(
            $parameters,
            $this->signatureHandler->signParameters(
                ['action' => $action],
                now()->addMinutes($lifeTime)
            )
        );

        return $this->client->post(route('callback'), [
            'form_params' => $parameters,
        ]);
    }
}