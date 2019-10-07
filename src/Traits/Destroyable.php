<?php

namespace MikeTiEm\Valkyrie\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use MikeTiEm\Valkyrie\Exceptions\HasRelationshipException;

trait Destroyable
{
    /**
     * Indicates if the record can be deleted.
     *
     * @throws HasRelationshipException
     */
    public function verifyIfCanDelete()
    {
        if ($this->hasBeingUsed()) {
            throw new HasRelationshipException();
        }
        return $this;
    }

    /**
     * Check if the record was used in a later transaction.
     *
     * @return bool
     */
    public function hasBeingUsed()
    {
        foreach ($this->relations as $relation) {
            if ($this->{$relation}() instanceof MorphOne) {
                if ($this->{$relation})
                    return true;
                else {
                    if ($this->{$relation}->isNotEmpty())
                        return true;
                }
            }
        }
        return false;
    }
}