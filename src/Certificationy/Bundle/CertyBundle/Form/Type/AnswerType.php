<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\CertyBundle\Form\Type;

use Certificationy\Component\Certy\Calculator\Calculator;
use Certificationy\Component\Certy\Model\Answer;
use Certificationy\Component\Certy\Model\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnswerType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'multiple' => true,
            'expanded' => true,
            'property_path' => 'results',
            'choices' => $this->getChoices()
        ]);

        $resolver->setRequired([
            'question'
        ]);

        $resolver->setAllowedTypes([
            'question' => ['Certificationy\Component\Certy\Model\Question']
        ]);
    }

    /**
     * @return \Closure
     */
    public function getChoices()
    {
        return function (Options $options) {
            /** @var Question $question */
            $question = $options->get('question');

            $choices = [];
            $answers = $question->getAnswers()->toArray();
            shuffle($answers);

            /** @var Answer $answer */
            foreach ($answers as $answer) {
                $choices[Calculator::getHash($question->getCategory(), $question, $answer)] = $answer->getLabel();
            }

            return $choices;
        };
    }

    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['label'] = $options['question']->getLabel();
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'certification_answer';
    }
}
