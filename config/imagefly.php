<?php
return [
		/**
		 * Number of seconds before the browser checks the server for a new version of the modified image.
		*/
		'cache_expire'     => 7 * 24 * 60 * 60,
		/**
		 * Path to the image cache directory you would like to use, don't forget the trailing slash!
		*/
		'cache_dir'        => storage_path().'/imagefly/',
		/**
		 * Mimic the source file folder structure within the cache directory.
		* Useful if you want to keep track of cached files and folders to perhaps periodically clear some cache folders but not others.
		*/
		'mimic_source_dir' => FALSE,
		/**
		 * The default quality of images when not specified in the URL
		*/
		'quality'          => 75,
		/**
		 * If the image should be scaled up beyond it's original dimensions on resize.
		*/
		'scale_up'		   => FALSE,
		/**
		 * Will only allow param configurations set in the presets.
		* Best enabled on production sites to reduce spamming of different sized images on the server.
		*/
		'enforce_presets'  => FALSE,
		/**
		 * Imagefly params that are allowed when enforce_presets is set to TRUE
		* Any other param configuration will throw a 404 error.
		*/
		'presets'          => array(
				'w320-h240-c',
				/* Example
				 'w320-h240-c',
				 'w320-h240-nc',
				'w640-w480-q60',
				'w200-h200-a',
				*/
		),
		/**
		 * Configure one or more watermarks. Each configuration key can be passed as a param through an Imagefly URL to apply the watermark.
		* If no offset is specified, the center of the axis will be used.
		* If an offset of TRUE is specified, the bottom of the axis will be used.
		*/
		'watermarks'       => array(
				/* Example
				 'custom_watermark' => array(
				 		'image'    => 'path/to/watermark.png',
				 		'offset_x' => TRUE,
				 		'offset_y' => TRUE,
				 		'opacity'  => 80
				 )
*/
		),
		'abs_path'			=> public_path(),
];
