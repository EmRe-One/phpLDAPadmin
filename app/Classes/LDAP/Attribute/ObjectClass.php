<?php

namespace App\Classes\LDAP\Attribute;

use App\Classes\LDAP\Attribute;

/**
 * Represents an ObjectClass Attribute
 */
final class ObjectClass extends Attribute {
    public function __toString(): string {
        return $this->values->sort()->join('<br>');
    }
}