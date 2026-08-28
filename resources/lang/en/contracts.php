<?php

return [
    'create' => [
        'success' => 'The contract has been successfully created.',
        'error' => "This user already has an active or pending contract.",
    ],


    'upload' => [
        'success' => 'The contract has been successfully uploaded.',
        'error' => 'An error occurred while uploading the contract.',
    ],

    'update' => [
        'success' => 'The contract has been successfully updated.',
        'error' => "This contract cannot be modified because it is terminated.",
        'user_change_error' => "The specified user already has an active or pending contract.",
        'user_unauthorize_change_status' => "The status has not been updated because you are not authorized to modify it.",
    ],

    'trash' => [
        'success' => 'Contract(s) archived successfully.',
        'error' => 'An error occurred while archiving the contract(s).',
    ],

    'restore' => [
        'success' => 'Contract(s) restored successfully.',
        'error' => 'An error occurred while restoring the contract(s).',
    ],

    'destroy' => [
        'success' => 'Contract(s) permanently deleted successfully.',
        'error' => 'An error occurred while deleting the contract(s).',
    ],

    'not_found' => 'The requested contract was not found.',
];
