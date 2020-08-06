<?php
/**
 * These two functions can be used to enqueue CSS and JS 
 * files from two static files named .js-enqueues 
 * and .css-enqueues from the theme's root directory
 * 
 * PHP Version 7.4.8
 * 
 * @category WordPress
 * @package  WordPress
 * @author   Ahmad Karim <ahmu83@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License v3.0
 * @link     https://ahmadkarim.com/
 */

function enqueues_list($type = 'js') {

	$filename = get_stylesheet_directory() . "/.{$type}-enqueues";
	$files_list = array();

	if (file_exists($filename)) {

		$names = file($filename);
		$names = array_filter($names, function($n) {

			if (empty(trim($n)) || substr(trim($n), 0, 1) == '#') {

				return false;

			} else {

				return true;

			}

		});

		$files_list = array_values($names);

	}

	return $files_list;

}

function enqueues() {

	$files = array();
	$uniqid = uniqid();
	$delimiter = '!!';

	/*
	 * Enqueue JS files
	 */
	foreach (enqueues_list('js') as $file) {

		/*
		 * Trim the arguments
		 */
		$file = array_map(function($n) {

			return trim($n);

		}, explode($delimiter, $file));

		/*
		 * Check if the src is relative or absolute
		 */
		if (isset($file[1])) {

			$url = parse_url($file[1]);
			$file[1] = isset($url['host']) ? $file[1] : get_stylesheet_directory_uri() . $file[1];

		}

		/*
		 * Check if the deps argument is set
		 */
		if (isset($file[2])) {

			/*
			 * Trim the deps argument
			 */
			$deps = array_map(function($n) {

				return trim($n);

			}, explode(',', $file[2]));

			$deps = array_filter($deps);

			$file[2] = $deps;

		}

		/*
		 * Check if the ver argument is set and 
		 * if it is set to rand in order to un-cache 
		 * a file every-time the page is loaded
		 */
		if (isset($file[3]) && $file[3] == 'rand') {

			$file[3] = $uniqid;

		}

		$handle = $file[0];
		$src = $file[1];
		$deps = $file[2] ?? array();
		$ver = $file[3] ?? false;
		$in_footer = $file[4] ?? false;

		wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);

		$files[] = $file;

	}

	/*
	 * Enqueue CSS files
	 */
	foreach (enqueues_list('css') as $file) {

		/*
		 * Trim the arguments
		 */
		$file = array_map(function($n) {

			return trim($n);

		}, explode($delimiter, $file));

		/*
		 * Check if the src is relative or absolute
		 */
		if (isset($file[1])) {

			$url = parse_url($file[1]);
			$file[1] = isset($url['host']) ? $file[1] : get_stylesheet_directory_uri() . $file[1];

		}

		/*
		 * Check if the deps argument is set
		 */
		if (isset($file[2])) {

			/*
			 * Trim the deps argument
			 */
			$deps = array_map(function($n) {

				return trim($n);

			}, explode(',', $file[2]));

			$deps = array_filter($deps);

			$file[2] = $deps;

		}

		/*
		 * Check if the ver argument is set and 
		 * if it is set to rand in order to un-cache 
		 * a file every-time the page is loaded
		 */
		if (isset($file[3]) && $file[3] == 'rand') {

			$file[3] = $uniqid;

		}

		$handle = $file[0];
		$src = $file[1];
		$deps = $file[2] ?? array();
		$ver = $file[3] ?? false;
		$media = $file[4] ?? false;

		wp_enqueue_style($handle, $src, $deps, $ver, $media);

		$files[] = $file;

	}

	return $files;

}
add_action( 'wp_enqueue_scripts', 'enqueues' );

