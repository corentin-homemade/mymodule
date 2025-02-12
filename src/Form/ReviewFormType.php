<?php

namespace PrestaShop\Module\MyModule\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class MyModuleConfigurationFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('rating_value', ChoiceType::class, [
                'label' => $this->trans('Rating value', 'Modules.Mymodule.Admin'),
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Rating value cannot be empty',
                    ]),
                ],
                'help' => $this->trans('Select a value between 1 and 5', 'Modules.Mymodule.Admin'),
            ])
            ->add('rating_value', TextType::class, [
                'label' => $this->trans('Review text', 'Modules.Mymodule.Admin'),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Title cannot be empty',
                    ]),
                ],
                'help' => $this->trans('Maximum 400 characters', 'Modules.Mymodule.Admin'),
            ]);

    }
}
