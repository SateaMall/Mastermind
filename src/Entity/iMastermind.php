<?php
namespace App\Entity;

 interface iMastermind extends \Serializable { // sauver en session
public function __construct($taille=4); // crée un nouveau jeu
public function test($code); // teste une proposition
public function getEssais(); // ret les prop. préc.
public function getTaille(); // taille du jeu (4)
public function isFini(); // vrai si jeu fini : 4 bien placés
}
