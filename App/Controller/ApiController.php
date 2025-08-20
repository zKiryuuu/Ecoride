<?php

namespace App\Controller;

use App\Repository\CovoiturageRepository;
use DateTime;

class ApiController extends Controller
{
    // URL pour l'appeler : index.php?controller=api&action=getGraphData
    // Fonction pour envoyer les données au graphique via une API fetch
    public function getGraphData()
    {
        try {
            // repository
            $covoiturageRepository = new CovoiturageRepository();

            // Pour récupérer les dates, les nombres et les gains des covoiturages dans la plateforme par jour
            $platformCovoituragesAndGainPerDate = $covoiturageRepository->getPlatformCovoituragesAndGainPerDate();

            $totalGainArray = []; // Array vide pour enregistrer le nombre total de crédit gagné par la plateforme

            // On parcours le tableau pour trouver les gains journalières
            foreach ($platformCovoituragesAndGainPerDate as $data) {
                array_push($totalGainArray, $data['gain']);
            }
            // On fait la somme de tous les gains journalières, pour avoir le total
            $totalGainValue = array_sum($totalGainArray);


            header('Content-Type: application/json');
            // response JSON
            echo json_encode([$platformCovoituragesAndGainPerDate, $totalGainValue]); // On encode le tableau en JSON
            exit;
        } catch (\Exception $e) {
            // En cas d'erreur, on renvoie un message d'erreur
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    // URL pour l'appeler : index.php?controller=api&action=startCovoiturage
    // Fonction pour démarrer un covoiturage
    public function startCovoiturage()
    {
        // Si le boutton "Démarrer" est cliqué
        if (isset($_POST['startCovoiturage'])) {
            $covoiturageRepository = new CovoiturageRepository;
            // On récupere l'id du covoiturage envoié dans le fetch
            $covoiturageId = (int) $_POST['covoiturage_id'];

            // On appel la fonction pour mettre à jour le statut du covoiturage
            // 1 = Crée | 2 = Démarré | 3 = Arrivé | 4 = Validé | 5 = Annulé
            $covoiturageRepository->updateCovoiturageStatut($covoiturageId, 2);

            // Envoi de la réponse JSON pour la requête AJAX
            echo (json_encode(['success' => true, 'id' => $covoiturageId]));
            exit;
        }
    }

    // URL pour l'appeler : index.php?controller=api&action=stopCovoiturage
    // Fonction pour indiquer l'arrivée du covoiturage
    public function stopCovoiturage() 
    {
        // Si le boutton "Démarrer" est cliqué
        if (isset($_POST['arriveCovoiturage'])) {
            $covoiturageRepository = new CovoiturageRepository;
            $covoiturageController = new CovoiturageController;

            // On récupere l'id du covoiturage envoié dans le fetch
            $covoiturageId = (int) $_POST['covoiturage_id'];

            // On appel la fonction pour mettre à jour le statut du covoiturage
            // 1 = Crée | 2 = Démarré | 3 = Arrivé | 4 = Validé | 5 = Annulé
            $covoiturageRepository->updateCovoiturageStatut($covoiturageId, 3);

            // On appel la fonction pour envoyer un mail aux participants du covoiturage, afin de confirmer que le trajet s'est bien déroulé
            $covoiturageController->sendMailToValidateCovoiturage($covoiturageRepository, $covoiturageId);

            // Envoi de la réponse JSON pour la requête AJAX
            echo (json_encode(['success' => true, 'id' => $covoiturageId]));
            exit;
        }
    }



}
