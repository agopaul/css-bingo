<?php

/*
 * CSS Dimension classes generator
 * 
 * Generate a CSS file with utility classes:
 *
 * margin-top-1 { margin-top: 1px; }
 * margin-top-2 { margin-top: 2px; }
 * margin-top-3 { margin-top: 3px; }
 * margin-top-4 { margin-top: 4px; }
 * ...
 *
 * @author Paolo Agostinetto <paul.ago@gmail.com>
 */

$sizes = range(1, 10);
$sizes = array_merge($sizes, array_map(function($var){ return $var * 10; }, range(1, 50)));
$sizes = array_merge($sizes, array_map(function($var){ return ($var * 10) + 5; }, range(1, 10)));

$sizes = array_unique($sizes);
sort($sizes, SORT_REGULAR);

$types = ["margin", "padding"];
$directions = ["", "top", "right", "bottom", "left"];
$orientations = ["vertical" => ["top", "bottom"], "horizontal" => ["left", "right"]];
$dimensions = ["width", "height"];

// Directions
$rules = [];
foreach($types as $type){
	foreach($directions as $direction){
		foreach($sizes as $size){
			$rules[] = sprintf(".%s%s-%d { %s%s: %dpx; }",
				$type,
				$direction ? "-".$direction : "",
				$size,
				$type,
				$direction ? "-".$direction : "",
				$size
			);
		}
	}
}

// Orientations
foreach($types as $type){
	foreach($orientations as $orientation => $orientationDir){
		foreach($sizes as $size){
			$rules[] = sprintf(".%s-%s-%d { %s-%s: %dpx; %s-%s: %dpx; }",
				$type,
				$orientation,
				$size,
				$type,
				$orientationDir[0],
				$size,
				$type,
				$orientationDir[1],
				$size
			);
		}
	}
}

// Dimensions
foreach($dimensions as $dimension){
	foreach($sizes as $size){
		$rules[] = sprintf(".%s-%d { %s: %dpx; }",
			$dimension,
			$size,
			$dimension,
			$size
		);
	}
}

$file = "framework.css";
file_put_contents($file, str_replace(" ", "", implode(PHP_EOL, $rules)));

printf("\nDone [rules=%d] [filesize=%dKB]\n\n", count($rules), filesize($file) / 1024);

