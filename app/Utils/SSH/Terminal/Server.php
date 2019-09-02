<?php

namespace App\Utils\SSH\Terminal;

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

        $this->connections[$conn->resourceId] = $connection = new Connection();
        $connection->open();

        $this->output->writeln('Connection opened');
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
        $conn->close();
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

        try {
            $data = $this->parseMessage($msg);
        } catch (\Exception $e) {
            $this->sendMessage($e->getMessage());
            $from->close();

            return;
        }

        $command = $data['command'];

        $connection = $this->getConnectionInstanceFor($from);

        switch ($command) {
            case 'message':
                $connection->runScript($from, $data['message']);
                break;

            case 'auth':
                if ($this->connectToSsh($from, $data['public_key'])) {
                    $this->sendMessage($from, 'Connected....');
                    $connection->listenSSH($from);
                } else {
                    $this->sendMessage($from, "Error, can not connect to the server. Check the credentials");
                    $from->close();
                }

                break;

            default:
                $connection->listenSSH($from);

                break;
        }
    }

    /**
     * @param ConnectionInterface $conn
     *
     * @return Connection
     */
    protected function getConnectionInstanceFor(ConnectionInterface $conn): Connection
    {
        if (isset($this->connections[$conn->resourceId])) {
            return $this->connections[$conn->resourceId];
        }

        return new Connection();
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
     * Load server by public key
     *
     * @param string $key
     *
     * @return \App\Models\Server
     */
    protected function loadServer(string $key): \App\Models\Server
    {
        return \App\Models\Server::where('public_key', $key)->firstOrFail();
    }

    /**
     * Send message to the client
     *
     * @param ConnectionInterface $from
     * @param string $message .
     */
    protected function sendMessage(ConnectionInterface $from, string $message): void
    {
        $from->send(mb_convert_encoding($message, "UTF-8"));
    }

    /**
     * Connect to SSH by public key
     *
     * @param ConnectionInterface $from
     * @param string $key
     *
     * @return bool
     */
    private function connectToSsh(ConnectionInterface $from, string $key): bool
    {
        $server = $this->loadServer($key);

        $session = ssh2_connect($server->ip, $server->ssh_port);

        if (!ssh2_auth_hostbased_file($session, 'root', $server->ip, $server->publicKey()->getPath(), $server->privateKey()->getPath())) {
            $shell = ssh2_shell($session, 'xterm', null, 1000, 40, SSH2_TERM_UNIT_CHARS);

            sleep(1);

            $this->getConnectionInstanceFor($from)->setSshShell($shell);

            return true;
        }

        return false;
    }
}
