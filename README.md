# srcset tag for Kirby 2

An extension for KirbyText making the srcset available as a tag. See [Responsive Images Community Group](http://responsiveimages.org) for more information about srcset.

## Installation

1. Copy ‘srcset.php’ inside ‘tags’ to Kirby’s ‘site/tags/‘ folder.
2. Make sure you have picturefill.js, if not:

  1. Copy ‘picturefill-2.2.0.min.js’ inside ‘assets/js/' to Kirby’s ‘assets/js/‘ folder or [download the latest version](http://scottjehl.github.io/picturefill/).
  2. Place ```<?php echo js(‘assets/js/picturefill-2.2.0.min.js’) ?>``` in your footer file above ```</body>```.

## Usage

### Attributes

You can use the srcset in your markdown files for Kirby as follows:

```
(srcset: filename extension: png sizes: media queries and widths class: my-classname caption: a figcaption alt: alt text width: 100px height: 200px)
```

Be careful, you need to write the filename without an extension. The extension is written as a separate attribute. When you do not use the extension attribute, the extension will be ‘jpg’.

### File names

Files should be named as:

- ```filename.jpg``` (fall back)
- ```filename~palm.jpg```
- ```filename~palm@2x.jpg```
- ```filename~lap.jpg```
- ```filename~lap@2x.jpg```
- ```filename~desk.jpg```
- ```filename~desk@2x.jpg```

The naming convention is based on naming convention for Apple's iOS. If you want, you can change the naming convention in ‘srcset.php’.

### Widths

The tag will automatically get the widths of your images and places these in the srcset.

The attribute 'sizes' doesn't work yet. An example for sizes would be '(min-width: 1024px) 50vw, 100vw'. The problem is that Kirby doesn't support an escape character within KirbyText tags for a parenthesis, which are also used to end the KirbyText tag. Until an escape character (for example '\') is added to Kirby, you cannot use 'sizes'. The current default for sizes is '100vw'.
