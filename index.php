<!DOCTYPE html>
<html>
<head>
    <title>HTTP Request Program</title>
</head>
<body>
    <h1>HTTP Request Program</h1>
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
            print_r($http_response_header);
            echo "</pre>";
            echo "<h2>HTTP Response Content:</h2>";
            echo "<pre>";
            echo htmlentities($http_response_content);
            echo "</pre>";
        }
    ?>
</body>
</html>
