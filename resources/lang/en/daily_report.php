<?php

return [
    'create' => [
        'success' => 'The daily report has been successfully created.',
        'error' => "This user already has an active or pending daily report.",
    ],


    'update' => [
        'success' => 'The daily report has been successfully updated.',
        'error' => "This daily report cannot be modified because it is terminated.",
        'user_change_error' => "The specified user already has an active or pending daily report.",
        'user_unauthorize' => "You cannot modify this daily report.",
    ],

    'trash' => [
        'success' => 'Contract(s) archived successfully.',
        'error' => 'An error occurred while archiving the daily report(s).',
    ],

    'restore' => [
        'success' => 'Contract(s) restored successfully.',
        'error' => 'An error occurred while restoring the daily report(s).',
    ],

    'destroy' => [
        'success' => 'Contract(s) permanently deleted successfully.',
        'error' => 'An error occurred while deleting the daily report(s).',
    ],

    'not_found' => 'The requested daily report was not found.',
];
