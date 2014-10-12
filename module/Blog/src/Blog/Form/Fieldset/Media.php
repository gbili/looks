<?php
namespace Blog\Form\Fieldset;

class Media extends \Zend\Form\Fieldset 
    implements \Zend\InputFilter\InputFilterProviderInterface
{
    public function __construct(\Doctrine\Common\Persistence\ObjectManager $objectManager)
    {
        parent::__construct('media');

        $this->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($objectManager))
             ->setObject(new \GbiliMediaEntityModule\Entity\Media());
        
        $this->add(array(
            'name' => 'id',
            'type'  => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'slug',
            'type'  => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Slug'
            ),
            'attributes' => array(
                'placeholder' => 'Enter Slug',
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'csspercent',
            'type'  => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Css Percent'
            ),
            'attributes' => array(
                'placeholder' => 'Leave empty for defaults',
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'width',
            'type'  => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Width (px)'
            ),
            'attributes' => array(
                'placeholder' => 'Leave empty for defaults',
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'height',
            'type'  => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Height (px)'
            ),
            'attributes' => array(
                'placeholder' => 'Leave empty for defaults',
                'class' => 'form-control',
            )
        ));
    }

    /** 
     * This relies on the fact that the file id is passed
     * in the form action as a uri parameter
     * Then that parameter has to be merged in the post data
     * as the post id in the 'file'
     * 
     * Note if the hidden element value could be preset, it
     * would be much simpler.
     */
    public function turnFileSelectorIntoHidden()
    {
        $this->remove('file');
        $this->add(array(
            'name' => 'file',
            'type'  => 'Zend\Form\Element\Hidden',
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

            'slug' => array(
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

            'file' => array(
                'required' => true,
            ),

            'width' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ),

            'height' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ),

            'csspercent' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ),
        );
    }
}
