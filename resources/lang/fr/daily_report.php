<?php

return [
    'create' => [
        'success' => 'Le rapport journalier a été créé avec succès.',
        'error' => "Cet utilisateur a déjà un rapport journalier actif ou en attente.",
    ],


    'update' => [
        'success' => 'Le rapport journalier a été mis à jour avec succès.',
        'error' => "Ce rapport journalier ne peut pas être modifié car il est terminé.",
        'user_change_error' => "L'utilisateur spécifié a déjà un rapport journalier actif ou en attente.",
        'user_unauthorize' => "vous ne pouvez pas modifier ce rapport journalier.",
    ],

    'trash' => [
        'success' => 'Rapport(s) journalier(s) archivé(s) avec succès.',
        'error' => 'Une erreur s\'est produite lors de l\'archivage du(des) rapport(s) journalier(s).',
    ],

    'restore' => [
        'success' => 'Rapport(s) journalier(s) restauré(s) avec succès.',
        'error' => 'Une erreur s\'est produite lors de la restauration du(des) rapport(s) journalier(s).',
    ],

    'destroy' => [
        'success' => 'Rapport(s) journalier(s) supprimé(s) définitivement avec succès.',
        'error' => 'Une erreur s\'est produite lors de la suppression du(des) rapport(s) journalier(s).',
    ],

    'not_found' => 'Le rapport journalier demandé n\'a pas été trouvé.',
];
