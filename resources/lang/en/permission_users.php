<?php

return [
    'create' => [
        'success' => 'The permission has been successfully created.',
        'error' => 'An error occurred while creating the permission.',
    ],

    'update' => [
        'success' => 'The permission has been successfully updated.',
        'permission_locked' => 'Modification is not possible because the permission has already been processed.',
        'error' => 'An error occurred while updating the permission.',
    ],

    'trash' => [
        'success' => 'Permission(s) successfully archived.',
        'error' => 'An error occurred while archiving the permission(s).',
    ],

    'restore' => [
        'success' => 'Permission(s) successfully restored.',
        'error' => 'An error occurred while restoring the permission(s).',
    ],

    'destroy' => [
        'success' => 'Permission(s) permanently deleted successfully.',
        'error' => 'An error occurred while deleting the permission(s).',
    ],

    'not_found' => 'The requested permission was not found.',
];
