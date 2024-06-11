<?php

namespace SabatinoMasala\Replicate;

class ModelVersionIdentifier {
    public $owner;
    public $name;
    public $version;

    public function __construct($owner, $name, $version = null) {
        $this->owner = $owner;
        $this->name = $name;
        $this->version = $version;
    }

    public static function parse($ref) {
        $pattern = '/^(?P<owner>[^\/]+)\/(?P<name>[^\/:]+)(:(?P<version>.+))?$/';
        if (!preg_match($pattern, $ref, $matches)) {
            throw new Exception('Invalid reference to model version. Expected format: owner/name or owner/name:version. ' . $ref);
        }

        $owner = $matches['owner'];
        $name = $matches['name'];
        $version = $matches['version'] ?? null;

        return new self($owner, $name, $version);
    }
}
