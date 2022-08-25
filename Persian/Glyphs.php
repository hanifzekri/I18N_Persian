<?php

/*
LICENSE:    This program is open source product; you can redistribute it and/or
            modify it under the terms of the GNU Lesser General Public License (LGPL)
            as published by the Free Software Foundation; either version 3
            of the License, or (at your option) any later version.
            
            This program is distributed in the hope that it will be useful,
            but WITHOUT ANY WARRANTY; without even the implied warranty of
            MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
            GNU Lesser General Public License for more details.
            
            You should have received a copy of the GNU Lesser General Public License
            along with this program.  If not, see <http://www.gnu.org/licenses/lgpl.txt>.
            
Class Name: I18N_Persian
Filename:   Persian.php
Author(s):  hanif.zekri@gmail.com
ّFork of:    I18N_Persian by Khaled Al-Sham'aa 
Purpose:    This class takes Persian text (encoded in Windows-1256 character 
            set) as input and performs Persian glyph joining on it and outputs 
            a UTF-8 hexadecimals stream that is no longer logically arranged 
            but in a visual order which gives readable results when formatted 
            with a simple Unicode rendering just like GD and UFPDF libraries 
            that does not handle basic connecting glyphs of Persian language 
            yet but simply outputs all stand alone glyphs in left-to-right order.
*/

class I18N_Persian_Glyphs {

    private $_glyphs   = null;
    private $_hex      = null;
    private $_prevLink = null;
    private $_nextLink = null;
    private $_vowel    = null;

    /*
    Loads initialize values
    ignore
    */
    
    public function __construct() {
    
        $this->_glyphs = '';
        $this->_hex    = '';
        
        $this->_prevLink = 'بپتثجچحخسشصضطظعغفقکگلمنهیـ،!؟؛';
        $this->_nextLink = 'ـآائبپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی';
        $this->_vowel = 'ًٌٍَُِّ';
        
        $this->_glyphs .= 'ً';
        $this->_hex    .= '064B064B064B064B';
        
        $this->_glyphs .= 'ٌ';
        $this->_hex    .= '064C064C064C064C';
        
        $this->_glyphs .= 'ٍ';
        $this->_hex    .= '064D064D064D064D';
        
        $this->_glyphs .= 'َ';
        $this->_hex    .= '064E064E064E064E';
        
        $this->_glyphs .= 'ُ';
        $this->_hex    .= '064F064F064F064F';
        
        $this->_glyphs .= 'ِ';
        $this->_hex    .= '0650065006500650';
        
        $this->_glyphs .= 'ّ';
        $this->_hex    .= '0651065106510651';

        $this->_glyphs .= 'ء';
        $this->_hex    .= 'FE80FE80FE80FE80';
        
        $this->_glyphs .= 'آ';
        $this->_hex    .= 'FE81FE82FE81FE82';
        
        $this->_glyphs .= 'ئ';
        $this->_hex    .= 'FE89FE8AFE8BFE8C';
        
        $this->_glyphs .= 'ا';
        $this->_hex    .= 'FE8DFE8EFE8DFE8E';
        
        $this->_glyphs .= 'ب';
        $this->_hex    .= 'FE8FFE90FE91FE92';
        
        $this->_glyphs .= 'پ';
        $this->_hex    .= 'FB56FB57FB58FB59';
        
        $this->_glyphs .= 'ت';
        $this->_hex    .= 'FE95FE96FE97FE98';
        
        $this->_glyphs .= 'ث';
        $this->_hex    .= 'FE99FE9AFE9BFE9C';
        
        $this->_glyphs .= 'ج';
        $this->_hex    .= 'FE9DFE9EFE9FFEA0';
        
        $this->_glyphs .= 'چ';
        $this->_hex    .= 'FB7AFB7BFB7CFB7D';
        
        $this->_glyphs .= 'ح';
        $this->_hex    .= 'FEA1FEA2FEA3FEA4';
        
        $this->_glyphs .= 'خ';
        $this->_hex    .= 'FEA5FEA6FEA7FEA8';
        
        $this->_glyphs .= 'د';
        $this->_hex    .= 'FEA9FEAAFEA9FEAA';
        
        $this->_glyphs .= 'ذ';
        $this->_hex    .= 'FEABFEACFEABFEAC';
        
        $this->_glyphs .= 'ر';
        $this->_hex    .= 'FEADFEAEFEADFEAE';
        
        $this->_glyphs .= 'ز';
        $this->_hex    .= 'FEAFFEB0FEAFFEB0';
        
        $this->_glyphs .= 'ژ';
        $this->_hex    .= 'FB8AFB8BFB8AFB8B';
        
        $this->_glyphs .= 'س';
        $this->_hex    .= 'FEB1FEB2FEB3FEB4';
        
        $this->_glyphs .= 'ش';
        $this->_hex    .= 'FEB5FEB6FEB7FEB8';
        
        $this->_glyphs .= 'ص';
        $this->_hex    .= 'FEB9FEBAFEBBFEBC';
        
        $this->_glyphs .= 'ض';
        $this->_hex    .= 'FEBDFEBEFEBFFEC0';
        
        $this->_glyphs .= 'ط';
        $this->_hex    .= 'FEC1FEC2FEC3FEC4';
        
        $this->_glyphs .= 'ظ';
        $this->_hex    .= 'FEC5FEC6FEC7FEC8';
        
        $this->_glyphs .= 'ع';
        $this->_hex    .= 'FEC9FECAFECBFECC';
        
        $this->_glyphs .= 'غ';
        $this->_hex    .= 'FECDFECEFECFFED0';

        $this->_glyphs .= 'ف';
        $this->_hex    .= 'FED1FED2FED3FED4';
        
        $this->_glyphs .= 'ق';
        $this->_hex    .= 'FED5FED6FED7FED8';
        
        $this->_glyphs .= 'ک';
        $this->_hex    .= 'FED9FEDAFEDBFEDC';
        
        $this->_glyphs .= 'گ';
        $this->_hex    .= 'FB92FB93FB94FB95';
        
        $this->_glyphs .= 'ل';
        $this->_hex    .= 'FEDDFEDEFEDFFEE0';
        
        $this->_glyphs .= 'م';
        $this->_hex    .= 'FEE1FEE2FEE3FEE4';
        
        $this->_glyphs .= 'ن';
        $this->_hex    .= 'FEE5FEE6FEE7FEE8';
        
        $this->_glyphs .= 'و';
        $this->_hex    .= 'FEEDFEEEFEEDFEEE';
        
        $this->_glyphs .= 'ه';
        $this->_hex    .= 'FEE9FEEAFEEBFEEC';
        
        $this->_glyphs .= 'ی';
        $this->_hex    .= '06CCFBFDFBFEFBFF';
        
        $this->_glyphs .= 'ـ';
        $this->_hex    .= '0640064006400640';
        
        $this->_glyphs .= '،';
        $this->_hex    .= '060C060C060C060C';
        
        $this->_glyphs .= '؟';
        $this->_hex    .= '061F061F061F061F';
        
        $this->_glyphs .= '؛';
        $this->_hex    .= '061B061B061B061B';
    }
    
    /*
    Get glyphs
    param string    $char   Char
    param integer   $type   Type
    return string
    */
    
    protected function getGlyphs($char, $type){
        
        $lettercount = 46;
        $pos = mb_strpos($this->_glyphs, $char);
        
        if ($pos > $lettercount) {
            $pos = ($pos-$lettercount)/2 + $lettercount;
        }
        $_SESSION['yeh'] = $this->_glyphs;
        $pos = $pos*16 + $type*4;
        
        return substr($this->_hex, $pos, 4);
    }
    
    /*
    Convert Persian Windows-1256 charset string into glyph joining in UTF-8 hexadecimals stream
    param string    $str    Persian string in Windows-1256 charset
    return string Persian glyph joining in UTF-8 hexadecimals stream
    */
    
    protected function preConvert($str){
        
        $crntChar = null;
        $prevChar = null;
        $nextChar = null;
        $output   = '';
        
        $_temp = mb_strlen($str);

        for ($i = 0; $i < $_temp; $i++) {
            $chars[] = mb_substr($str, $i, 1);
        }
        
        $max = count($chars);

        for ($i = $max - 1; $i >= 0; $i--) {
            
            $crntChar = $chars[$i];
            $prevChar = ' ';
            
            if ($i > 0) {
                $prevChar = $chars[$i - 1];
            }
            
            if ($prevChar && mb_strpos($this->_vowel, $prevChar) !== false) {
                $prevChar = $chars[$i - 2];
                if ($prevChar && mb_strpos($this->_vowel, $prevChar) !== false) {
                    $prevChar = $chars[$i - 3];
                }
            }
            
            $Reversed    = false;
            $flip_arr    = ')]>}';
            $ReversedChr = '([<{';
            
            if ($crntChar && mb_strpos($flip_arr, $crntChar) !== false) {
                $crntChar = $ReversedChr[mb_strpos($flip_arr, $crntChar)];
                $Reversed = true;
            } else {
                $Reversed = false;
            }
            
            if ($crntChar && !$Reversed && (mb_strpos($ReversedChr, $crntChar) !== false)) {
                $crntChar = $flip_arr[mb_strpos($ReversedChr, $crntChar)];
            }
            
            if (ord($crntChar) < 128) {
                $output  .= $crntChar;
                $nextChar = $crntChar;
                continue;
            }
            
            if ($crntChar && mb_strpos($this->_vowel, $crntChar) !== false) {
                if (isset($chars[$i + 1]) && (mb_strpos($this->_nextLink, $chars[$i + 1]) !== false) && (mb_strpos($this->_prevLink, $prevChar) !== false))
                    $output .= '&#x' . $this->getGlyphs($crntChar, 1) . ';';
                else
                    $output .= '&#x' . $this->getGlyphs($crntChar, 0) . ';';
                continue;
            }
            
            $form = 0;
            
            if ($prevChar && mb_strpos($this->_prevLink, $prevChar) !== false) $form++;
            if ($nextChar && mb_strpos($this->_nextLink, $nextChar) !== false) $form += 2;
            
            $output  .= '&#x' . $this->getGlyphs($crntChar, $form) . ';';
            $nextChar = $crntChar;
        }
        
        // from Persian Presentation Forms-B, Range: FE70-FEFF, 
        // file "UFE70.pdf" (in reversed order)
        // into Persian Presentation Forms-A, Range: FB50-FDFF, file "UFB50.pdf"
        // Example: $output = str_replace('&#xFEA0;&#xFEDF;', '&#xFCC9;', $output);

        $output = $this->decodeEntities($output, $exclude = array('&'));
        return $output;
    }
    
    /*
    Regression analysis calculate roughly the max number of character fit in one A4 page line for a given font size.
    param integer   $font   Font size
    return integer Maximum number of characters per line
    */
    
    public function a4MaxChars($font){
        $x = 381.6 - 31.57 * $font + 1.182 * pow($font, 2) - 0.02052 * pow($font, 3) + 0.0001342 * pow($font, 4);
        return floor($x - 2);
    }
    
    /*
    Calculate the lines number of given Persian text and font size that will fit in A4 page size
    param string    $str    Persian string you would like to split it into lines
    param integer   $font   Font size
    return integer Number of lines for a given Persian string in A4 page size
    */
    
    public function a4Lines($str, $font){
        
        $str = str_replace(array("\r\n", "\n", "\r"), "\n", $str);
        
        $lines     = 0;
        $chars     = 0;
        $words     = explode(' ', $str);
        $w_count   = count($words);
        $max_chars = $this->a4MaxChars($font);
        
        for ($i = 0; $i < $w_count; $i++) {
            $w_len = mb_strlen($words[$i]) + 1;
            
            if ($chars + $w_len < $max_chars) {
                if (mb_strpos($words[$i], "\n") !== false) {
                    $words_nl = explode("\n", $words[$i]);
                    $nl_num = count($words_nl) - 1;
                    for ($j = 1; $j < $nl_num; $j++) {
                        $lines++;
                    }
                    $chars = mb_strlen($words_nl[$nl_num]) + 1;
                } else {
                    $chars += $w_len;
                }
            } else {
                $lines++;
                $chars = $w_len;
            }
        }
        $lines++;
        
        return $lines;
    }
    
    /*
    Convert Persian Windows-1256 charset string into glyph joining in UTF-8
    hexadecimals stream (take care of whole the document including English 
    sections as well as numbers and arcs etc...)
    param string    $str        Persian string in Windows-1256 charset
    param integer   $max_chars  Max number of chars you can fit in one line
    param boolean   $hindo      If true use Hindo digits else use Persian digits
    return string Persian glyph joining in UTF-8 hexadecimals stream (take
    care of whole document including English sections as well as numbers and arcs etc...)
    */
    
    public function utf8Glyphs($str, $max_chars = 50, $hindo = true){
        
        $str = str_replace(array("\r\n", "\n", "\r"), " \n ", $str);
        $str = str_replace("\t", "        ", $str);
        
        $lines   = array();
        $words   = explode(' ', $str);
        $w_count = count($words);
        $c_chars = 0;
        $c_words = array();
        
        $english  = array();
        $en_index = -1;
        
        $en_words = array();
        $en_stack = array();

        for ($i = 0; $i < $w_count; $i++) {
            $pattern  = '/^(\n?)';
            $pattern .= '[a-z\d\\/\@\#\$\%\^\&\*\(\)\_\~\"\'\[\]\{\}\;\,\|\-\.\:!]*';
            $pattern .= '([\.\:\+\=\-\!،؟]?)$/i';
            
            if (preg_match($pattern, $words[$i], $matches)) {
                if ($matches[1]) {
                    $words[$i] = mb_substr($words[$i], 1).$matches[1];
                }
                if ($matches[2]) {
                    $words[$i] = $matches[2].mb_substr($words[$i], 0, -1);
                }
                $words[$i] = strrev($words[$i]);
                array_push($english, $words[$i]);
                if ($en_index == -1) {
                    $en_index = $i;
                }
                $en_words[] = true;
            } elseif ($en_index != -1) {
                $en_count = count($english);
                for ($j = 0; $j < $en_count; $j++) {
                    $words[$en_index + $j] = $english[$en_count - 1 - $j];
                }
                
                $en_index = -1;
                $english  = array();
                
                $en_words[] = false;
            } else {
                $en_words[] = false;
            }
        }

        if ($en_index != -1) {
            $en_count = count($english);
            for ($j = 0; $j < $en_count; $j++) {
                $words[$en_index + $j] = $english[$en_count - 1 - $j];
            }
        }

        // need more work to fix lines starts by English words
        if (isset($en_start)) {
            $last = true;
            $from = 0;
            
            foreach ($en_words as $key => $value) {
                if ($last !== $value) {
                    $to = $key - 1;
                    array_push($en_stack, array($from, $to));
                    $from = $key;
                }
                $last = $value;
            }
            
            array_push($en_stack, array($from, $key));
            
            $new_words = array();
            
            while (list($from, $to) = array_pop($en_stack)) {
                for ($i = $from; $i <= $to; $i++) {
                    $new_words[] = $words[$i];
                }
            }
            
            $words = $new_words;
        }

        for ($i = 0; $i < $w_count; $i++) {
            $w_len = mb_strlen($words[$i]) + 1;
            
            if ($c_chars + $w_len < $max_chars) {
                if (mb_strpos($words[$i], "\n") !== false) {
                    $words_nl = explode("\n", $words[$i]);
                    
                    array_push($c_words, $words_nl[0]);
                    array_push($lines, implode(' ', $c_words));
                    
                    $nl_num = count($words_nl) - 1;
                    for ($j = 1; $j < $nl_num; $j++) {
                        array_push($lines, $words_nl[$j]);
                    }
                    
                    $c_words = array($words_nl[$nl_num]);
                    $c_chars = mb_strlen($words_nl[$nl_num]) + 1;
                } else {
                    array_push($c_words, $words[$i]);
                    $c_chars += $w_len;
                }
            
            } else {
                array_push($lines, implode(' ', $c_words));
                $c_words = array($words[$i]);
                $c_chars = $w_len;
            }
        }
        array_push($lines, implode(' ', $c_words));
        
        $maxLine = count($lines);
        $output  = '';
        
        for ($j = $maxLine - 1; $j >= 0; $j--) {
            $output .= $lines[$j] . "\n";
        }
        
        $output = rtrim($output);
        
        $output = $this->preConvert($output);
        if ($hindo) {
            $nums   = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
            $arNums = array('٠', '١', '٢', '٣', '٤','٥' , '٦', '٧', '٨', '٩');
            
            foreach ($nums as $k => $v) {
                $p_nums[$k] = '/'.$v.'/ui';
            }
            $output = preg_replace($p_nums, $arNums, $output);
            
            foreach ($arNums as $k => $v) {
                $p_arNums[$k] = '/([a-z-\d]+)'.$v.'/ui';
            }
            foreach ($nums as $k => $v) {
                $r_nums[$k] = '${1}'.$v;
            }
            $output = preg_replace($p_arNums, $r_nums, $output);
            
            foreach ($arNums as $k => $v) {
                $p_arNums[$k] = '/'.$v.'([a-z-\d]+)/ui';
            }
            foreach ($nums as $k => $v) {
                $r_nums[$k] = $v.'${1}';
            }
            $output = preg_replace($p_arNums, $r_nums, $output);
        }

        return $output;
    }
    
    /*
    Decode all HTML entities (including numerical ones) to regular UTF-8 bytes.
    Double-escaped entities will only be decoded once ("&amp;lt;" becomes "&lt;", not "<").
    param string    $text       The text to decode entities in.
    param array     $exclude    An array of characters which should not be decoded.
    For example, array('<', '&', '"'). This affects both named and numerical entities.
    return string
    */
    
    protected function decodeEntities($text, $exclude = array()){
        static $table;
        
        // We store named entities in a table for quick processing.
        if (!isset($table)) {
            // Get all named HTML entities.
            $table = array_flip(get_html_translation_table(HTML_ENTITIES));
            // PHP gives us ISO-8859-1 data, we need UTF-8.
            $table = array_map('utf8_encode', $table);
            // Add apostrophe (XML)
            $table['&apos;'] = "'";
        }
        
        $newtable = array_diff($table, $exclude);
        
        //Use a regexp to select all entities in one pass, to avoid decoding 
        //double-escaped entities twice.
        //return preg_replace('/&(#x?)?([A-Za-z0-9]+);/e', '$this->decodeEntities2("$1", "$2", "$0", $newtable, $exclude)', $text);

        $pieces = explode('&', $text);
        $text   = array_shift($pieces);
        foreach ($pieces as $piece) {
            if ($piece[0] == '#') {
                if ($piece[1] == 'x') {
                    $one = '#x';
                } else {
                    $one = '#';
                }
            } else {
                $one = '';
            }
            $end   = mb_strpos($piece, ';');
            $start = mb_strlen($one);
            
            $two   = mb_substr($piece, $start, $end - $start);
            $zero  = '&'.$one.$two.';';
            $text .= $this->decodeEntities2($one, $two, $zero, $newtable, $exclude).
                     mb_substr($piece, $end+1);
        }
        return $text;
    }
    
    /*
    Helper function for decodeEntities
    param string    $prefix     prefix
    param string    $codepoint  Codepoint
    param string    $original   Original
    param array     $table      Store named entities in a table
    param array     $exclude    An array of characters which should not be decoded
    return string
    */
    
    protected function decodeEntities2($prefix, $codepoint, $original, &$table, &$exclude){
        
        // Named entity
        if (!$prefix) {
            if (isset($table[$original])) return $table[$original];
            else return $original;
        }
        
        // Hexadecimal numerical entity
        if ($prefix == '#x') {
            $codepoint = base_convert($codepoint, 16, 10);
        }
        
        // Encode codepoint as UTF-8 bytes
        if ($codepoint < 0x80) {
            $str = chr($codepoint);
        } elseif ($codepoint < 0x800) {
            $str = chr(0xC0 | ($codepoint >> 6)) . chr(0x80 | ($codepoint & 0x3F));
        } elseif ($codepoint < 0x10000) {
            $str = chr(0xE0 | ($codepoint >> 12)) . chr(0x80 | (($codepoint >> 6) & 0x3F)) . chr(0x80 | ($codepoint & 0x3F));
        } elseif ($codepoint < 0x200000) {
            $str = chr(0xF0 | ($codepoint >> 18)) . chr(0x80 | (($codepoint >> 12) & 0x3F)) . chr(0x80 | (($codepoint >> 6) & 0x3F)) . chr(0x80 | ($codepoint & 0x3F));
        }
        
        // Check for excluded characters
        if (in_array($str, $exclude)) {
            return $original;
        } else {
            return $str;
        }
    }
}

