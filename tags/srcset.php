<?php

/**
 * Srcset Tag
 *
 * An extension for KirbyText making the srcset available as a tag. See
 * http://responsiveimages.org/ for more information about srcset.
 *
 * You can use the KirbyText tag in your text as: (srcset: filename extension:
 * png sizes: media queries and widths class: my-classname caption: a figcaption
 * alt: alt text width: 100px height: 200px). The attribute 'sizes' doesn't work
 * yet.
 * @author    Bart van de Biezen <bart@bartvandebiezen.com>
 * @link      https://github.com/bartvandebiezen/kirby-v2-srcset-tag
 * @return    HTML
 * @version   0.3
 * @todo      Add support for escape character in 'sizes' attribute.
 * @todo      Add the option to generate images when they do not exist.
 * @todo      Add BEM style classes based on class attribute.
 */

kirbytext::$tags['srcset'] = array (

	'attr' => array (
		'extension',
		'sizes',
		'class',
		'caption',
		'alt',
		'width',
		'height',
	),

	'html' => function ($tag) {

		// Place attributes in variables
		$name    = $tag->attr('srcset');
		$extension = '.' . $tag->attr('extension', 'jpg'); // If no extension is given, extension will be '.jpg'.
		$sizes     = $tag->attr('sizes', '100vw'); // If sizes is not given, it will be the full width (100%) of the viewport.
		$class     = $tag->attr('class');
		$caption   = $tag->attr('caption');
		$alt       = $tag->attr('alt');
		$width     = $tag->attr('width');
		$height    = $tag->attr('height');

		// Settings. You could change this if needed for your project. Modifiers are inspired by Apple's iOS.
		$range1Modifier   = '~palm';
		$range2Modifier   = '~lap';
		$range3Modifier   = '~desk';
		$retinaModifier   = '@2x';

		// State possible files
		$image        = $tag->page()->file($name . $extension);
		$image1       = $tag->page()->file($name . $range1Modifier . $extension);
		$image1Retina = $tag->page()->file($name . $range1Modifier . $retinaModifier . $extension);
		$image2       = $tag->page()->file($name . $range2Modifier . $extension);
		$image2Retina = $tag->page()->file($name . $range2Modifier . $retinaModifier . $extension);
		$image3       = $tag->page()->file($name . $range3Modifier . $extension);
		$image3Retina = $tag->page()->file($name . $range3Modifier . $retinaModifier . $extension);

		// Get URLs and widths
		if ($image)        { $url = $image->url(); }
		if ($image1)       { $url1 = $image1->url();             $image1Size       = $image1->width() . 'w'; };
		if ($image1Retina) { $url1Retina = $image1Retina->url(); $image1RetinaSize = $image1Retina->width() . 'w'; };
		if ($image2)       { $url2 = $image2->url();             $image2Size       = $image2->width() . 'w'; };
		if ($image2Retina) { $url2Retina = $image2Retina->url(); $image2RetinaSize = $image2Retina->width() . 'w'; };
		if ($image3)       { $url3 = $image3->url();             $image3Size       = $image3->width() . 'w'; };
		if ($image3Retina) { $url3Retina = $image3Retina->url(); $image3RetinaSize = $image3Retina->width() . 'w'; };

		// Starting figure
		$buffer = '<figure';
		if ($class) { $buffer .= ' class="' . $class . '"'; }
		$buffer .= '>' . "\n";

		// Starting image
		$buffer .= '<img';
		if ($width) { $buffer .= ' width="' . $width . '"'; }
		if ($height) { $buffer .= ' height="' . $height . '"'; }

		// Get default or smallest image as fall back image
		$buffer .= ' src="';
		if      ($image)        { $buffer .= $url; }
		else if ($image1)       { $buffer .= $url1; }
		else if ($image1Retina) { $buffer .= $url1Retina; }
		else if ($image2)       { $buffer .= $url2; }
		else if ($image3)       { $buffer .= $url3; }
		else if ($image2Retina) { $buffer .= $url2Retina; }
		else if ($image3Retina) { $buffer .= $url3Retina; };
		$buffer .= '"';

		// Setting sizes
		$buffer .= ' sizes="' . $sizes . '"';

		// Setting srcset
		$buffer .= ' srcset="';
		if ($image1)       { $buffer .= $url1 . ' ' . $image1Size . ', '; };
		if ($image1Retina) { $buffer .= $url1Retina . ' ' . $image1RetinaSize . ', '; };
		if ($image2)       { $buffer .= $url2 . ' ' . $image2Size . ', '; };
		if ($image3)       { $buffer .= $url3 . ' ' . $image3Size . ', '; };
		if ($image2Retina) { $buffer .= $url2Retina . ' ' . $image2RetinaSize . ', '; };
		if ($image3Retina) { $buffer .= $url3Retina . ' ' . $image3RetinaSize . ', '; };
		$buffer .= '"';

		// Optional alt text
		if ($alt) { $buffer .= ' alt="' . $alt . '"'; }

		// Ending image
		$buffer .= '>' . "\n";

		// Optional figure caption
		if ($caption) { $buffer .= '<figcaption>' . $caption . '</figcaption>' . "\n"; }

		// Ending figure
		$buffer .= '</figure>' . "\n";

		// Output buffer
		return $buffer;
	}
);

?>
