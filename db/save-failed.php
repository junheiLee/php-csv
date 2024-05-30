<?php

/**
 * PDO로 저장에 실패한 내역
 */
class SaveFailed {
    
    private $data;
    private $message;
    
    public function __construct($data, $message) {
        $this->data    = $data;
        $this->message = $message;
    }
}