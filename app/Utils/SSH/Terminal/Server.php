<?php

namespace App\Utils\SSH\Terminal;

use Illuminate\Support\Facades\DB;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;
use Symfony\Component\Console\Output\OutputInterface;

class Server implements MessageComponentInterface
{
    /**
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;

    /**
     * @var SplObjectStorage
     */
    private $clients;

    /**
     * @var Connection[]
     */
    private $connections = [];

    /**
     * Server constructor.
     *
     * @param SplObjectStorage $clients
     * @param OutputInterface $output
     */
    public function __construct(SplObjectStorage $clients, OutputInterface $output)
    {
        $this->clients = $clients;
        $this->output = $output;
    }

    /**
     * When a new connection is opened it will be passed to this method
     *
     * @param ConnectionInterface $conn The socket/connection that just connected to your application
     *
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        $this->connections[$conn->resourceId] = new Connection();
        $this->connections[$conn->resourceId]->open();

        $this->sendMessage($conn, 'Connection opened');
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not
     * result in an error if it has already been closed.
     *
     * @param ConnectionInterface $conn The socket/connection that is closing/closed
     *
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        $this->getConnectionInstanceFor($conn)->close();
        unset($this->connections[$conn->resourceId]);

        $this->clients->detach($conn);

        $this->output->writeln('Connection closed');
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through
     * this method
     *
     * @param ConnectionInterface $conn
     * @param \Exception $e
     *
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->output->writeln($e->getMessage());

        $this->onClose($conn);
    }

    /**
     * Triggered when a client sends data through the socket
     *
     * @param \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param string $msg The message received
     *
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $this->output->writeln(sprintf('Message sent [%s]', $msg));

        $data = $this->parseMessage($msg);

        $command = $data['command'];
        $connection = $this->getConnectionInstanceFor($from);

        switch ($command) {
            case 'message':
                $connection->runScript($from, $data['message']);
                break;

            case 'auth':
                $this->connectToSsh($from, $data['id']);
                $connection->listenSSH($from);

                break;
        }

        $connection->listenSSH($from);
    }

    /**
     * @param ConnectionInterface $conn
     *
     * @return Connection
     */
    protected function getConnectionInstanceFor(ConnectionInterface $conn): Connection
    {
        return $this->connections[$conn->resourceId] ?? new Connection();
    }

    /**
     * Decode message
     *
     * @param string $message
     *
     * @return array
     */
    protected function parseMessage(string $message): array
    {
        $data = \GuzzleHttp\json_decode($message, true);

        if (!isset($data['command'])) {
            throw new \InvalidArgumentException('Request does not contains command key');
        }

        return $data;
    }

    /**
     * Load server by ID
     *
     * @param string $id
     *
     * @return \App\Models\Server
     */
    protected function loadServer(string $id)
    {
        DB::reconnect();

        return DB::table('servers')->select('ip', 'ssh_port', 'name')->where('id', $id)->first();
        // \App\Models\Server::findOrFail($id);
    }

    /**
     * Send message to the client
     *
     * @param ConnectionInterface $from
     * @param string $message .
     */
    protected function sendMessage(ConnectionInterface $from, string $message): void
    {
        //$from->send(mb_convert_encoding($message, "UTF-8"));
        $this->output->writeln($message);
    }

    /**
     * Connect to SSH by ID
     *
     * @param ConnectionInterface $from
     * @param string $id
     */
    private function connectToSsh(ConnectionInterface $from, string $id): void
    {
        $server = $this->loadServer($id);

        $this->sendMessage($from, sprintf('Connecting to the server [%s]...', $server->name));

        $session = ssh2_connect($server->ip, $server->ssh_port);

//        $publicKey = '~/.ssh/id_rsa.pub'; //$server->publicKey()->getPath();
//        $privateKey = '~/.ssh/id_rsa'; //$server->privateKey()->getPath();
//
//        $this->sendMessage($from, sprintf('Using public key [%s]...', $publicKey));

        ssh2_auth_pubkey_file($session, 'root', $this->getKeyPath('id_rsa.pub'), $this->getKeyPath('id_rsa'));
        $shell = ssh2_shell($session, 'xterm', null, 80, 40, SSH2_TERM_UNIT_CHARS);

        $this->sendMessage($from, 'Connected...');

        sleep(1);

        $this->getConnectionInstanceFor($from)
            ->setSshConnection($session)
            ->setSshShell($shell);
    }

    /**
     * @param string $key
     * @return string
     */
    protected function getKeyPath(string $key)
    {
        return '~/.ssh/' . $key;
    }
}