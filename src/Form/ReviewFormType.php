<?php

namespace PrestaShop\Module\MyModule\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReviewFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('rating_value', ChoiceType::class, [
                'label' => $this->trans('Rating value', 'Modules.Mymodule.Admin'),
                'choices' => [
                    $this->trans('1','Modules.Mymodule.Admin') => 1,
                    $this->trans('2','Modules.Mymodule.Admin')  => 2,
                    $this->trans('3','Modules.Mymodule.Admin')  => 3,
                    $this->trans('4','Modules.Mymodule.Admin')  => 4,
                    $this->trans('5','Modules.Mymodule.Admin')  => 5,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Rating value cannot be empty',
                    ]),
                ],
                'help' => $this->trans('Select a value between 1 and 5', 'Modules.Mymodule.Admin'),
            ])
            ->add('review_text', TextType::class, [
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
