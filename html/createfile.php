<?php
function openSheet($filename, $url){
	if(!ini_set('default_socket_timeout', 15)) echo "<!-- unable to change socket timeout -->";
	if (($handle = fopen($url, "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
	        $list_data[] = $data;
	    }
	    fclose($handle);

	    createFile($filename, $list_data);

	}
	else
	    die("Problem reading csv");
}

function createFile($filename, $contents) {
	file_put_contents($filename.'.php', '<?php $'.$filename.' = ' . var_export($contents, true) . '; ?>');
}

openSheet("list_data", "https://docs.google.com/spreadsheets/d/1XH7dhbLBM7yQvZ4MoWbIZ4WaJ2jw0Vj1B9xezkimBVU/pub?gid=0&single=true&output=csv");
openSheet("info_data", "https://docs.google.com/spreadsheets/d/1XH7dhbLBM7yQvZ4MoWbIZ4WaJ2jw0Vj1B9xezkimBVU/pub?gid=2052396963&single=true&output=csv");
openSheet("weather_data", "https://docs.google.com/spreadsheets/d/1XH7dhbLBM7yQvZ4MoWbIZ4WaJ2jw0Vj1B9xezkimBVU/pub?gid=1439033665&single=true&output=csv");
openSheet("days_data", "https://docs.google.com/spreadsheets/d/1XH7dhbLBM7yQvZ4MoWbIZ4WaJ2jw0Vj1B9xezkimBVU/pub?gid=379627954&single=true&output=csv");
$weather_api_data = createFile("weather_api_data", file_get_contents("http://api.openweathermap.org/data/2.5/weather?zip=11216,us&units=imperial&appid=aed09d2972194babc2f6de6803a782fc"));

?>