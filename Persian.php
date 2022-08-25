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
ّFork of:    I18N_Arabic by Khaled Al-Sham'aa 
Purpose:    Set of PHP classes developed to enhance Persian web
            applications by providing set of tools includes stem-based searching,
            translitiration, soundex, Hijri calendar, charset detection and
            converter, spell numbers, keyboard language, Muslim prayer time,
            auto-summarization, and more...
*/

class I18N_Persian {

    private $_inputCharset  = 'utf-8';
    private $_outputCharset = 'utf-8';
    private $_compatible    = array();
    private $_lazyLoading   = array();
    private $_useAutoload;
    private $_useException;
    private $_compatibleMode;
    
    //ignore
    public $myObject;
    
    //ignore
    public $myClass;
    
    //ignore
    public $myFile;

    /*
    Load selected library/Persian class you would like to use its functionality
    param string   $library        [AutoSummarize|CharsetC|CharsetD|Date|Gender|
                                    Glyphs|Identifier|KeySwap|Numbers|Query|Salat|
                                    Soundex|StrToTime|WordTag|CompressStr|Mktime|
                                    Transliteration|Stemmer|Standard|Normalise]
    param boolean  $useAutoload    True to use Autoload (default is false)
    param boolean  $useException   True to use Exception (default is false)
    param boolean  $compatibleMode True to support old naming style before    
    */
    
    public function __construct($library, $useAutoload=false, $useException=false, $compatibleMode=true){
    
        $this->_useAutoload    = $useAutoload;
        $this->_useException   = $useException;
        $this->_compatibleMode = $compatibleMode;

        $xml = simplexml_load_file(dirname(__FILE__).'/Persian/data/config.xml');

        foreach ($xml->xpath("//compatible/case") as $case) {
            $this->_compatible["{$case['old']}"] = (string)$case;
        }

        foreach ($xml->xpath("//lazyLoading/case") as $case) {
            $this->_lazyLoading["{$case['method']}"] = (string)$case;
        } 

        //Set internal character encoding to UTF-8
        mb_internal_encoding("utf-8");

        if ($this->_useAutoload) {
            //It is critical to remember that as soon as spl_autoload_register() is
            //called, __autoload() functions elsewhere in the application may fail 
            //to be called. This is safer initial call (PHP 5 >= 5.1.2):
            if (false === spl_autoload_functions()) {
                if (function_exists('__autoload')) {
                    spl_autoload_register('__autoload', false);
                }
            }
            
            spl_autoload_extensions('.php,.inc,.class');
            spl_autoload_register('I18N_Persian::autoload', false);
        }
        
        if ($this->_useException) {
            set_error_handler('I18N_Persian::myErrorHandler');
        }
        
        if ($library) {
            if ($this->_compatibleMode && array_key_exists($library, $this->_compatible)){
                $library = $this->_compatible[$library];
            }
            
            $this->load($library);
        }
    }

    /*
    Include file that include requested class
    @param string   $className  Class name
    return null
    */
    
    public static function autoload($className){
        include self::getClassFile($className);
    }

    /*
    Error handler function
    param int       $errno      The level of the error raised
    param string    $errstr     The error message
    param string    $errfile    The filename that the error was raised in
    param int       $errline    The line number the error was raised at
    return boolean FALSE
    */ 
    
    public static function myErrorHandler($errno, $errstr, $errfile, $errline) {
        if ($errfile == __FILE__ || file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Persian' . DIRECTORY_SEPARATOR . basename($errfile))) {
            $msg  = '<b>Persian Class Exception:</b> ';
            $msg .= $errstr;
            $msg .= " in <b>$errfile</b>";
            $msg .= " on line <b>$errline</b><br />";
            throw new PersianException($msg, $errno);
        }
        
        // If the function returns false then the normal error handler continues
        return false;
    }

    /*
    Load selected Persian library and create an instance of its class
    param string    $library    Library name
    return null      
    */ 
    
    public function load($library) {
        if ($this->_compatibleMode && array_key_exists($library, $this->_compatible)) {
            $library = $this->_compatible[$library];
        }

        $this->myFile  = $library;
        $this->myClass = 'I18N_Persian_' . $library;
        $class         = 'I18N_Persian_' . $library;

        if (!$this->_useAutoload) {
            include self::getClassFile($this->myFile); 
        }

        $this->myObject   = new $class();
        $this->{$library} = &$this->myObject;
    }
    
    /*
    Magic method __call() allows to capture invocation of non existing methods.
    That way __call() can be used to implement user defined method handling that 
    depends on the name of the actual method being called.
    method Call a method from loaded sub class
    and take care of needed character set conversion
    for both input and output values.
    param string    $methodName     Method name
    param array     $arguments      Array of arguments
    return The value returned from the __call() method will be returned to the caller of the method.
    */
    
    public function __call($methodName, $arguments) {
        if ($this->_compatibleMode && array_key_exists($methodName, $this->_compatible)) {
            $methodName = $this->_compatible[$methodName];
        }

        // setMode & getMode [Date*|Query], setLang [Soundex*|CompressStr]  
        if ('I18N_Persian_'.$this->_lazyLoading[$methodName] != $this->myClass) {
            $this->load($this->_lazyLoading[$methodName]);
        }

        // Create an instance of the ReflectionMethod class
        $method = new ReflectionMethod($this->myClass, $methodName);
        
        $params     = array();
        $parameters = $method->getParameters();

        foreach ($parameters as $parameter) {
            $name  = $parameter->getName();
            $value = array_shift($arguments);
            
            if (is_null($value) && $parameter->isDefaultValueAvailable()) {
                $value = $parameter->getDefaultValue();
            }
            
            if ($methodName == 'decompress' || ($methodName == 'search' && $name == 'bin') || ($methodName == 'length' && $name == 'bin')) {
                $params[$name] = $value;
            } else {
                $params[$name] = iconv($this->getInputCharset(), 'utf-8', $value);
            }
        }

        $value = call_user_func_array(array(&$this->myObject, $methodName), $params);

        if ($methodName == 'tagText') {
            $outputCharset = $this->getOutputCharset();
            foreach ($value as $key=>$text) {
                $value[$key][0] = iconv('utf-8', $outputCharset, $text[0]);
            }
        
        } elseif ($methodName == 'compress' || $methodName == 'getPrayTime' || $methodName == 'str2graph') {
            //do nothing !
            
        } else {
            $value = iconv('utf-8', $this->getOutputCharset(), $value);
        }

        return $value;
    }

    /*
    Garbage collection, release child objects directly
    */
    
    public function __destruct() {
        $this->_inputCharset  = null;
        $this->_outputCharset = null;
        $this->myObject      = null;
        $this->myClass       = null;
    }

    /*
    Set charset used in class input Persian strings
    param string    $charset    Input charset [utf-8|windows-1256|iso-8859-6]
    return TRUE if success, or FALSE if fail
    */
    
    public function setInputCharset($charset){
        $flag = true;
        
        $charset  = strtolower($charset);
        $charsets = array('utf-8', 'windows-1256', 'cp1256', 'iso-8859-6');
        
        if (in_array($charset, $charsets)) {
            if ($charset == 'windows-1256') {
                $charset = 'cp1256';
            }
            $this->_inputCharset = $charset;
        } else {
            $flag = false;
        }
        
        return $flag;
    }
    
    /*
    Set charset used in class output Persian strings
    param string $charset Output charset [utf-8|windows-1256|iso-8859-6]
    return boolean TRUE if success, or FALSE if fail
    */
    
    public function setOutputCharset($charset){
        $flag = true;
        $charset  = strtolower($charset);
        $charsets = array('utf-8', 'windows-1256', 'cp1256', 'iso-8859-6');
        
        if (in_array($charset, $charsets)) {
            if ($charset == 'windows-1256') {
                $charset = 'cp1256';
            }
            $this->_outputCharset = $charset;
        } else {
            $flag = false;
        }
        
        return $flag;
    }

    /*
    Get the charset used in the input Persian strings
    return string return current setting for class input Persian charset
    */
    
    public function getInputCharset() {
        if ($this->_inputCharset == 'cp1256') {
            $charset = 'windows-1256';
        } else {
            $charset = $this->_inputCharset;
        }
        
        return $charset;
    }
    
    /*
    Get the charset used in the output Persian strings
    return string return current setting for class output Persian charset
    */
    
    public function getOutputCharset() {
        if ($this->_outputCharset == 'cp1256') {
            $charset = 'windows-1256';
        } else {
            $charset = $this->_outputCharset;
        }
        
        return $charset;
    }

    /*
    Get sub class file path to be included (mapping between class name and 
    file name/path become independent now)
    param string    $class  Sub class name
    return string Sub class file path
    */
    
    protected static function getClassFile($class){
        $dir  = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Persian';
        $file = $dir . DIRECTORY_SEPARATOR . $class . '.php';
        return $file;
    }
    
    /*
    Send/set output charset in several output media in a proper way
    param string    $mode   [http|html|mysql|mysqli|pdo|text_email|html_email]
    param resource  $conn   The MySQL connection handler/the link identifier
    return string header formula if there is any (in cases of html, text_email, and html_email)
    */
    
    public function header($mode = 'http', $conn = null){
        $mode = strtolower($mode);
        $head = '';
        
        switch ($mode) {
        case 'http':
            header('Content-Type: text/html; charset=' . $this->_outputCharset);
            break;
        
        case 'html':
            $head .= '<meta http-equiv="Content-type" content="text/html; charset=';
            $head .= $this->_outputCharset . '" />'; 
            break;
        
        case 'text_email':
            $head .= 'MIME-Version: 1.0\r\nContent-type: text/plain; charset=';
            $head .= $this->_outputCharset . '\r\n'; 
            break;

        case 'html_email':
            $head .= 'MIME-Version: 1.0\r\nContent-type: text/html; charset=';
            $head .= $this->_outputCharset . '\r\n'; 
            break;
        
        case 'mysql':
            if ($this->_outputCharset == 'utf-8') {
                mysql_set_charset('utf8');
            } elseif ($this->_outputCharset == 'windows-1256') {
                mysql_set_charset('cp1256');
            }
            break;

        case 'mysqli':
            if ($this->_outputCharset == 'utf-8') {
                $conn->set_charset('utf8');
            } elseif ($this->_outputCharset == 'windows-1256') {
                $conn->set_charset('cp1256');
            }
            break;

        case 'pdo':
            if ($this->_outputCharset == 'utf-8') {
                $conn->exec('SET NAMES utf8');
            } elseif ($this->_outputCharset == 'windows-1256') {
                $conn->exec('SET NAMES cp1256');
            }
            break;
        }
        
        return $head;
    }

    /*
    Get web browser chosen/default language using ISO 639-1 codes (2-letter)
    return string Language using ISO 639-1 codes (2-letter)
    */
    
    public static function getBrowserLang(){
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); // ar, en, etc...
        return $lang;
    }

    /*
    There is still a lack of original, localized, high-quality content and 
    well-structured Persian websites; This method help in tag HTML result pages 
    from Persian forum to enable filter it in/out.
    param string    $html   The HTML content of the page in question
    return boolean True if the input HTML is belong to a forum page
    */
    
    public static function isForum($html){
        $forum = false;
        if (strpos($html, 'vBulletin_init();') !== false) $forum = true;        
        return $forum;
    }
}

/*
Persian Exception class defined by extending the built-in Exception class.
Make sure everything is assigned properly
param string    $message    Exception message
param int       $code       User defined exception code
*/

class PersianException extends Exception {     
    public function __construct($message, $code=0) {
        parent::__construct($message, $code);
    }
}
