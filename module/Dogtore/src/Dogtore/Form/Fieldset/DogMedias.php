<?php
namespace Dogtore\Form\Fieldset;

class DogMedias extends \Zend\Form\Fieldset 
implements \Zend\InputFilter\InputFilterProviderInterface
{
    protected $langService;

    public function __construct($sm)
    {
        parent::__construct('dog');

        $objectManager = $sm->get('Doctrine\ORM\EntityManager');
        $authService   = $sm->get('Zend\Authentication\AuthenticationService');
        $this->langService = $sm->get('Lang');
        $user = $authService->getIdentity();

        $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($objectManager))
             ->setObject(new \Dogtore\Entity\Dog());
        
        $this->add(array(
            'name' => 'id',
            'type'  => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'medias',
            'type' => 'Blog\Form\Element\ObjectSelect',
            'options' => array(
                'translate' => array(
                    'label' => false,
                ),
                'label' => 'Picture',
                'property' => 'slug',
                'attributes' => array(
                    'data-img-src' => 'src',
                ),
                'form_group_class' => 'well gbili-add-media-button-container',
                'is_method' => true,
                'target_class' => 'GbiliMediaEntityModule\Entity\Media',
                'object_manager' => $objectManager,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('user' => $user),
                    ),
                ),
                'display_empty_item' => true,
                'empty_item_label' => '---',
            ),
            'attributes' => array(
                'class' => 'image-picker masonry',
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ),

            'weightkg' => array(
                'required' => true,
                'validators'  => array(
                    array('name' => 'Float'),
                    array(
                        'name' => 'Between',
                        'options' => array(
                            'min' => 0.1,
                            'max' => 200,
                        ),
                    ),
                ),
            ),

            'name' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            ),

            'birthdate' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array(
                        'name' => 'callback',
                        'options' => array(
                            'callback' => function ($value) {
                                //Convert a locale lang to an standard iso DateTime::ISO8601
                                return $this->langService->getStandardDate($value);
                            },
                        ),
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'Date',
                    ),
                ),
            ),

            'breed' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            ),

            'color' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'callback' => function ($value) {
                                return preg_replace('/#/', '', $value);
                            },
                        ),
                    ),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 6,
                            'max'      => 7,
                        ),
                    ),
                    array(
                        'name'    => 'Regex',
                        'options' => array(
                            'pattern' => '/[0-9ABCDEF]{6}/i'
                        ),
                    ),
                ),
            ),

            'gender' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 1,
                        ),
                    ),
                ),
            ),

            'whythisdog' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 700,
                        ),
                    ),
                ),
            ),

            'profilemedia' => array(
                'required' => false,
            ),
        );
    }
}
