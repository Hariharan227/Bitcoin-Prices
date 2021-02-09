<?php
	// Refresh the page every 5 seconds
    $url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 5; URL=$url1");
?>

<html>
	<head>
		<link rel='stylesheet' type='text/css' href='css/style.css'>
	</head>

	<body>
		<header>
			<?php
				// Display the last updated time
				date_default_timezone_set('Asia/Kolkata');
				$t=date('d-m-y h:i:s a');
				echo("Last Updated: " . $t . " IST<br>");
				echo "<br />";

				// Define the URL variables
				$api_url1 = 'http://api.coindesk.com/v1/bpi/currentprice.json';
				$api_url2 = 'http://api.exchangeratesapi.io/latest';

				// Read JSON file
				$json_data1 = file_get_contents($api_url1);
				$json_data2 = file_get_contents($api_url2);

				// Decode JSON data into PHP array
				$response_data1 = json_decode($json_data1);
				$response_data2 = json_decode($json_data2);

				// Extract the required data
				$bitcoin_EUR_value = $response_data1->bpi->EUR->rate_float;
				$country_data = $response_data2->rates;

				// incr is for managing box orientation in the page
				$incr = 0;

				// Traverse array and display the data
				foreach ($country_data as $key => $value) 
				{
					if($incr%3==0)
					{
						echo "<div class=\"mainleft\">";
					}
					if($incr%3==1)
					{
						echo "<div class=\"mainmid\">";
					}
					if($incr%3==2)
					{
						echo "<div class=\"mainright\">";
					}
					echo "Country: ".$key;
					echo "<br />";
					// Convert EUR bitcoin value to the specific country's bitcoin value by multiplying its exchange rate
					$bitcoin_converted_value = $bitcoin_EUR_value * $value;
					echo "Price: ".$bitcoin_converted_value;
					echo "</div>";
					$incr++;
				}
			?>
		</header>
	</body>
</html>