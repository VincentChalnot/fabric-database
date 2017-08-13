<?php

namespace FabricDatabase\EAVModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Simple Color picker with predefined choices
 */
class ColorPickerType extends AbstractType
{
    /** @var array */
    protected $choices;

    /**
     * @param array $choices
     */
    public function __construct(array $choices)
    {
        $this->choices = $choices;
    }

    /**
     * @inheritDoc
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['custom_classes'] = $options['custom_classes'];
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'multiple' => true,
            'expanded' => true,
            'choices' => $this->choices,
            'custom_classes' => 'col-lg-2 col-md-3 col-sm-4 col-xs-6',
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
