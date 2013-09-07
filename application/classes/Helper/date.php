<?php

class Helper_Date {

  public static function getDiffInDaysFromMySqlDates( $inDate1, $inDate2 ){
    $date1= DateTime::createFromFormat( 'Y-m-d', $inDate1 );
    $date2 = DateTime::createFromFormat( 'Y-m-d', $inDate2 );

    $dateInterval = $date2->diff( $date1 );

    return $dateInterval->d;
  }
}
?>
