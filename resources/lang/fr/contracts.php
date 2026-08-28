<?php

return [
    'create' => [
        'success' => 'Le contrat a été créé avec succès.',
        'error' => "Cet utilisateur a déjà un contrat actif ou en attente.",
    ],

    'upload' => [
        'success' => 'Le contrat a été téléchargé avec succès.',
        'error' => 'Une erreur est survenue lors du téléchargement du contrat.',
    ],

    'update' => [
        'success' => 'Le contrat a été mis à jour avec succès.',
        'error' => "Ce contrat ne peut pas être modifié car il est terminé.",
        'user_change_error' => "L'utilisateur défini a déjà un contrat actif ou en attente.",
        'user_unauthorize_change_status' => "Le statut n'a pas été mis à jour, car vous n'est pas autorisé à le modifier.",
    ],

    'trash' => [
        'success' => 'Contrat(s) archivé(s) avec succès.',
        'error' => 'Une erreur est survenue lors de l\'archivage du ou des contrat(s).',
    ],

    'restore' => [
        'success' => 'Contrat(s) restauré(s) avec succès.',
        'error' => 'Une erreur est survenue lors de la restauration du ou des contrat(s).',
    ],

    'destroy' => [
        'success' => 'Contrat(s) supprimé(s) définitivement avec succès.',
        'error' => 'Une erreur est survenue lors de la suppression du ou des contrat(s).',
    ],


    'not_found' => 'Le contrat demandé n\'a pas été trouvé.',
];
