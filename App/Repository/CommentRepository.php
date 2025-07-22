<?php

namespace App\Repository;

class CommentRepository extends Repository
{
    // Fonction pour chercher tous les commentaires signalés
    public function searchAllComments(): array
    {
        $sql = ("SELECT C.id AS covoiturage_id, C.date_heure_depart, C.date_heure_arrivee, C.adresse_depart, C.adresse_arrivee,
                Passager.id AS passager_id, Passager.pseudo AS passager_pseudo, Passager.mail AS passager_mail, 
                Driver.id AS driver_id, Driver.pseudo AS driver_pseudo, Driver.mail AS driver_mail,
                Comment.commentaire, Comment.id as commentaire_id
                FROM Commentaire AS Comment
                INNER JOIN User_Covoiturages AS UC ON Comment.user_covoiturage_id = UC.id
                INNER JOIN Covoiturage AS C ON UC.covoiturage_id = C.id
                INNER JOIN Voiture AS V ON C.voiture_id = V.id
                INNER JOIN User AS Driver ON V.user_id = Driver.id
                INNER JOIN User AS Passager ON UC.user_id = Passager.id;");
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }
}
