<?php
 	header("Content-type: application/json; charset=utf-8");
 	
 	$offset = intval(htmlspecialchars($_GET["offset"]) );
 	$limit = intval(htmlspecialchars($_GET["limit"]) );
 	
 	$jsonString = file_get_contents('./carouselImages.json', FILE_USE_INCLUDE_PATH);
 	$jsonArray = json_decode($jsonString, true);
 
 	$carouselImagesCount = count($jsonArray);
 	
 	// Calculate the correct index
 	$index = $offset;
 	
 	if ($index == 0) { // Positive index cases
 	
 		$index = $carouselImagesCount - 1;
 		
 	} elseif ($index > 0 && $index <= $carouselImagesCount) {
 	
 		$index = $index - 1;
 		
 	} elseif ($index > $carouselImagesCount) {
 	
 		$index = ($index % 10) - 1;
 		$index = $index < 0 ? $carouselImagesCount - 1 : $index;
 		
 	} elseif ($index < 0 && $index >= $carouselImagesCount * -1) { // Negative index cases
 	
 		$index = ($carouselImagesCount - 1) + $index;
 		$index = $index < 0 ? $carouselImagesCount - 1 : $index;
 		
 	} elseif ($index < $carouselImagesCount * -1) {
 	
 		$index = (($index % 10) + 1) * -1;
 		$index = $index != 0 ? ($carouselImagesCount - 2) - $index : $carouselImagesCount - 2;
 	}
 
 	$result = array();
 	
 	for ($i = 0; $i < $limit; $i++) {
 	
 		$currentIndex = $index + $i;
 		
 		if ($currentIndex >= $carouselImagesCount) {
 		
 			$diff = $currentIndex - $carouselImagesCount;
 			
 			$currentIndex = $diff;
 			
 			$result[$i] = $jsonArray[$currentIndex];
  			
 			continue;
 		}
 		
 		$result[$i] = $jsonArray[$currentIndex];
	}
 
	echo json_encode($result);
?> 