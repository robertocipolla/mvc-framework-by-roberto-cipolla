<?php
	class Post {
		private $db;

		public function __construct(){
			$this->db = new Database();
		}

		public function create($data){
			$this->db->query('INSERT INTO posts(title, body, author) values(:title, :body, :author) ');

			$this->db->bind(":title", $data["title"]);
			$this->db->bind(":body", $data["body"]);
			$this->db->bind(":author", $data["author"]);

			if($this->db->rowCount() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function showAll(){
			$this->db->query('SELECT * FROM posts ORDER BY created_at DESC');

			$row = $this->db->resultSet();

			if($this->db->rowCount() > 0){
				return $row;
			}else{
				return false;
			}
		}
	}