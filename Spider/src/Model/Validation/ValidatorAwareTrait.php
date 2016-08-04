<?php
namespace Spider\Model\Validation;

use Cake\Validation\Validator;

trait ValidatorAwareTrait
{

    /**
     * Overwrite Cake\Validation\ValidatorAwareTrait
     *
     * Returns the default validator object. Subclasses can override this function
     * to add a default validation set to the validator object.
     *
     * @param \Cake\Validation\Validator $validator The validator that can be modified to
     * add some rules to it.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator->provider('default', new Validation());
        return $validator;
    }
}
