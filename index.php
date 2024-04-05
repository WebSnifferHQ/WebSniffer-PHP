<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>HTTP Header Checker Tool by WebSniffer</title>
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
}
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
}
form {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 500px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
label, select, input[type="text"], input[type="submit"] {
    margin: 10px 0;
}
input[type="text"], select {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
input[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
input[type="submit"]:hover {
    background-color: #0056b3;
}
@media (max-width: 600px) {
    form {
        width: 90%;
        margin: 20px;
    }
}
</style>
</head>
<body>
<div class="container">
<h1>HTTP Header Checker Tool</h1>
<form method="post">
<label for="url">Enter a website URL:</label>
<input type="text" id="url" name="url" required>
<br>
<label for="request">Choose a request type:</label>
<select id="request" name="request">
<option value="GET">GET</option>
<option value="POST">POST</option>
</select>
<br>
<input type="submit" value="Submit">
</form>
<p style="max-width: 500px;">The HTTP Header Checker tool allows you to check the HTTP headers of any web page. Simply enter the URL of the website you wish to inspect and select the request type (GET or POST). The tool will then display the HTTP response headers and content of the page. This service is <a href="https://github.com/WebSnifferHQ/WebSniffer-PHP" title="GitHub repo" target="_blank">open-source</a>, provided under the MIT license, and freely offered by <a href="https://websniffer.com/" title="WebSniffer" target="_blank">WebSniffer</a>.</p>
</div>

<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the URL and request type from the form input
    $url = $_POST["url"];
    $request_type = $_POST["request"];

    // Send a GET or POST request to the URL
    if ($request_type == "GET") {
        $response = file_get_contents($url);
    } elseif ($request_type == "POST") {
        $data = array('key1' => 'value1', 'key2' => 'value2');
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
    }

    // Get the HTTP response header and content
    $http_response_header = $http_response_header ?? null;
    $http_response_content = $response ?? null;

    // Display the HTTP response header and content
    echo "<h2>HTTP Response Header:</h2>";
    echo "<pre>";
    if (is_array($http_response_header)) {
        foreach ($http_response_header as $header) {
            echo htmlspecialchars($header) . "\n";
        }
    }
    echo "</pre>";
    echo "<h2>HTTP Response Content:</h2>";
    echo "<pre>";
    echo htmlentities($http_response_content);
    echo "</pre>";
}
?>

</body>
</html>
