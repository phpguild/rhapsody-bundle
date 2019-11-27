# Rhapsody Bundle

This bundle allows the creation of simple and fast administration for Symfony 4 and 5.

## Installation

Into `config/packages/security.yaml`

    security:
        encoders:
            App\Entity\AdminUser:
                algorithm: bcrypt
