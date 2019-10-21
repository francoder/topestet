<?php
App::uses('AppHelper', 'View/Helper');

class DisplayHelper extends AppHelper
{
  function errors($array)
  {
    if (empty($array)) {
      return false;
    }
    $result = "";
    if (is_array($array)) {
      //$array = array_unique($array);
      foreach ($array as $line) {
        $result .= $this->errors($line);
      }
    } else {
      $result = "".$array."<br>";
    }

    return $result;
  }

  function short($text, $words_count = 50)
  {
    $retval = $text;
    $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $text);
    $string = str_replace("\n", " ", $string);
    $array  = explode(" ", $string);
    if (count($array) <= $words_count) {
      $retval = $string;
    } else {
      array_splice($array, $words_count);
      $retval = implode(" ", $array)." ...";
    }

    return $retval;

  }

  function sentence($text)
  {
    $pos = strpos($text, ".");
    if ( ! $pos) {
      return $text;
    } else {
      return substr($text, 0, $pos + 1);
    }
  }

  function number($text)
  {
    $drob   = $text - (int)$text;
    $text   = (int)$text;
    $text   = trim($text);
    $text   = str_replace(" ", "", $text);
    $j      = 1;
    $result = "";
    if (empty($text)) {
      return "0";
    }
    for ($i = strlen($text) - 1; $i > -1; $i--) {
      $result[] = $text[$i];
      if ($j % 3 == 0 && $j != strlen($text)) {
        $result[] = "&nbsp;";
      }
      $j++;
    }
    $result = implode(array_reverse($result));

    return $result.substr($drob, 1);
  }

  function file_size($number, $prefix = "k")
  {
    if ($prefix == "k") {
      $r = round($number / 1024, 2)." кб";
    } elseif ($prefix == "m") {
      $r = round($number / 1024 / 1024, 2)." Мб";
    }

    return str_replace(".", ",", $r);
  }

  function link($link, $title)
  {
    if ($this->here == $link) {
      return "<a href=\"$link\" class=\"active\">$title</a>";
    } elseif (strpos($this->here, $link) !== false) {
      return "<a href=\"$link\"><b>$title</b></a>";
    } else {
      return "<a href=\"$link\">$title</a>";
    }
  }

  /**
   * Enter description here...
   *
   * @param unknown_type $num
   * @param 0 - для 1, 1 - для 2,3,4, 2 - ост
   *
   * @return unknown
   */
  function cas($num, $cas)
  {
    if ($num < 21) {
      if (in_array($num, array(2, 3, 4))) {
        return $cas[1];
      } elseif ($num == 1) {
        return $cas[0];
      } else {
        return $cas[2];
      }
    } else {
      return $this->cas(substr($num, strlen($num) - 1, 1), $cas);
    }
  }

  function date($format, $time)
  {
    $monthes = array(
      1  => __('января'),
      2  => __('февраля'),
      3  => __('марта'),
      4  => __('апреля'),
      5  => __('мая'),
      6  => __('июня'),
      7  => __('июля'),
      8  => __('августа'),
      9  => __('сентября'),
      10 => __('октября'),
      11 => __('ноября'),
      12 => __('декабря'),
    );
    $m       = (int)date("m", $time);

    $lang   = Configure::read('Config.language');
    $format = preg_replace("/%(\m)/", $monthes[$m], $format);

    return date($format, $time);
  }

  function profile_url($data)
  {
    if (isset($data['User'])) {
      $data = $data['User'];
    }
    $login = $data['login'];
    if (empty($login)) {
      $login = "id".$data['id'];
    }

    return "/profile/page/$login/";
  }

  function time_ago($time)
  {
    $time = strtotime($time);
    $now  = date("U");
    $dif  = $now - $time;
    if ($dif < 60) {
      return __("только что");
    } elseif ($dif < 1 * 60 * 60) {
      //минуты (до 1 часа
      $minutes = (int)($dif / 60);

      return $minutes." ".$this->cas($minutes, array(__("минуту назад"), __("минуты назад"), __("минут назад")));
    } elseif ($dif < 1 * 24 * 60 * 60) {
      //часы (до одного дня)
      $hours = (int)($dif / 60 / 60);

      return $hours." ".$this->cas($hours, array(__("час назад"), __("часа назад"), __("часов назад")));
    } elseif ($dif < 2 * 24 * 60 * 60) {
      return __("вчера");
    } else {
      $days = (int)($dif / (24 * 60 * 60));

      return $days." ".$this->cas($days, array(__("день назад"), __("дня назад"), __("дней назад")));
    }
  }

  function first_phrase($text)
  {
    $point = strpos($text, ".");
    if ($point == false) {
      return $text;
    } else {
      return substr($text, 0, $point + 1);
    }
  }

  function case_field($data, $cas = false, $field = "title")
  {
    if ( ! $cas || ! isset($data["{$field}_{$cas}"]) || empty($data["{$field}_$cas"])) {
      return $data[$field];
    } else {
      return $data["{$field}_$cas"];
    }
  }

  function format($text, $isTextP = false)
  {
      $classList = $isTextP === false ? '' : 'class="text"';
    $text = "<p $classList>".str_replace("\r\n", "</p></p>", $text)."</p>";

    return $text;
  }


  function pluralReview($number)
  {
    if ($number % 10 == 1 && $number % 100 != 11) {
      return $number.' отзыв';
    } else {
      if ($number % 10 >= 2 && $number % 10 <= 4 && ($number % 100 < 10 || $number % 100 >= 20)) {
        return ($number.' отзыва');
      } else {
        return ($number.' отзывов');
      }
    }
  }

  function pluralComment($number)
  {
    if ($number % 10 == 1 && $number % 100 != 11) {
      return $number.' ответ';
    } else {
      if ($number % 10 >= 2 && $number % 10 <= 4 && ($number % 100 < 10 || $number % 100 >= 20)) {
        return ($number.' ответа');
      } else {
        return ($number.' ответов');
      }
    }
  }

  public function formatPrice($price) {

    return number_format($price,0, '.', " ");
  }

  public function formatRating($number, $precision = 1, $separator = '.') {
    $numberParts = explode($separator, $number);
    $response = $numberParts[0];

    if(count($numberParts)>1){
      $response .= $separator;
      $response .= substr($numberParts[1], 0, $precision);
    } else {

      if(empty($response))  $response = 0;
      $response .= $separator . '0';
    }
    return $response;
  }

  public function formatDate($date, $format = 'd.m.Y') {
    $tmp = $this->date($format, $date);

    return $tmp;
  }

}

?>
