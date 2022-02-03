<?php
require_once "models/front/API.manager.php";
require_once "models/Model.php";

class APIController {
   private $apiManager;

   public function __construct(){
       $this->apiManager = new APIManager();
   }

    public function getAnimaux($idFamille,$idContinent){
        $animaux = $this->apiManager->getDBAnimaux($idFamille,$idContinent);
        $tabResultat = $this->formatDataLignesAnimaux($animaux);
        // echo "<pre>";
        // print_r($tabResultat);
        // echo "</pre>";
        Model::sendJSON($tabResultat);
    }

    public function getAnimal($idAnimal){
        $lignesAnimal = $this->apiManager->getDBAnimal($idAnimal);
        $tabResultat = $this->formatDataLignesAnimaux($lignesAnimal);
        // echo "<pre>";
        // print_r($tabResultat);
        // echo "</pre>";
        Model::sendJSON($tabResultat);
       
    }
    
    private function formatDataLignesAnimaux($lignes){

        $tab = [];
        foreach($lignes as $ligne){
            if(!array_key_exists($ligne['animal_id'],$tab)){
                $tab[$ligne['animal_id']] = [
                    "id" => $ligne['animal_id'],
                    "nom" => $ligne['animal_nom'],
                    "description" => $ligne['animal_description'],
                    "image" => URL."public/images/".$ligne['animal_image'],
                    "famille" => [
                        "idFamille" => $ligne['famille_id'],
                        "libelleFamille" => $ligne['famille_libelle'],
                        "descriptionFamille" => $ligne['famille_description']
                    ]
                ];
            }

            $tab[$ligne['animal_id']]['continents'][] = [
                "idContinent" => $ligne['continent_id'],
                "libelleContinent" => $ligne['continent_libelle']
            ];
        }
        
        return $tab;

       
    }

    public function getFamilles(){
        $familles = $this->apiManager->getDBFamilles();
        Model::sendJSON($familles);
    }

    public function getContinents(){
        $continents = $this->apiManager->getDBContinents();
        Model::sendJSON($continents);
    }

    public function sendMessage(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Accept, Content-type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
        header("Content-Type: application/json");

        $obj = json_decode(file_get_contents('php://input'));
   
        // $to = "henrituaks@yahoo.com";
        // $subject = "Message du site myzoo de : ".$obj->nom;
        // $message = $obj->contenu;
        // $headers = "From : ".$obj->email;
        // mail($to, $subject, $message, $headers);

        $messageRetour = [
            'from' => $obj->email,
            'to' => "henrituaks@yahoo.com"
        ];

        echo json_encode($messageRetour);
    }
}