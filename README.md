# manga-reader
manga-reader is a modern, html5 compliant Manga (japanese comics) Reader that support RTL.

## What is Supported?
All standards compliant browsers and platforms such as Desktops, Tablets, Smartphones, Google TV, and more!

* Microsoft Internet Explorer 11+ 
* Google Chrome 6+ / Android 2.3+
* Mozilla FireFox 3.6+
* Apple Safari 5+ / iPhone / iPod Touch / iPad
* HTML5 browsers (smart phones, TVs, etc.)

## Features
* Read Jpeg, Png or Svg files (all images must have the same width and height).
* Built on Modernzr and jQuery 1.11.1
* Works with manga stored in a web site folder

## To Dos
* support external manga folders (full url)
* support dropbox manga folders
* use a unique configuration file for each manga
* Create a private dashboard to: 
	* add a new manga
	* allow to upload, resize and crop images
	* allow to generate svg files from clean scans
	* allow to edit svg files to add formatted texts
	* allow to export svg file to bitmaps (jpg or png)
	* edit manga configuration file

## Manga Files structure and formats

In each manga folder we'll have the following files and sub-folders:
* _title.txt_ which contains the complete title of the manga.
* for each volume of the manga we'll have the following files and folders:
	* _volume[0-9]+_ folder(s)
		* any image file of allowed types (jpg, png and svg), the files will be loaded following a natural sort
		* if we'll have svg files there will be an _img_ folder used to store linked jpg images (if any)
	* _volume[0-9]+.json_ file(s) which contains all the chapters definitions
	* _volume[0-9]+.jpg_ file(s) which contains the covers used in the menu (max height 100px)

### _volume[0-9]+.json_ file format
```
{
  "volume": [0-9]+, /* number of the volume (1+) */
  "name": "Volume [0-9]+", /* used in the menu creation */
  "description": "", /* used in the menu creation */
  "chapters": [
    {
      "no": [0-9]+, /* number of the chapter (1+) */
      "title": "any text", /* used in the menu creation */
      "page": 1 /* used in the menu creation, when clicked the books will go to that page */
    },{
      "no": 55, 
      "title": "Mission 55: Cuore Pulsante", 
      "page": 4
    }
  ]
}
```
	

## Support
If you're having problems, use the github's <a href="https://github.com/mperin/manga-reader/issues">issue tracker</a>.

## License
Copyright (c) 2014 Massimo Perin 
Licensed under the GPL-3 license.
