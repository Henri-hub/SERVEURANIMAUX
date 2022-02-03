<?php
require_once "./models/Model.php";

class AnimauxManager extends Model
{
    public function getAnimaux()
    {
        $req = "SELECT * from animal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $animaux;
    }

    public function deleteDBAnimalContinent($idAnimal)
    {
        $req = "Delete from animal_continent where animal_id= :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function deleteDBAnimal($idAnimal)
    {
        $req = "Delete from animal where animal_id= :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    // public function compterAnimaux($idFamille)
    // {
    //     $req = "Select count(*) as 'nb'
    //     from famille f inner join animal a on a.famille_id = f.famille_id
    //     where f.famille_id = :idFamille";
    //     $stmt = $this->getBdd()->prepare($req);
    //     $stmt->bindValue(":idFamille", $idFamille, PDO::PARAM_INT);
    //     $stmt->execute();
    //     $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    //     $stmt->closeCursor();
    //     return $resultat['nb'];
    // }

    public function updateAnimal($idAnimal, $nom, $description, $image, $famille)
    {
        $req = "Update animal 
        set animal_nom=:nom, animal_description=:description, animal_image=:image, famille_id=:famille
         where animal_id=:idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->bindValue(":famille", $famille, PDO::PARAM_INT);
        $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":image", $$image, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function createAnimal($nom, $description, $image, $famille)
    {
        $req = "Insert into animal (animal_nom,animal_description,animal_image,famille_id)
        values(:nom,:description,:image,:famille)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":image", $image, PDO::PARAM_STR);
        $stmt->bindValue(":famille", $famille, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        return $this->getBdd()->lastInsertId();
    }

    public function getAnimal($idAnimal)
    {
        $req = "SELECT a.animal_id, animal_nom, animal_image, animal_description, a.famille_id, continent_id from animal a 
            inner join famille f on a.famille_id=f.famille_id
            left join animal_continent ac on ac.animal_id=a.animal_id 
            WHERE a.animal_id = :idAnimal ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $lignesAnimal = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $lignesAnimal;
    }

    public function getImageAnimal($idAnimal)
    {

        $req = "SELECT animal_image from animal where animal_id = :idAnimal";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $image = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $image['animal_image'];
    }
}
