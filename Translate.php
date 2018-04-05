<?php

namespace Dreamcoil;

class Translate
{
	const COOKIE_NAME = 'lang';

    public static function setUpCache()
    {
    	global $dreamcoil_translate_cache;
        if(!isset($dreamcoil_translate_cache)) $dreamcoil_translate_cache = [];
    }

    /**
     * Sets the language
     *
     * @param $lang
     */
    public static function setLang($lang)
    {
        global $console;
        setcookie(Translate::COOKIE_NAME, $lang, time() * 2);
        return true;
    }

    public static function getLang()
    {
    	if(isset($_COOKIE['lang'])) return $_COOKIE['lang'];
    	else return null;
    }

    public static function destroyLang()
    {
        setcookie(Translate::COOKIE_NAME, '0', time()-ONE_WEEK);
    }

    /**
     * Gets the translation for a translation key
     *
     * @param string $key
     * @param array $placeholders
     * @return string
     */
    public static function get($key, $placeholders = [])
    {
        $config = new \Dreamcoil\Config;
        $key = explode('.',$key);
        $lang = Translate::getLang();

        if (null === $lang) $lang = $config->get('fallback_lang');

        $file = Translate::lookUpFile($lang, $key[0]);

        $restKey = $key;
        unset($key[0]);
        $restKey = implode(".", $key);

        if (isset($file[$restKey])) {
        	$result = str_replace(
	            ['ü',     'ö',     'ä',     'Ü',     'Ö',     'Ä',     'ß'], 
	            ['&uuml;','&ouml;','&auml;','&Uuml;','&Ouml;','&Auml;','&szlig;'], 
	            $file[$restKey]
	        );

        	foreach($placeholders as $name => $value)
        	{
        		$name = strtolower($name);
        		$result = str_replace("%".$name."%", $value, $result);
        	}

        	return $result;
        }

        return implode('.', $key);
    }

    public static function lookUpFile($lang, $file)
    {
    	global $dreamcoil_translate_cache;
    	
        Translate::setUpCache();
        if (!isset($dreamcoil_translate_cache[$lang])) $dreamcoil_translate_cache[$lang] = [];
        if (!isset($dreamcoil_translate_cache[$lang][$file])) {
        	$file_path =  __DIR__ . '/../files/Translations/' . $lang . '/'. $file . '.php';
        	if (!file_exists($file_path)) $dreamcoil_translate_cache[$lang][$file] = [];
        	else $dreamcoil_translate_cache[$lang][$file] = include $file_path;
        }

        return $dreamcoil_translate_cache[$lang][$file];
    }

    /**
     * Echos a translation
     * 
     * @param $key
     * @param null $lang
     * @return null
     */
    public static function say($key, $placeholders = [])
    {
        echo Translate::get($key, $placeholders);
        return null;
    }

}
