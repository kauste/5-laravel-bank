<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaversClient extends Model
{
    use HasFactory;
    
    public function validIban(){
            $clients = SaversClient::all();
            $iban = $this -> iban();
            if($clients != null){
                $shoudRepeat = 0;
                foreach($clients as $client){
                    if($client['saskaitosNr'] == $iban){
                        $shoudRepeat = 1;
                        break;
                    }
                }
            } while(!!$shoudRepeat);
        return $iban;
    }

    public function iban(){
        $accountNum = strval(rand(0, 9)) . strval(rand(0, 9))  . strval(rand(0, 9))  . strval(rand(0, 9)) . strval(rand(0, 9))  . strval(rand(0, 9)) . strval(rand(0, 9)) . strval(rand(0, 9))  . strval(rand(0, 9))  . strval(rand(0, 9)) . strval(rand(0, 9));
            $bankNum = strval(77777);
            $controlSymbols = '01';
            $iban = 'LT' . $controlSymbols .$bankNum . $accountNum;
            return $iban;
    }
    public static function isValidPersonId($personId){
        if (strlen($personId) != 11){
            return false;
        }
        $year = $personId[1] . $personId[2]; 
        $month = $personId[3] . $personId[4];
        $day = $personId[5] . $personId[6];
        function dayRange($month ){
            if ($month == '02'){
                return range(1, 29);
            }
            else if($month == '04' || $month == '06' || $month == '09' || $month == '11') {
                return range(1, 30);
            } else {
                return range(1, 31);
            }
        }
        if (!in_array($personId[0], range(3, 4))
        || !in_array($month, range(1, 12))
        || !in_array($day, dayRange($month))){
            return false;
        }
        else {
            return true;
        }
    }
}
