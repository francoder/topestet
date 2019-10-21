<?foreach ($clinics_for_map as $i => $object){
	$coor = explode(' ', $object['User']['coor']);
	$objects[] = array(
	    'geometry' => array(
	    	'type' => "Point",
	    	'coordinates' => array($coor[1], $coor[0])
	    ),
	    'properties' => array(
	    	'hintContent' => $object['User']['name'],
	    	'balloonContentHeader' => $object['User']['name'],
	    	'balloonContentBody' => '<p align="center">' . $object['User']['profession'] . '<br><img src="' . $this->Element("image", array("model" => "user", "type" => "mini", "alias" => "avatar", "id" => $object['User']['id'], "onlyurl" => true)) . '"><br><a href="/' . (($object['User']['is_specialist'] == 1)?'specialist':'clinic') . '/profile/' . $object['User']['id'] . '/" target="_blanc">перейти &rarr;</a></p>',
	    	'clusterCaption' => $object['User']['name'],
	    	'elAdress' => $object['User']['address']
		)
	);
}
echo json_encode($objects);
?>