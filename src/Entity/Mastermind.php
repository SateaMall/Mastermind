<?php
namespace App\Entity;

 class Mastermind implements iMastermind { // sauver en session
    private $randomValue;
    private $Essais;
    private $taille;

    public function __construct($taille=4)
 {
    $this->Essais=[];
    $this->taille=$taille;
    $this->randomValue="";
    while(strlen($this->randomValue)<$taille )
    {
        $randomDigit=random_int(0,9);
        while (substr($this->randomValue, -1)==$randomDigit){
            $randomDigit=random_int(0,9);
        }
        $this->randomValue.=$randomDigit;
    }
 }

public function test($code){
    if (strlen($code) != $this->taille) {
        // Optionally handle error for incorrect code length
        return false;
    }
    $bienPlace=0;
    $malPlace=0;
    for ($i=0; $i<$this->taille; $i++){
        if($code[$i]==$this->randomValue[$i]){
            $bienPlace++;
        }
        else{
            for ($j=0; $j<$this->taille; $j++)
                {
                   if($code[$i]==$this->randomValue[$j]){
                    $malPlace++;
                    break;
                   } 
                }
        }
    }
    $this->Essais[] = [
        'code' => $code,
        'bienPlace' => $bienPlace,
        'malPlace' => $malPlace
    ];
    return $this->isFini(); 
}
public function getEssais(){
    return $this->Essais;
}
public function getTaille(){
    return $this->taille;
}
public function isFini(){
    if (empty($this->Essais)) return false;
    $lastEssai=end($this->Essais);
    return  $lastEssai['bienPlace'] == $this->taille;
}
public function serialize() {
    return serialize([
        "taille" => $this->taille,
        "randomValue" => $this->randomValue,
        "essais" => $this->Essais,
    ]);
}

public function unserialize($serialized) {
    $data = unserialize($serialized);
    $this->taille = $data["taille"];
    $this->Essais = $data["essais"];
    $this->randomValue = $data["randomValue"];
}
}
