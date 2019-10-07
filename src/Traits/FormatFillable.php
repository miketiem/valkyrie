<?php

namespace MikeTiEm\Valkyrie\Traits;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait FormatFillable
{
    use ValidatesRequests;

    /**
     * Set the default values attributes for the model.
     *
     * @param  array  $values
     * @return $this
     */
    public function values(array $values)
    {
        $this->values = $values;

        return $this;
    }

    /**
     * Set default values for all fillable fields for the model.
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function scopeInitialize() {
        $this->validateParams();

        $array = [];

        foreach ($this->fillable as $field) {
            if (array_key_exists($field, $this->values))
                $array[$field] = $this->values[$field];
            else
                $array[$field] = isForeignKey($field) ? 0 : '';
        }
        return $array;
    }

    /**
     * Validates Valkyrie params for foreign key values.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateParams()
    {
        $validator = Validator::make([
            'tag' => config('valkyrie.tag'),
            'tag_type' => config('valkyrie.tagType')
        ], [
            'tag' => 'required',
            'tag_type' => 'required|in:prefix,suffix'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}