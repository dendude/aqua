<?php

namespace app\helpers;

use app\components\idna_convert;
use app\components\VK;
use Yii;
use yii\helpers\Html;
use \Exception;

class Normalize {

	public static function getDate($date) {

		return date('d.m.Y', strtotime($date));
	}

    public static function getDateByTime($time) {

        return date('d.m.Y', $time);
    }

    public static function fixAlias($alias, $arr = false) {

        if ($alias == 'index' && Yii::$app->controller->id != 'site') {
            return '/';
        }

        $url = ($alias == 'index' ? 'index' : '/' . trim($alias, '/'));
        return $arr ? [$url] : $url;
    }

	public static function getMonthName($date) {

		$monthNumber = date('m', strtotime($date));

		switch($monthNumber) {

			case '01': $m = 'янв'; break;
			case '02': $m = 'фев'; break;
			case '03': $m = 'мар'; break;
			case '04': $m = 'апр'; break;
			case '05': $m = 'май'; break;
			case '06': $m = 'июн'; break;
			case '07': $m = 'июл'; break;
			case '08': $m = 'авг'; break;
			case '09': $m = 'сен'; break;
			case '10': $m = 'окт'; break;
			case '11': $m = 'ноя'; break;
			case '12': $m = 'дек'; break;
		}

		return $m;
	}

	public static function getFullDate($date, $sep = ' ', $seconds = false) {

		$time = strtotime($date);

        if ($time == 0) return '';

		$day = date('j', $time);
		$month = self::getMonthName($date);

		if(date('Y-m-d') == date('Y-m-d', $time)) {
            $result = 'Сегодня' . $sep . date('H:i', $time);
        } elseif(date('Y-m-d') == date('Y-m-d', strtotime($date.' +1 day'))) {
            $result = 'Вчера' . $sep . date('H:i', $time);
        } else {
            $result = $day.' '.$month.' '.date('Y', $time).$sep.date('H:i', $time);
        }

        if ($seconds) $result .= date(':s', $time);

		return $result;
	}

    public static function getFullDateByTime($time, $sep = ' ', $seconds = false) {

        return self::getFullDate(date('Y-m-d H:i:s', $time), $sep, $seconds);
    }

    public static function getShortDateByTime($time, $sep = ' ') {

        $full_date = self::getFullDate(date('Y-m-d H:i:s', $time), $sep);
        $parts = explode($sep, $full_date);
        return $parts[0];
    }

	public static function printPre($data) {

		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}

    public static function realDuration($seconds) {
        $minutes = floor($seconds/60);
        $seconds = $seconds - ($minutes * 60);
        if ($seconds < 10) $seconds = '0' . $seconds;

        return $minutes . ':' . $seconds;
    }

    public static function alias($str) {

            $str = preg_replace('/[^a-z0-9\-\/ ]/i', '', self::translitRu($str));
            $str = trim($str, '/');
            $str = ltrim($str, '-');
            $str = rtrim($str, '-');
            $str = str_replace(' ', '-', trim($str));
            $str = preg_replace('/-{2,}/', '-', $str);

            return $str;
    }

    public static function translitRu($str, $lower = true) {

        $cyr = array(
            "Щ", "Ш", "Ч","Ц", "Ю", "Я", "Ж","А","Б","В",
            "Г","Д","Е","Ё","З","И","Й","К","Л","М","Н",
            "О","П","Р","С","Т","У","Ф","Х","Ь","Ы","Ъ",
            "Э","Є", "Ї","І",
            "щ", "ш", "ч","ц", "ю", "я", "ж","а","б","в",
            "г","д","е","ё","з","и","й","к","л","м","н",
            "о","п","р","с","т","у","ф","х","ь","ы","ъ",
            "э","є", "ї","і","№"
        );
        $lat = array(
            "Shch","Sh","Ch","C","Yu","Ya","J","A","B","V",
            "G","D","e","e","Z","I","y","K","L","M","N",
            "O","P","R","S","T","U","F","H","",
            "Y","" ,"E","E","Yi","I",
            "shch","sh","ch","ts","yu","ya","j","a","b","v",
            "g","d","e","e","z","i","y","k","l","m","n",
            "o","p","r","s","t","u","f","h",
            "", "y","" ,"e","e","yi","i","#"
        );

        $amount = count($cyr);
        for($i = 0; $i < $amount; $i++)  {
            $c_cyr = $cyr[$i];
            $c_lat = $lat[$i];
            $str = str_replace($c_cyr, $c_lat, $str);
        }

        $str = preg_replace('/ {2,}/',' ',$str);
        $str = str_replace(' ','-',$str);

        return $lower ? strtolower($str) : $str;
    }

    public static function wordAmount($amount, $words, $full = false) {

        $return_word = $words[0];
        $test_amount = abs($amount);

        switch ($test_amount % 10) {
            case 1:
                $return_word = $words[1];
                break;
            case 2:
            case 3:
            case 4:
                $return_word = $words[2];
                break;
        }

        if ($test_amount >= 10 && $test_amount <= 20) $return_word = $words[0];
        if ($full) $return_word = $amount . ' ' . $return_word;

        return $return_word;
    }

    public static function formatPhone($phone) {

        $result = '';
        $phone = preg_replace('/[^0-9]+/','',$phone);

        if (trim($phone) != '') {

            $result = '(' . substr($phone, -10, -7) . ') ' . substr($phone, -7, -4) . '-' . substr($phone, -4, -2) . '-' . substr($phone, -2);

            if (strlen($phone) > 10) {
                $result = '+' . substr($phone, 0, -10) . ' ' . $result;
            }
        }

        return $result;
    }

    public static function cleanPhone($phone){
        return preg_replace('/[^0-9,]+/', '', $phone);
    }
}