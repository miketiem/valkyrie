<?php

namespace MikeTiEm\Valkyrie\Traits;

trait HasManyRelation
{
    public function storeHasMany($relations)
    {
        $this->save();

        foreach ($relations as $key => $items) {
            $newItems = [];

            foreach ($items as $item) {
                $this->{$key}()->delete();
                $model = $this->{$key}()->getModel();
                $newItems[] = $model->fill($item);
            }

            $this->{$key}()->saveMany($newItems);
        }
    }

    public function deleteHasMany($relations)
    {
        foreach ($relations as $relation) {
            $this->{$relation}()->delete();
        }
        return $this->delete();
    }
}