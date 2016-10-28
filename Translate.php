<?php

namespace Dreamcoil;

class Translate
{
    private $lang;

    /**
     * Sets the language
     *
     * @param $lang
     */
    public function setLang($lang)
    {
        global $console;

        $this->lang = $lang;

        if(isset($console)) setcookie('lang', $lang, time() * 2);
        
        return true;

    }

    /**
     * Gets the translation for a translation key
     *
     * @param $key
     * @param null $lang
     * @return string
     */
    public function get($key, $lang = null)
    {

        $config = new \Dreamcoil\Config;

        $key = explode('.',$key);

        $fallback = $config->get('fallback_lang');

        if($lang === null)
        {

            if(!file_exists( __DIR__ . '/../files/Translations/' . $fallback . '/'. $key[0] . '.php'))
                return implode('.', $key);

            $lang = include __DIR__ . '/../files/Translations/' . $fallback . '/'. $key[0] . '.php';

            if(isset($lang[$key[1]])) return $lang[$key[1]];

            return implode('.', $key);

        }

        if(!file_exists( __DIR__ . '/../files/Translations/' . $lang . '/'. $key[0] . '.php'))
            return implode('.', $key);

        $lang = include __DIR__ . '/../files/Translations/' . $lang . '/'. $key[0] . '.php';

        if(isset($lang[$key[1]])) return str_replace(
            ['ü',     'ö',     'ä',     'Ü',     'Ö',     'Ä',     'ß'], 
            ['&uuml;','&ouml;','&auml;','&Uuml;','&Ouml;','&Auml;','&szlig;'], 
            $lang[$key[1]]
            );

        return implode('.', $key);

    }

    /**
     * Echos a translation
     * 
     * @param $key
     * @param null $lang
     * @return null
     */
    public function say($key, $lang = null)
    {
        echo Translate::get($key, $lang);
        return null;
    }

}
