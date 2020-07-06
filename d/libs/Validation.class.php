<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    class Validation{
        public function isText($str){
            $preg = '/^[a-zA-Z ]+$/';
            return preg_match($preg,$str);
        }
		public function stringToStandard($str){
			$preg ='/\s+/';
			return preg_replace($preg,' ',$str);	
		}
		public function isEmail($str){
			$reg ='/^[a-z0-9A-Z\_\.\-]+\@[a-z0-9A-z]+\.[a-z]{2,4}(\.[a-z]{2,4})?$/';
			return preg_match($reg,$str);
		}
    }
