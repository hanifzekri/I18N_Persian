# I18N Persian PHP Library

**Class Name:** I18N_Persian

**Filename:** Persian.php

**Author:** hanif.zekri@gmail.com

**Fork of:** I18N_Arabic by Khaled Al-Sham'aa


## Description

I18N Persian is a PHP library that provides a set of tools and classes to enhance Persian web applications. It offers various functionalities including stem-based searching, transliteration, soundex, Hijri calendar, charset detection and conversion, spell numbers, keyboard language, Muslim prayer time, auto-summarization, and more.

## License

This program is an open-source product released under the terms of the GNU Lesser General Public License (LGPL) version 3 or any later version. You can redistribute and modify this program according to the terms of the license. For more details, please refer to the [GNU Lesser General Public License](http://www.gnu.org/licenses/lgpl.txt).

## Dependencies

- This library requires PHP.
- It may also require specific character sets or extensions, depending on the features you intend to use.

## Installation

To use this library, include the `Persian.php` file in your PHP project.

```php
include 'Persian.php';
```

## Usage

To use the library, create an instance of the `I18N_Persian` class and load the desired Persian library or module. You can then call methods from the loaded library to perform various operations.

```php
// Create an instance of I18N_Persian and load a library
$persian = new I18N_Persian('LibraryName');

// Use library methods
$result = $persian->libraryMethod($arguments);
```

### Available Libraries

You can choose from a variety of libraries/modules when loading the `I18N_Persian` class, depending on your needs. Some of the available libraries include:

- Glyphs

Other libraries are under construction.

### Character Set Handling

You can set the character set for both input and output Persian strings using the following methods:

- `setInputCharset($charset)` to set the input character set.
- `setOutputCharset($charset)` to set the output character set.
- `getInputCharset()` to retrieve the current input character set.
- `getOutputCharset()` to retrieve the current output character set.

### Error Handling

The library provides error handling through custom exceptions. You can enable exception handling by passing `true` for the `$useException` parameter when creating an instance of the `I18N_Persian` class. If an error occurs, a `PersianException` will be thrown.

### Charset Conversion

The library handles character set conversions for input and output values when calling methods. It ensures that the specified character sets are used correctly.

### Header Setting

The `header($mode, $conn)` method allows you to set the output charset for various output media, such as HTTP, HTML, text email, HTML email, MySQL, MySQLi, and PDO. You can specify the desired mode to configure the output charset accordingly.

### Browser Language Detection

The `getBrowserLang()` method retrieves the chosen or default language of the web browser using ISO 639-1 codes (2-letter codes).

### Forum Page Detection

The `isForum($html)` method helps identify whether a given HTML content is from a Persian forum page. It checks for specific markers in the HTML content.

## Examples

Here are some usage examples of the library:

```php
// Create an instance of I18N_Persian with exception handling enabled
$persian = new I18N_Persian('LibraryName', false, true);

// Set input and output character sets
$persian->setInputCharset('utf-8');
$persian->setOutputCharset('utf-8');

// Load a library/module
$persian->load('LibraryName');

// Use a library method
$result = $persian->libraryMethod($arguments);

// Handle exceptions
try {
    $result = $persian->libraryMethod($arguments);
} catch (PersianException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Set the output charset for HTTP response
$persian->header('http');

// Detect the browser's chosen language
$browserLang = $persian::getBrowserLang();

// Check if HTML content is from a forum page
$isForumPage = $persian::isForum($htmlContent);
```

## Contribution and Issues

Contributions to the library are welcome. If you encounter any issues or have suggestions for improvements, please report them on the project's GitHub page.

## Credits

- Original Author: hanif.zekri@gmail.com
- Forked from I18N_Arabic by Khaled Al-Sham'aa
