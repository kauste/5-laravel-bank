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
    
}
