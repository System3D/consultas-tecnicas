<?php
namespace App\Helpers;

class Alfred {

	public function randomColor($color = null, $brightness = 5, $darkness = 13) {
		if ($color == null || $color == 'random') {
			$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'); // 16 MAX
			$color = '#' . $rand[rand($brightness, $darkness)] . $rand[rand($brightness, $darkness)] . $rand[rand($brightness, $darkness)] . $rand[rand($brightness, $darkness)] . $rand[rand($brightness, $darkness)] . $rand[rand($brightness, $darkness)];
		}
		return $color;
	}

	public function prettyhtml($html = null) {
		$doc = new DOMDocument();
		$doc->loadHTML($html);
		return $doc->saveHTML();
	}

}