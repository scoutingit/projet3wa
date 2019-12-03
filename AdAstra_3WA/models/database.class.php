<?php

class Database
{
	private $pdo;

	public function __construct()
	{
		try {
			$this->pdo = new PDO('mysql:host=bddserverhost;dbname=bddname;charset=utf8', 
			'bdduser', 
			'bddpasse', 
			array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch (Exeption $e) { 
			die('Erreur lors de la connexion: ' .$e->getMessage())  or die(print_r($bdd->errorInfo()));
		}
	}
	
	//insert/delete/update
	public function prepare($sql, array $values)
	{
		$query = $this->pdo->prepare($sql);
		$query->execute($values);
		return $this->pdo->lastInsertId();
	}
	//select
	public function query($sql, array $values)
	{
		$query = $this->pdo->prepare($sql);
		$query->execute($values);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}
