# Firewall-
Implementation of your Personal firewall logic. It includes methods to add rules, monitor connections, and allow/deny based on predefined rules.

## Step for Execution and Working

1. **Install PHP**

   Ensure PHP is installed on your system. You can verify this by running
```
php -v
```

2. **Create the Firewall Script**

   Save the PHP code in a file, for example, `custom_firewall.php`.

3. **Run the Firewall**

   Use the PHP built-in server or CLI to execute the script.
```
php custom_firewall.php
```

4. **Test the Firewall**

  * Use a network tool like `telnet` or `nc` to test the firewall:
  ```
  telnet 127.0.0.1 9999
  ```
  * Replace `127.0.0.1` with the IP you want to simulate as the client and port `9999` with the listening port.
    
5. **Behavior**

  * If the connection matches an "allow" rule, the message `Connection allowed by firewall`. will appear.
  
  * If the connection matches a "deny" rule or no rule matches, the message `Connection denied by firewall`. will be sent.


## How It Works

1. **Rule Matching**:
    
  Each connection is checked against predefined rules. If the IP and port match and the rule allows it, the connection is accepted.

2. **Default Deny Policy**:
   
  If no rules match, the connection is denied by default.

3. **Stream Sockets**:
  
  The PHP `stream_socket_server` function is used to create a TCP server that listens for incoming connections.
