<?php

namespace App\Entity;

class UserSearch {



  private $level;

  private $subject;

  public function getLevel(){
    return $this->level;
  }


  public function setLevel($lvl){
    $this->level =$lvl;
    return $this;
  }


  public function getSubject(){
    return $this->subject;
  }


  public function setSubject($subj){
    $this->subject =$subj;
    return $this;
  }

}

