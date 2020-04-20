# Rhapsody Bundle

This bundle allows the creation of simple and fast administration for Symfony 4 and 5.

## Installation

Install with composer

    composer req phpguild/rhapsody-bundle
    
Execute install script

    vendor/bin/rhapsody install
    
## Configuration

Edit `config/services.yaml`

    imports:
        - { resource: rhapsody.yaml }

Edit `config/packages/security.yaml`

    security:
        firewalls:
            admin:
                pattern: ^/admin
                anonymous: lazy

## Implementation

- YAML routes `config/routes/admin`
- Actions `src/Action/Admin`
- Templates `templates/admin`

## Context

The context of firewall define the app name, `admin` is used by default.

## Components

* [Admin LTE Bundle (default theme)](https://github.com/phpguild/rhapsody-adminlte-bundle)
* [Security Bundle (admin user auth)](https://github.com/phpguild/rhapsody-security-bundle)
