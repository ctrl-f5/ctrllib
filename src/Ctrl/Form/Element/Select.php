<?php

namespace Ctrl\Form\Element;

use Ctrl\Form\Element\Element;
use Traversable;
use Zend\InputFilter\InputProviderInterface;
use Zend\Validator\InArray as InArrayValidator;
use Zend\Validator\ValidatorInterface;

class Select extends Element
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = array(
        'type' => 'select',
    );

    /**
    * @var ValidatorInterface
    */
    protected $validator;

    /**
    * Get validator
    *
    * @return ValidatorInterface
    */
    protected function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = new InArrayValidator(array(
                'haystack' => (array) $this->getAttribute('options'),
                'strict'   => false
            ));
        }
        return $this->validator;
    }

    /**
     * Provide default input rules for this element
     *
     * Attaches the captcha as a validator.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        $spec = array(
            'name' => $this->getName(),
            'required' => true,
            'validators' => array(
                $this->getValidator()
            )
        );

        return $spec;
    }
}
