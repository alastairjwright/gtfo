<!DOCTYPE html>
<html>
<head>
	<title>GTFO.nyc</title>

	<meta charset="UTF-8">
	<meta name="description" content="GTFO is a current list of stuff to do in NYC. We try to let you know about stuff before it sells out.s">
	<meta name="keywords" content="NYC,New York,List,Activities,things to do, NYC Parties, NYC Festivals, NYC shows, Things to do in NYC, Weekend activies, NYC galleries">
	<meta name="author" content="Nirmala Shome">

	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="GTFO.nyc" />
	<meta property="og:description" content="GTFO is a current list of stuff to do in NYC. We try to let you know about stuff before it sells out." />
	<meta property="og:url" content="http://gtfo-nyc.com/" />
	<meta property="og:site_name" content="GTFO.nyc" />
	<meta property="og:image" content="http://gtfo-nyc.com/assets/images/logo-large.jpg" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="GTFO is a current list of stuff to do in NYC. We try to let you know about stuff before it sells out." />
	<meta name="twitter:title" content="GTFO.nyc" />
	<meta name="twitter:site" content="@gtfonyc" />
	<meta name="twitter:creator" content="@gtfonyc" />

	<link rel="shortcut icon" href="favicon.ico" />
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:700|Roboto+Mono|Roboto:300,400,700" rel="stylesheet">
	<link href="assets/styles/main.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php

function openSheet($url){
	if(!ini_set('default_socket_timeout', 15)) echo "<!-- unable to change socket timeout -->";
	if (($handle = fopen($url, "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	        $list_data[] = $data;
	    }
	    fclose($handle);

	    echo '<pre>' . print_r( $data, 1 ) . '</pre>';

	    return $list_data;
	}
	else
	    die("Problem reading csv");
}

// rearrange csv data to read vertically
function rearrange($spreadsheet_data) {
	$data = array();
	foreach ($spreadsheet_data as $key => $row) {
		foreach ($row as $key => $cell) {
			if (!empty($cell)) {
				if (!array_key_exists($key, $data)) $data[$key] = array();
				array_push($data[$key], $cell);
			}
		}
	}
	return $data;
}

$list_data = rearrange(openSheet("https://docs.google.com/spreadsheets/d/1XH7dhbLBM7yQvZ4MoWbIZ4WaJ2jw0Vj1B9xezkimBVU/pub?gid=0&single=true&output=csv"));
$info_data = rearrange(openSheet("https://docs.google.com/spreadsheets/d/1XH7dhbLBM7yQvZ4MoWbIZ4WaJ2jw0Vj1B9xezkimBVU/pub?gid=2052396963&single=true&output=csv"));
$weather_data = openSheet("https://docs.google.com/spreadsheets/d/1XH7dhbLBM7yQvZ4MoWbIZ4WaJ2jw0Vj1B9xezkimBVU/pub?gid=1439033665&single=true&output=csv");
$days_data = openSheet("https://docs.google.com/spreadsheets/d/1XH7dhbLBM7yQvZ4MoWbIZ4WaJ2jw0Vj1B9xezkimBVU/pub?gid=379627954&single=true&output=csv");
$weather_api_data = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?zip=11216,us&units=imperial&appid=aed09d2972194babc2f6de6803a782fc"));

$weather_icons = array();
foreach ($weather_data as $key => $row) {
	if (!array_key_exists($row[3], $weather_icons)) $weather_icons[$row[3]] = array();
	array_push($weather_icons[$row[3]], $row[4]);
}

$days_text = array();
foreach ($days_data as $key => $row) {
	if (!array_key_exists($row[0], $days_text)) $days_text[$row[0]] = array();
	array_push($days_text[$row[0]], $row[1]);
}

$current_temp_imperial = $weather_api_data->main->temp;
$current_temp_mertric = ($current_temp_imperial - 32) * (5/9);
$current_weather_icon = $weather_api_data->weather[0]->icon;
$current_weather_icon_code = substr($current_weather_icon, 0, 2);
$current_weather_emoji = $weather_icons[$current_weather_icon_code][0];

// echo '<pre>' . print_r( $weather_icons, 1 ) . '</pre>';

// build list html
$list_html = "";
foreach ($list_data as $key => $row) {
	if ($key === 0) { // banner text
		foreach ($row as $key => $cell) {
			if ($key === 1) {
				$banner = $cell;
			}
		}
	} else {
		$list_html .= '<div>';
		foreach ($row as $key => $cell) {
			if ($key === 0) {
				$list_html .= '<h1>'.$cell.'</h1>';
			} else {
				$list_html .= '<p>'.$cell.'</p>';
			}

		}
		$list_html .= '</div>';
	}
}

$info_html = "";
foreach ($info_data as $key => $row) {
	foreach ($row as $key => $cell) {
		$info_html .= '<h1>'.$cell.'</h1>';
	}
}

?>

<div class="site-container">
	<div class="banner">
		<div class="holder">
			<p class="scroll"><?php echo $banner; ?></p>
		</div>
	</div>

	<img id="logo" src="./assets/images/logo.jpg">

	<div class="list">
		<?php
			if (isset($current_temp_mertric) && isset($current_temp_imperial) && isset($days_text)) {
				echo '<div>';
				echo '<h1>'.round($current_temp_mertric).'°C ('.round($current_temp_imperial).'°F) '.$current_weather_emoji.'</h1>';
				echo '<p>'.$days_text[date("N")][0].'</p>';
				echo '</div>';
			}
		?>
		<?php echo $list_html; ?>
	</div>

	<div class="signup">
		<div class="rotate">
			<form action="//today.us14.list-manage.com/subscribe/post?u=e6bc99b1fc4dac4023beeaebf&amp;id=d755eaee5b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			    <div id="mc_embed_signup_scroll">
					<h2>To stay up to date.</h2>
					<div class="mc-field-group">
						<input type="email" value="enter ur email" name="EMAIL" class="required email" id="mce-EMAIL">
					</div>
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>
					<div style="position: absolute; left: -5000px;" aria-hidden="true">
						<input type="text" name="b_e6bc99b1fc4dac4023beeaebf_d755eaee5b" tabindex="-1" value="">
					</div>
					<div class="clear">
						<input type="submit" value="SUBSCRIBE >" name="subscribe" id="mc-embedded-subscribe" class="button">
					</div>
			    </div>
			</form>
		</div>
		<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
	</div>

	<div id="infoBackground">
		<div id="infoContent">
			<?php echo $info_html; ?>
		</div>
	</div>

	<footer>
		<a href="javascript:void(0);" id="infoButton">INFO</a>
		<a href="mailto:gtfo.nyc@gmail.com" id="contactButton">CONTACT</a>
	</footer>
</div>
</body>
<script type="text/javascript" src="./assets/scripts/libraries.js"></script>
<script type="text/javascript" src="./assets/scripts/bundle.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-101641399-1', 'auto');
  ga('send', 'pageview');

</script>
</html>