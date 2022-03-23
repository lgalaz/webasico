<?php

namespace Tests;

trait ExtendsTraitSetup
{
    public function setUpTraits()
    {
        parent::setUpTraits();
        $this->extendSetup();
    }

    public function extendSetup()
    {
        $uses = array_flip(class_uses_recursive(static::class));

        if (isset($uses[ResetsDatabase::class])) {
            $this->resetDatabaseFile();
        }
    }
}
