<?php

namespace PrestaShop\Module\MyModule\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use PrestaShopBundle\Form\Admin\Type\Material\MaterialMultipleChoiceTableType;
use Symfony\Component\Form\FormBuilderInterface;


class MyModuleConfigurationFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('config_text', TextType::class, [
                'label' => $this->trans('Configuration text', 'Modules.Mymodule.Admin'),
                'help' => $this->trans('Maximum 32 characters', 'Modules.Mymodule.Admin'),
            ])

            ->add('show_in_menu', CheckboxType::class, [
                'label' => $this->trans('Show in Back Office menu', 'Modules.Mymodule.Admin'),
                'required' => false,
                'help' => $this->trans('Enable this option to add the module to the Back Office menu.', 'Modules.Mymodule.Admin'),
            ])

            ->add('language', ChoiceType::class, [
                'label' => $this->trans('Select Language', 'Modules.Mymodule.Admin'),
                'choices' => [
                    $this->trans('French', 'Modules.Mymodule.Admin') => 'fr',
                    $this->trans('English' , 'Modules.Mymodule.Admin') => 'en',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add(
                'material_choice_multiple_choices_table',
                MaterialMultipleChoiceTableType::class,
                [
                    'label' => $this->trans('Material choice multiple choices table type', 'Modules.DemoSymfonyForm.Admin'),
                    'choices' => [
                        $this->trans('Vertical choice 1', 'Modules.DemoSymfonyForm.Admin') => '1',
                        $this->trans('Vertical choice 2', 'Modules.DemoSymfonyForm.Admin') => '2',
                        $this->trans('Vertical choice 3', 'Modules.DemoSymfonyForm.Admin') => '3',
                    ],
                    'multiple_choices' => [
                        [
                            'name' => 'choice_1',
                            'label' => $this->trans('Horizontal choice 1', 'Modules.DemoSymfonyForm.Admin'),
                            'multiple' => true,
                            /* You need choices array for the second time to be able to choose which horizontal choices are available for this vertical choice  */
                            'choices' => [
                                $this->trans('Vertical choice 1', 'Modules.DemoSymfonyForm.Admin') => '1',
                                $this->trans('Vertical choice 2', 'Modules.DemoSymfonyForm.Admin') => '2',
                            ],
                        ],
                        [
                            'name' => 'choice_2',
                            'label' => $this->trans('Horizontal choice 2', 'Modules.DemoSymfonyForm.Admin'),
                            'multiple' => true,
                            'choices' => [
                                $this->trans('Vertical choice 1', 'Modules.DemoSymfonyForm.Admin') => '1',
                                $this->trans('Vertical choice 2', 'Modules.DemoSymfonyForm.Admin') => '2',
                                $this->trans('Vertical choice 3', 'Modules.DemoSymfonyForm.Admin') => '3',
                            ],
                        ],
                    ],
                ]
            );
    }
}
