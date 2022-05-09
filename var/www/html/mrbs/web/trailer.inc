<?php
namespace MRBS;

function generate_trailer()
{
  global $year, $month, $day, $area, $room;
  global $strftime_format, $weekstarts, $simple_trailer, $view_week_number;

  $output = "";

  if(!isset($year))
  {
    $year = strftime("%Y");
  }

  if (!isset($month))
  {
    $month = strftime("%m");
  }

  if (!isset($day))
  {
    $day = strftime("%d");
  }

  if (empty($area))
  {
    $params = "";
  }
  else
  {
    $params = "&amp;area=$area";
  }
  if (!empty($room))
  {
    $params .= "&amp;room=$room";
  }

  $output .= "</div>";  // Close of the contents div

  if ($simple_trailer)
  {
    $output .= "<div class=\"screenonly trailer\" id=\"simple_trailer\">";
    $output .= "<div id=\"simple\">";
    $output .= "<a href=\"day.php?year=$year&amp;month=$month&amp;day=$day$params\">";
    $output .= get_vocab("viewday")."</a>|";
    $output .= "<a href=\"week.php?year=$year&amp;month=$month&amp;day=$day$params\">";
    $output .= get_vocab("viewweek")."</a>|";
    $output .= "<a href=\"month.php?year=$year&amp;month=$month&amp;day=$day$params\">";
    $output .= get_vocab("viewmonth")."</a>";
    $output .= "</div>";
    $output .= "</div>";
  }
  else
  {
    //$output .= "<div class=\"screenonly trailer\" id=\"trailer\">";
  
    // DAYS
//ACA EN VEZ DE CENTER VA "\n"
// $output .= "<div id=\"viewday\"><center>";

    $output .= "<div><center>"; //YO

//ULT    $output .= "<div>";  

//ACA VA $output .= "<div class=\"trailer_label\">\n";
    //$output .= "<a href=\"day.php?year=$year&amp;month=$month&amp;day=$day$params\">" . 
    //            get_vocab("viewday") . "</a>\n";

//A ESTO LO AGREGUE YO

    $output .= "<a href=\"day.php?year=$year&amp;month=$month&amp;day=$day$params\">D&iacute;a&nbsp;&nbsp;|&nbsp;&nbsp;</a>";

    //$output .= "|";    

//HASTA ACA    
//ULT    $output .= "</div>"; //ACA \n

//ULT    $output .= "<div>"; //ACA
// $output .= "<div class=\"trailer_links\">\n"; //YO
    for ($i = -6; $i <= 7; $i++)
    {
      $ctime = mktime(0, 0, 0, $month, $day + $i, $year);
  
      $str = utf8_strftime($strftime_format['daymonth'], $ctime);
      $class = "";
  
      $cyear  = date("Y", $ctime);
      $cmonth = date("m", $ctime);
      $cday   = date("d", $ctime);
    
      // put in a separator, unless we are at the beginning
      if ($i != -6)
      {
// A ESTO LO COMENTE YO        $output .= " | ";
      }
    
      // if it's a hidden day set the class; otherwise construct the anchor
      // (don't offer a link if the day is a hidden day)
      if (is_hidden_day(date("w", $ctime)))
      { 
        $class .= "hidden";      
      }
      else
      {
       $str = "<a href=\"day.php?year=$cyear&amp;month=$cmonth&amp;day=$cday$params\">" . $str . "</a>";


      }
    
      // and if it's the current day, add square brackets and set the class
//A ESTO LO COMENTE YO
/*      if ($i == 0)
      {
        $str = "[ " . $str . " ]";
        if (empty($class))
        {
          $class = "current";
        }
        else
        {
          $class .= " current";
        }
      } 
      $output .= "<span" . ((empty($class)) ? '' : " class=\"$class\"") . ">$str</span>\n";  */
//HASTA ACA COMENTE YO
    }
// A ESTO LO COMENTE YO   $output .= "</div>\n";
  
// A ESTO LO COMENTE YO   $output .= "</div>\n";
  
  
    // WEEKS
//    $output .= "<div id=\"viewweek\">\n"; //YO COMENTE y AGREGUE
//ULT    $output .= "<div>"; //YO

//    $output .= "<div class=\"trailer_label\">\n"; //YO COMENTE y AGREGUE
//ULT    $output .= "<div>"; 

//A ESTO LO MODIFIQUE YO
    //$output .= "<a href=\"week.php?year=$year&amp;month=$month&amp;day=$day$params\">" .
    //            get_vocab("viewweek") . "</a>\n";
    
    
    $output .= "<a href=\"week.php?year=$year&amp;month=$month&amp;day=$day$params\">Semana&nbsp;&nbsp;|&nbsp;&nbsp;</a>";

   // $output .= "|";

//ULT    $output .= "</div>"; //ACA VA \n
//TOQUE HASTA ACA
 
    $ctime = mktime(0, 0, 0, $month, $day, $year);
    // How many days to skip back to first day of week:
    $skipback = (date("w", $ctime) - $weekstarts + 7) % 7;
  
//    $output .= "<div class=\"trailer_links\">\n"; //YO COMENTE y AGREGUE
//ULT    $output .= "<div>";

    for ($i = -4; $i <= 4; $i++)
    {
      $ctime = mktime(0, 0, 0, $month, $day + 7 * $i - $skipback, $year);
  
      $cweek  = date("W", $ctime);
      $cday   = date("d", $ctime);
      $cmonth = date("m", $ctime);
      $cyear  = date("Y", $ctime);
    
      // $htime gives you the d/m/y to use in the href link.    This is the
      // real day that we want to look at, whereas $ctime is the start of that week
      $htime = mktime(0, 0, 0, $month, $day + 7 * $i, $year);
      $hday   = date("d", $htime);
      $hmonth = date("m", $htime);
      $hyear  = date("Y", $htime);

//A ESTO LO COMENTE YO    
/*      if ($i != -4)
      {
        $output .= " | ";
      }
  
      if ($view_week_number)
      {
        $str = $cweek;
      }
      else
      {
        $str = utf8_strftime($strftime_format['daymonth'], $ctime);
      }
      if ($i == 0)
      {
        $output .= "<span class=\"current\">\n[ ";
      }
      $output .= "  <a href=\"week.php?year=$hyear&amp;month=$hmonth&amp;day=$hday$params\">$str</a>\n";
      if ($i == 0)
      {
        $output .= "]</span>\n";
      }*/
//HASTA ACA COMENTE YO  
    }

//A ESTO LO COMENTE YO     $output .= "</div>\n"; 
  
//A ESTO LO COMENTE YO     $output .= "</div>\n"; 

  
    // MONTHS
/*    $output .= "<div id=\"viewmonth\">\n"; 
    $output .= "<div class=\"trailer_label\">\n";  */ //AGREGUE
 
//ULT    $output .= "<div>"; 
//ULT    $output .= "<div>";


//A ESTO LO COMENTE YO
    //$output .= "<a href=\"month.php?year=$year&amp;month=$month&amp;day=$day$params\">" . 
    //            get_vocab("viewmonth") . "</a>\n";

    $output .= "<a href=\"month.php?year=$year&amp;month=$month&amp;day=$day$params\">Mes</a>"; //ACA
//ULT    $output .= "</div>"; //ACA
 //MODIFIQUE HASTA ACA 

//    $output .= "<div class=\"trailer_links\">";  CAMBIE
    
//ULT    $output .= "<div>";
    for ($i = -2; $i <= 6; $i++)
    {
      $ctime = mktime(0, 0, 0, $month + $i, 1, $year);
      $str = utf8_strftime($strftime_format['monyear'], $ctime);
     
      $cmonth = date("m", $ctime);
      $cyear  = date("Y", $ctime);
      $cday   = $day;
      // decrement day until it's a valid one for the month, in case you're moving to a month with fewer
      // days than the current one

//A ESTO LO COMENTE YO
/*    while (!checkdate($cmonth, $cday, $cyear) && ($cday > 1))
      {
        $cday--;
      }
      if ($i != -2)
      {
    $output .= " | ";
      }
      if ($i == 0)
      {
        $output .= "<span class=\"current\">\n[ ";
      }
        $output .= "  <a href=\"month.php?year=$cyear&amp;month=$cmonth&amp;day=$cday$params\">$str</a>\n";
      if ($i == 0)
      {
        $output .= "]</span>\n";
      }*/ 
//HASTA ACA COMENTE YO
    }
//ULT    $output .= "</div>";  // end of links div ACA
//ULT    $output .= "</div>";  // end of viewmonth ACA
    $output .= "</div>";  // end of "classic" trailer ACA
  }
  return $output;
}


// Output the trailer for the bottom of the page, including the footer
function output_trailer()
{
  echo generate_trailer();

  // Print footer
  print_footer(FALSE);
}

