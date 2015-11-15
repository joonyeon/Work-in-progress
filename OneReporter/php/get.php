<?
//add({timestamp:1364425232, time:"2013-03-28 00:00:32", args:{ts:"1364421960744",temp:"20.26",valve:"1.0000",out:"-0.38",out_temp:"-0.38",fluidin_temp:"46.5",device_temp:"16.44",fluidout_temp:"43.56",sklenik_temp:"12.19",zem_temp:"18.87",dht11_temp:"12",dht11_humidity:"93",light_value:"0",wet_value:"982",mq9_value:"584",relay_value:"0"}});

  if ($_SERVER["QUERY_STRING"] == "report" )
  {
    require "db.php";
    echo("{\"hosts\":\n");
    getHosts();
    echo(",\"devices\":\n");
    getDevices();
    echo(",\"variables\":\n");
    getVariables();
    echo("}");
    die();
  }
  if ($_SERVER["QUERY_STRING"] == "all" )
  { 
    require "db.php";
    echo ("<pre>Devices:\n");
    getDevices();
    echo ("Hosts:\n");
    getHosts();
    echo ("Variables:\n");
    getVariables();
    echo ("DeviceLog:\n");
    getDeviceLog();
    echo ("HostLog:\n");
    getHostLog();
    echo ("VariableLog:\n");
    getVariableLog();
    echo ("</pre>");
    die();
  }
	$from = isset($_GET["from"]) ? $_GET["from"] : "0000000000000";

	if ( strlen($from) != 10 )
	{
		$from = "0000000000";
		//die( "alert('invalid from value')");
	}

  $f = fopen("data/".$_GET["day"].".txt", "r");
	while (!feof($f))
	{
		$line = fgets( $f );
		$ts = strstr($line, "{ts:");
		if ( $ts )
		{
			$ts = substr($ts, 10-6, 10);
			if ( $ts > $from )
				echo($line);
		}
	}
	fclose($f);
?>