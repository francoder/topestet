<?
	//pr($_GET);
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	if ($_GET['street_id'] != 'false'){
		$result = file_get_contents('http://mobidiktaxi.ru/kladr/sughouses.php?streetid=13380&word=' . urlencode($_GET['search']));
		echo $result;
		echo (json_decode($result, true));
		
		//echo $url;
	}
		
	echo json_encode($response);
	
	function pr($data){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
?>