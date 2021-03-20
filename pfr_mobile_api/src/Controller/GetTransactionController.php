<?php

namespace App\Controller;

use App\Services\SendSms;
use App\Entity\Transaction;
use Symfony\Component\HttpFoundation\RequestStack;

class GetTransactionController
{
    private $request;
    private $sendSms;

    public function __construct(
        RequestStack $stack,
        SendSms $sendSms)
    {
        $this->request = $stack->getCurrentRequest();
        $this->sendSms = $sendSms;
    }
  
 
    public function __invoke($data){
      //  $data->get
     
        // $d=$this->sendSms->sendSms('771184610', 'Vous avez reçu un transfert de 100.000F cfa du 771184610! Code'.$this->request->get('code').' A retirer dans une agence Facile-Money!Lol');
        // dd($d);
         if(!$this->request->get('code')){
             return null;
         }
        // dd($data);
        return $data;
    }
}