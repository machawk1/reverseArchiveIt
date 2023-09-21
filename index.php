<?php
	//echo $_GET['secret'];
	//echo file_get_contents("http://google.com");

	$ourFileName = "testFile.txt";
	$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
	fclose($ourFileHandle);

	if(!isset($_GET['url'])){echo "No Collection have this archive.";return;}
	
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	//$archiveitSearchUrl = "http://archive-it.org/public/search.html?host=&query=".urlencode($_GET['url']);
	$archiveitSearchUrl = "https://archive-it.org/explore?show=Collections&q=".urlencode($_GET['url']);
	

	$html = getURL($archiveitSearchUrl);

	//$html = "( http://wayback.archive-it.org/2438/ ) \\ http://wayback.archive-it.org/1234/ asd";
	preg_match_all("/\/collections\/[0-9]+/im",$html,$matches); //get all collections with archive-it urls intact
	$urls = $matches[0];
	$collectionNumbers = array();
	$titles = array();
	$collectionStr = "";
	
	foreach($urls as $ii=>$url){
		preg_match("/[0-9]+",$url,$collection);
		array_push($collectionNumbers,$collection[0]);
		$collectionPage = getURL("https://archive-it.org/public/collection.html?id=".$collection[0]); //get title of collection
		
		preg_match("/\<h1\>\sCOLLECTION\:(.*)\<\/h1\>/i",$collectionPage,$title);		
		array_push($titles,$title[1]);
		$collectionStr .= "<collection><id>".$collection[0]."</id><name>".$title[1]."</name></collection>";
		//$collectionStr .= "<li><a href=\"http://archive-it.org/collections/".$collection[0]."\">".$title[1]."</a></li>";
	}
	echo $collectionStr;
	
	
	function getURL($url){
		$curl_handle=curl_init();
		curl_setopt($curl_handle, CURLOPT_URL,$url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		$query = curl_exec($curl_handle);
		curl_close($curl_handle);
		return $query;
	}
	
	
?>
