<?php
App::uses('AppHelper', 'View/Helper');
App::uses('Sanitize', 'Utility');

class CardHelper extends AppHelper
{
    /**
     * カードの有効期限の月の配列を返す
     */
    public function expiration_month()
    {
        return array(
            '01' => 1, '02' => 2, '03' => 3, '04' => 4, '05' => 5,
            '06' => 6, '07' => 7, '08' => 8, '09' => 9, '10' => 10,
            '11' => 11, '12' => 12
        );
    }

    /**
     * カードの有効期限の年の配列を返す
     */
    public function expiration_year()
    {
        $years = array();
        $now_year = date('Y');
        for($i = 0; $i < 30; $i++){
            $years[substr($now_year, -2)] = $now_year;
            $now_year += 1;
        }
        return $years;
    }

}