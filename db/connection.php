<?php

require_once '/ojt/db/save-failed.php';

/**
 * MariaDB 연결되어 데이터 저장에 사용
 */
class Connection {

	private const HOST = 'localhost';
	private const USER_NAME = 'jhlee';
	private const USER_PASSWORD = 'password';
	private const DB_NAME = 'dbProduct';

	private const DSN = 'mysql:host=' . Connection::HOST . ';dbname=' . Connection::DB_NAME  . ';charset=utf8';
	
	private $db = null;
	private $errors = [];

	public function __construct() {

		$this->db = new PDO(Connection::DSN, Connection::USER_NAME, Connection::USER_PASSWORD);
		$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	// 카테고리 확인
	public function existCategory($row, $data) {

		try {

			$sql = 'SELECT COUNT(nCategoryCode)
					FROM tCategory
					WHERE nCategoryCode = :code';

			$prepare = $this->db->prepare($sql);

			$prepare->bindValue(':code', $data[0]);
			
			$prepare->execute();

			return ($prepare->fetchColumn()) >= 1;

		} catch (PDOException $e) {

			$this->errors[] = new SaveFailed($data, $row . '행 existCategory 오류 발생' . $e->getMessage());
		}
	}
	
	// 카테고리 삽입
	public function insertCategory($row, $data) {
		
		try{
			$sql = 'INSERT INTO tCategory (
				  			nCategoryCode,
							sCategoryName)
				 	VALUES (
							:code,
							:name)';

			$prepare = $this->db->prepare($sql);

			$prepare->bindValue(':code', $data[0]);
			$prepare->bindValue(':name', $data[1]);

			$prepare->execute();
			
		} catch (PDOException $e) {

			$this->errors[] = new SaveFailed($data, $row . '행 insertCategory 오류 발생' . $e->getMessage());
		}
	}

	// 상품 삽입
	public function insertProduct($row, $data) {

		try {

			$sql = 'INSERT INTO tProduct (
						nCategoryCode,
						nProductCode,
						sProductName,
						sDescription,
						nLowestPrice)
					VALUES (
						:categoryCode,
						:code,
						:name,
	 					:description,
						:lowestPrice)';

			$prepare = $this->db->prepare($sql);

			$prepare->bindValue(':categoryCode', $data[0]);
			$prepare->bindValue(':code', $data[2]);
			$prepare->bindValue(':name', $data[3]);
			$prepare->bindValue(':description', $data[4]);
			$prepare->bindValue(':lowestPrice', $data[5]);

			$prepare->execute();

		} catch (PDOException $e) {
			
			$this->errors[] = new SaveFailed($data, $row . '행 insertProduct 오류 발생' . $e->getMessage());
		}
	}

	public function close() {
		
		$this->db = null;
	}

	public function printSaveFailed() {

		print_r($this->errors);
		return count($this->errors);
	}
}
