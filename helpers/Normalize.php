<?php

namespace app\helpers;

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
        $full_date = self::getFullDateByTime($time, $sep);
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

            $str = preg_replace('/[^a-z0-9\- ]/i', '', self::translitRu($str));
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

    public static function mnemonicDecode($str) {

        $mnemonics = array(
            '&quot;'=>'\42',
            '&amp;'=>'\46',
            '&lt;'=>'\74',
            '&gt;'=>'\76',
            '&nbsp;'=>'\240',
            '&iexcl;'=>'\241',
            '&cent;'=>'\242',
            '&pound;'=>'\243',
            '&curren;'=>'\244',
            '&yen;'=>'\245',
            '&brvbar;'=>'\246',
            '&sect;'=>'\247',
            '&uml;'=>'\250',
            '&copy;'=>'\251',
            '&ordf;'=>'\252',
            '&laquo;'=>'\253',
            '&not;'=>'\254',
            '&shy;'=>'\255',
            '&reg;'=>'\256',
            '&macr;'=>'\257',
            '&deg;'=>'\260',
            '&plusmn;'=>'\261',
            '&sup2;'=>'\262',
            '&sup3;'=>'\263',
            '&acute;'=>'\264',
            '&micro;'=>'\265',
            '&para;'=>'\266',
            '&middot;'=>'\267',
            '&cedil;'=>'\270',
            '&sup1;'=>'\271',
            '&ordm;'=>'\272',
            '&raquo;'=>'\273',
            '&frac14;'=>'\274',
            '&frac12;'=>'\275',
            '&frac34;'=>'\276',
            '&iquest;'=>'\277',
            '&Agrave;'=>'\300',
            '&Aacute;'=>'\301',
            '&Acirc;'=>'\302',
            '&Atilde;'=>'\303',
            '&Auml;'=>'\304',
            '&Aring;'=>'\305',
            '&AElig;'=>'\306',
            '&Ccedil;'=>'\307',
            '&Egrave;'=>'\310',
            '&Eacute;'=>'\311',
            '&Ecirc;'=>'\312',
            '&Euml;'=>'\313',
            '&Igrave;'=>'\314',
            '&Iacute;'=>'\315',
            '&Icirc;'=>'\316',
            '&Iuml;'=>'\317',
            '&ETH;'=>'\320',
            '&Ntilde;'=>'\321',
            '&Ograve;'=>'\322',
            '&Oacute;'=>'\323',
            '&Ocirc;'=>'\324',
            '&Otilde;'=>'\325',
            '&Ouml;'=>'\326',
            '&times;'=>'\327',
            '&Oslash;'=>'\330',
            '&Ugrave;'=>'\331',
            '&Uacute;'=>'\332',
            '&Ucirc;'=>'\333',
            '&Uuml;'=>'\334',
            '&Yacute;'=>'\335',
            '&THORN;'=>'\336',
            '&szlig;'=>'\337',
            '&agrave;'=>'\340',
            '&aacute;'=>'\341',
            '&acirc;'=>'\342',
            '&atilde;'=>'\343',
            '&auml;'=>'\344',
            '&aring;'=>'\345',
            '&aelig;'=>'\346',
            '&ccedil;'=>'\347',
            '&egrave;'=>'\350',
            '&eacute;'=>'\351',
            '&ecirc;'=>'\352',
            '&euml;'=>'\353',
            '&igrave;'=>'\354',
            '&iacute;'=>'\355',
            '&icirc;'=>'\356',
            '&iuml;'=>'\357',
            '&eth;'=>'\360',
            '&ntilde;'=>'\361',
            '&ograve;'=>'\362',
            '&oacute;'=>'\363',
            '&ocirc;'=>'\364',
            '&otilde;'=>'\365',
            '&ouml;'=>'\366',
            '&divide;'=>'\367',
            '&oslash;'=>'\370',
            '&ugrave;'=>'\371',
            '&uacute;'=>'\372',
            '&ucirc;'=>'\373',
            '&uuml;'=>'\374',
            '&yacute;'=>'\375',
            '&thorn;'=>'\376',
            '&yuml;'=>'\377',
            '&OElig;'=>'\u0152',
            '&oelig;'=>'\u0153',
            '&Scaron;'=>'\u0160',
            '&scaron;'=>'\u0161',
            '&Yuml;'=>'\u0178',
            '&circ;'=>'\u02c6',
            '&tilde;'=>'\u02dc',
            '&Alpha;'=>'\u0391',
            '&Beta;'=>'\u0392',
            '&Gamma;'=>'\u0395',
            '&Delta;'=>'\u0394',
            '&Epsilon;'=>'\u0395',
            '&Zeta;'=>'\u0396',
            '&Eta;'=>'\u0397',
            '&Theta;'=>'\u0398',
            '&Iota;'=>'\u0399',
            '&Kappa;'=>'\u039a',
            '&Lambda;'=>'\u039b',
            '&Mu;'=>'\u039c',
            '&Nu;'=>'\u039D',
            '&Xi;'=>'\u039e',
            '&Omicron;'=>'\u039f',
            '&Pi;'=>'\u03a0',
            '&Rho;'=>'\u03a1',
            '&Sigma;'=>'\u03A3',
            '&Tau;'=>'\u03A4',
            '&Upsilon;'=>'\u03A5',
            '&Phi;'=>'\u03A6',
            '&Chi;'=>'\u03A7',
            '&Psi;'=>'\u03A8',
            '&Omega;'=>'\u03A9',
            '&alpha;'=>'\u03b1',
            '&beta;'=>'\u03b2',
            '&gamma;'=>'\u03b3',
            '&delta;'=>'\u03b4',
            '&epsilon;'=>'\u03b5',
            '&zeta;'=>'\u03b6',
            '&eta;'=>'\u03b7',
            '&theta;'=>'\u03b8',
            '&iota;'=>'\u03b9',
            '&kappa;'=>'\u03ba',
            '&lambda;'=>'\u03bb',
            '&mu;'=>'\u03bc',
            '&nu;'=>'\u03bd',
            '&xi;'=>'\u03be',
            '&omicron;'=>'\u03bf',
            '&pi;'=>'\u03c0',
            '&rho;'=>'\u03c1',
            '&sigmaf;'=>'\u03c2',
            '&sigma;'=>'\u03c3',
            '&tau;'=>'\u03c4',
            '&upsilon;'=>'\u03c5',
            '&phi;'=>'\03c6',
            '&chi;'=>'\u03c7',
            '&psi;'=>'\u03c8',
            '&omega;'=>'\u03c9',
            '&thetasym;'=>'\u03D1',
            '&upsih;'=>'\u03D2',
            '&piv;'=>'\u03D6',
            '&ensp;'=>'\u2002',
            '&emsp;'=>'\u2003',
            '&thinsp;'=>'\u2009',
            '&zwnj;'=>'\u200C',
            '&zwj;'=>'\u200d',
            '&lrm;'=>'\u200e',
            '&rlm;'=>'\u200f',
            '&ndash;'=>'\u2013',
            '&mdash;'=>'\u2014',
            '&lsquo;'=>'\u2018',
            '&rsquo;'=>'\u2019',
            '&sbquo;'=>'\u201a',
            '&ldquo;'=>'\u201c',
            '&rdquo;'=>'\u201d',
            '&bdquo;'=>'\u201e',
            '&dagger;'=>'\u2020',
            '&Dagger;'=>'\u2021',
            '&permil;'=>'\u2030',
            '&lsaquo;'=>'\u2039',
            '&rsaquo;'=>'\u203a',
            '&bull;'=>'\u2219',
            '&hellip;'=>'\u2026',
            '&prime;'=>'\u2032',
            '&Prime;'=>'\u2033',
            '&oline;'=>'\u203e',
            '&frasl;'=>'\u8260',
            '&weierp;'=>'\u2118',
            '&image;'=>'\u2111',
            '&real;'=>'\u211c',
            '&trade;'=>'\u2122',
            '&alefsym;'=>'\u2135',
            '&larr;'=>'\u2190',
            '&uarr;'=>'\u2191',
            '&rarr;'=>'\u2192',
            '&darr;'=>'\u2193',
            '&harr;'=>'\u2194',
            '&crarr;'=>'\u21b5',
            '&lArr;;'=>'\u21d0',
            '&uArr;'=>'\u21d1',
            '&rArr;'=>'\u21d2',
            '&dArr;'=>'\ud1d3',
            '&hArr;'=>'\u21d4',
            '&forall;'=>'\u2200',
            '&part;'=>'\u2202',
            '&exist;'=>'\u2203',
            '&empty;'=>'\u2205',
            '&nabla;'=>'\u2207',
            '&isin;'=>'\u2208',
            '&notin;'=>'\u2209',
            '&ni;'=>'\u220b',
            '&prod;'=>'\u03a0',
            '&sum;'=>'\u03a3',
            '&minus;'=>'\u2212',
            '&lowast;'=>'\u2217',
            '&radic;'=>'\u221a',
            '&prop;'=>'\u221d',
            '&infin;'=>'\u221e',
            '&ang;'=>'\u2220',
            '&and;'=>'\u2227',
            '&or;'=>'\u2228',
            '&cap;'=>'\u2229',
            '&cup;'=>'\u222a',
            '&int;'=>'\u222b',
            '&there4;'=>'\u2234',
            '&sim;'=>'\u223c',
            '&cong;'=>'\u2245',
            '&asymp;'=>'\u2248',
            '&ne;'=>'\u2260',
            '&equiv;'=>'\u2261',
            '&le;'=>'\u2264',
            '&ge;'=>'\u2265',
            '&sub;'=>'\u2282',
            '&sup;'=>'\u2283',
            '&nsub;'=>'\u2284',
            '&sube;'=>'\u2286',
            '&supe;'=>'\u2287',
            '&oplus;'=>'\u2295',
            '&otimes;'=>'\u2297',
            '&perp;'=>'\u22a5',
            '&sdot;'=>'\u22c5',
            '&lceil;'=>'\u2308',
            '&rceil;'=>'\u2309',
            '&lfloor;'=>'\u230a',
            '&rfloor;'=>'\u230b',
            '&lang;'=>'\u2329',
            '&rang;'=>'\u232a',
            '&loz;'=>'\u25ca',
            '&spades;'=>'\u2660',
            '&clubs;'=>'\u2663',
            '&hearts;'=>'\u2665',
            '&diams;'=>'\u2666'
        );

        return strtr($str, $mnemonics);
    }
}