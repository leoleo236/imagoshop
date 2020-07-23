<?php

/*  Initialisation de la classe OrderModel.
    Contient les fonctions relatives aux produits
    qui intéragissent avec la base de données
    (requêtes SQL). */
class TeeModel {
    
// Liste des produits.
	public function listAllTee() {
        $database = new Database();
        $sql = 'SELECT
                    *
                FROM tee';
        return $database->query($sql, []);
    }

// Sélection d'un produit.
    public function findOneTee($productId) {
    	$database = new Database();
        $sql = 'SELECT
                    *
                FROM tee
                WHERE Id = ?';
        return $database->queryOne($sql, [ $productId ]);
    }

// Fonction (admin) d'ajout d'un produit à la bdd.
    public function addTee($post, $name) {
        $database = new Database(); 
        $sql = 'INSERT INTO tee(Name, Photo, Description, QuantityInStock, BuyPrice, SalePrice) VALUES (?, ?, ?, ?, ?, ?)';

         $database->executeSql($sql, [ $post['name'],$name, $post['description'], $post['quantity'], $post['buyPrice'], $post['salePrice'] ]);
    }

// Fonction (admin) de suppression d'un produit.
    public function deleteTee($id) {
        $database = new Database();
        $sql = 'DELETE FROM tee WHERE Id=?';
        $database->executeSql($sql, [ $id ]);     
    }

// Fonction (admin) de modification d'un produit.
    public function updateTee($id, $post, $photo) {
        $database = new Database(); 
        $sql = 'UPDATE tee SET Name=?, Photo=?, Description=?, QuantityInStock=?, BuyPrice=?, SalePrice=? WHERE Id = ?';
 
        $database->executeSql($sql, [ $post['name'], $photo, $post['description'], $post['quantity'], $post['buyPrice'], $post['salePrice'], $id ]);
    }
}