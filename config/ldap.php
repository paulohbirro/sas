<?php

return [
    'plugins' => [
        'adldap' => [
            'account_suffix'=>  '@mg.sebrae.corp',
            'domain_controllers'=>  [
                'mg.sebrae.corp'
            ], // Load balancing domain controllers
            'base_dn'   =>  'OU=SEBRAE-MG,DC=mg,DC=sebrae,DC=corp',
            'admin_username' => env('LDAP_USERNAME'), // This is required for session persistance in the application
            'admin_password' => env('LDAP_PASSWORD'),
        ]
    ]
];