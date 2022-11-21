<?php
	class Example {
		//muutujad - klassis omadused ehk properties
		//privaatsed ja avalikud
		private $secret_value;
		public $known_value = 7; //suvaline arv näiteks
		private $received_value;
		
		//funktsioonid - klassis meetodid ehk methods
		
		//eriline funktsioon/meetod on konstruktor, mis käivitub klassi kasutusele võtul kohe ja üks kord
		function __construct($value) {
			echo "Klass käivitus!<br>";
			$this->secret_value = mt_rand(1,10); //secret_value ilma $-ta, sest ees juba olemas
			echo "Salajane väärtus on: " .$this->secret_value ."<br>";
			$this->received_value = $value;
			$this->multiply();
		} 
		
		//destructor, mis käivitub, kui objekt tühistatakse
		function __destruct() {
				echo "Klass lõpetas töö! <br>";
		}
		
		private function multiply() {
			echo "Privaatsete väärtuste korrutis on: " .$this->secret_value * $this->received_value ."<br>";
		}
		
		public function add() {
			echo "Privaatsete väärtuste summa on: " .$this->secret_value + $this->received_value ."<br>";
		}
		
	} //class