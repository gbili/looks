<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Dogtore\View\Helper;

/**
 * View helper for translating messages.
 */
class UserHasNDogsAndTheirNamesAre extends \Zend\View\Helper\AbstractHelper
{
    protected $optionsParam;

    /**
     * Translate a message
     * @return string
     */
    public function __invoke(\GbiliUserModule\Entity\ProfileInterface $profile, array $dogs, $options = array())
    {
        $this->optionsParam = $options;

        $referAsYou = (boolean) ((isset($options['refer_as_you']))? $options['refer_as_you'] : false);
        $view       = $this->view;
        $dogsCount  = count($dogs);

        $patterns = array(
            '/:has_or_You_have/',
            '/:count/', 
            '/:dog_or_dogs/',
        );
        $replacements = array(
            ((!$referAsYou)? 'has' : 'You have'),
            $view->numberInLetters($dogsCount),
            ((1 === $dogsCount)? 'dog' : 'dogs'),
        );

        // goal: you have three dogs, Richard has one dog
        $hasNDogsPhrase = $view->translate(preg_replace($patterns, $replacements, ":has_or_You_have :count :dog_or_dogs"));

        if (!$referAsYou) {
            $patterns = array(
                ':firstname', 
                ':phrase'
            );
            $replacements = array(
                $profile->getFirstname(), 
                $hasNDogsPhrase,
            );
            $hasNDogsPhrase = $view->patternTranslate($patterns, $replacements, ':firstname :phrase');
        }

        if (0 < $dogsCount) {
            return $hasNDogsPhrase . $this->getDogNamesPhrase($dogs);
        }

        return $hasNDogsPhrase;
    }

    protected function getDogNamesPhrase($dogs)
    {
        $view         = $this->view;
        $options      = $this->optionsParam;
        $boldDogNames = (boolean) (isset($options['bold_dog_names']))
            ? $options['bold_dog_names'] 
            : true;
        $dogNamesAsProfileLinks = (boolean) (isset($options['dog_names_as_profile_links']))
            ? $options['dog_names_as_profile_links'] 
            : true;
        $dogsCount    = count($dogs);
        $dogNames     = array_map(function ($dog) use ($boldDogNames, $dogNamesAsProfileLinks, $view) {
            $formattedDogName = ($boldDogNames)
                ? '<strong class="dog-names-enum">' . $dog->getName() . '</strong>' 
                : $dog->getName();
            if ($dogNamesAsProfileLinks) {
                $dogProfileLink = $view->url('dog_view_user_dog', array(
                            'uniquename' => $dog->getUser()->getUniquename(),
                            'dogname_underscored' => $view->string()->spaceToUnderscore($dog->getName()),
                        ), true);
                $dogNameAsLink = '<a href="' . $dogProfileLink. '" title="'.$view->translate('View Dog Profile').'">' . $formattedDogName . '</a>';
                $formattedDogName = $dogNameAsLink;
            }
            return $formattedDogName;
        }, $dogs);

        $lastDog = array_pop($dogNames);
        
        $dogNamesString = implode(', ', $dogNames);
        $dogNamesString = ((1 === $dogsCount)? $lastDog :  $dogNamesString .' ' .  $view->translate('and') . ' ' . $lastDog);


        if (1 === $dogsCount) {
            $replacements = array(
                (('f' === current($dogs)->getGender())? 'Her': 'His'),
                'name',
                'is',
            );
        } else {
            $replacements = array(
                'Their', 
                'names', 
                'are',
            ); 
        }

        $patterns = array(
            '/:His_or_Their/',
            '/:name_or_names/',
            '/:is_or_are/',
        );
        $andTheirNamesArePhrase = $view->translate(preg_replace($patterns, $replacements, ". :His_or_Their :name_or_names :is_or_are: "));

        return  $andTheirNamesArePhrase . $dogNamesString;
    }
}
