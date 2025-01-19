<?php
class Fire_wall {
    private $rules = [];

    // Method to add rules
    public function addRule($ipAddress, $port, $allow) {
        $this->rules[] = [
            'ipAddress' => $ipAddress,
            'port' => $port,
            'allow' => $allow
        ];
    }

    // Method to monitor and filter traffic
    public function startFirewall($listeningPort) {
        $socket = @stream_socket_server("tcp://0.0.0.0:$listeningPort", $errno, $errstr);
        
        if (!$socket) {
            echo "Error: $errstr ($errno)\n";
            return;
        }

        echo "Firewall is active on port $listeningPort\n";

        while (true) {
            $client = @stream_socket_accept($socket);

            if ($client) {
                $peerName = stream_socket_get_name($client, true);
                list($clientIP, $clientPort) = explode(':', $peerName);

                if ($this->isAllowed($clientIP, (int)$clientPort)) {
                    echo "Connection allowed from $clientIP:$clientPort\n";
                    fwrite($client, "Connection allowed by firewall.\n");
                } else {
                    echo "Connection denied from $clientIP:$clientPort\n";
                    fwrite($client, "Connection denied by firewall.\n");
                }

                fclose($client);
            }
        }

        fclose($socket);
    }

    // Method to check if a connection is allowed based on rules
    private function isAllowed($ipAddress, $port) {
        foreach ($this->rules as $rule) {
            if ($rule['ipAddress'] === $ipAddress && $rule['port'] === $port) {
                return $rule['allow'];
            }
        }
        return false; // Default to deny if no rule matches
    }
}

// Usage example
$firewall = new Fire_wall();

// Adding rules: allow or deny specific IP and port
$firewall->addRule("192.168.1.10", 8080, true); // Allow specific IP and port
$firewall->addRule("192.168.1.11", 8081, false); // Deny specific IP and port

// Start firewall on a specific port
$firewall->startFirewall(9999); // Listening on port 9999 for incoming connections
?>

