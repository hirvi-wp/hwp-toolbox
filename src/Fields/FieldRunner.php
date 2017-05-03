<?php

namespace HWP\Toolbox\Fields;

class FieldRunner
{

    /**
     * @var array
     */
    private $fieldClasses;

    /**
     * FieldRunner constructor.
     *
     * @param array $fieldClasses
     */
    public function __construct(array $fieldClasses)
    {
        $this->fieldClasses = $fieldClasses;
    }

    /**
     * @return void
     */
    public function run()
    {
        foreach ($this->fieldClasses as $fieldClass) {
            if (class_exists($fieldClass)) {
                $instance = new $fieldClass();
                $instance->fields();
            }
        }
    }
}