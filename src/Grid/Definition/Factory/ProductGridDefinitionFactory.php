<?php
declare(strict_types=1);

namespace PrestaShop\Module\MyModule\Grid\Definition\Factory;


use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShopBundle\Form\Admin\Type\NumberMinMaxFilterType;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;

class ProductGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    const GRID_ID = 'product_command';

    /**
     * {@inheritdoc}
     */
    protected function getId()
    {
        return self::GRID_ID;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return $this->trans('Products of orders', [], 'Modules.Mymodule');
    }

    /**
     * {@inheritdoc}
     */



    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add(
                (new DataColumn('id_order'))
                    ->setName($this->trans('N°order', [], 'Modules.Mymodule'))
                    ->setOptions([
                        'field' => 'id_order',
                    ])
            )
            ->add(
                (new DataColumn('id_product'))
                    ->setName($this->trans('N°product', [], 'Modules.Mymodule'))
                    ->setOptions([
                        'field' => 'id_product',
                    ])
            )
            ->add(
                (new DataColumn('name'))
                    ->setName($this->trans('Name', [], 'Modules.Mymodule'))
                    ->setOptions([
                        'field' => 'name',
                    ])
            )
            ->add(
                (new DataColumn('price_tax_excluded'))
                    ->setName($this->trans('Price', [], 'Modules.Mymodule'))
                    ->setOptions([
                        'field' => 'price_tax_excluded',
                    ])
            )
            ->add(
                (new DataColumn('reference'))
                    ->setName($this->trans('Reference', [], 'Modules.Mymodule'))
                    ->setOptions([
                        'field' => 'reference',
                    ])
            )
            ->add(
                (new DataColumn('id_customer'))
                    ->setOptions([
                        'field' => 'id_customer',
                    ])
            )
            ->add(
                (new DataColumn('name_customer'))
                    ->setName($this->trans('Customer', [], 'Modules.Mymodule'))
                    ->setOptions([
                        'field' => 'name_customer',
                    ])
            )
            ->add(
                (new DataColumn('review_id'))
                    ->setOptions([
                        'field' => 'review_id',
                    ])
            )
            ->add(
                (new DataColumn('review_text'))
                    ->setName($this->trans('Review', [], 'Modules.Mymodule'))
                    ->setOptions([
                        'field' => 'review_text',
                    ])
            )
            ->add(
                (new DataColumn('rating_value'))
                    ->setName($this->trans('Rating', [], 'Modules.Mymodule'))
                    ->setOptions([
                        'field' => 'rating_value',
                    ])
            )
            ->add(
            (new DataColumn('active'))
                ->setName($this->trans('Active', [], 'Modules.Mymodule'))
                ->setOptions([
                    'field' => 'active',
                ])
            )
            ->add(
                (new ActionColumn('actions'))
                    ->setName($this->trans('Actions', [], 'Modules.Mymodule'))
                    ->setOptions([
                        'actions' => (new RowActionCollection())
                            ->add(
                                (new LinkRowAction('create'))
                                    ->setName($this->trans('Create', [], 'Modules.Mymodule.Admin'))
                                    ->setIcon('add')
                                    ->setOptions([
                                        'route' => 'mymodule_reviews_create',
                                        'route_param_name' => 'id_order',
                                        'route_param_field' => 'id_order',
                                        'extra_route_params' => [
                                            'id_product' => 'id_product',
                                            'id_customer' => 'id_customer',
                                        ],
                                        'accessibility_checker' => function ($row) {
                                            if (isset($row['review_id']) && !empty($row['review_id'])) {
                                                return false;
                                            }
                                            return true;
                                        },
                                    ])
                            )
                            ->add(
                                (new LinkRowAction('edit'))
                                    ->setName($this->trans('Edit', [], 'Modules.Mymodule.Admin'))
                                    ->setIcon('edit')
                                    ->setOptions([
                                        'route' => 'mymodule_reviews_update',
                                        'route_param_name' => 'review_id',
                                        'route_param_field' => 'review_id',
                                        'accessibility_checker' => function ($row) {
                                            if (!isset($row['review_id']) || empty($row['review_id'])) {
                                                return false;
                                            }
                                            return true;
                                        },
                                    ])

                            )
                            ->add(
                                (new SubmitRowAction('delete'))
                                    ->setName($this->trans('Delete', [], 'Modules.Mymodule.Admin'))
                                    ->setIcon('delete')
                                    ->setOptions([
                                        'route' => 'mymodule_reviews_delete',
                                        'route_param_name' => 'review_id',
                                        'route_param_field' => 'review_id',
                                        'accessibility_checker' => function ($row) {
                                            if (!isset($row['review_id']) || empty($row['review_id'])) {
                                                return false;
                                            }
                                            return true;
                                        },
                                        'confirm_message' => $this->trans('Are you sure you want to delete this review?', [], 'Modules.Mymodule'),
                                    ])
                            ),
                    ])
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function getFilters()
    {
        return (new FilterCollection())
            ->add(
                (new Filter('id_order', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('N°order', [], 'Modules.Mymodule'),
                        ],
                    ])
                    ->setAssociatedColumn('id_order')
            )
            ->add(
                (new Filter('id_product', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('N°product', [], 'Modules.Mymodule'),
                        ],
                    ])
                    ->setAssociatedColumn('id_product')
            )
            ->add(
                (new Filter('name', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Name', [], 'Modules.Mymodule'),
                        ],
                    ])
                    ->setAssociatedColumn('name')
            )
            ->add(
                (new Filter('price_tax_excluded', NumberMinMaxFilterType::class, [
                    'min_field_options' => [
                        'attr' => [
                            'placeholder' => $this->trans('Min', [], 'Modules.Mymodule'),
                        ],
                    ],
                    'max_field_options' => [
                        'attr' => [
                            'placeholder' => $this->trans('Max', [], 'Modules.Mymodule'),
                        ],
                    ],
                ]))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Price', [], 'Modules.Mymodule'),
                        ],
                    ])
                    ->setAssociatedColumn('price_tax_excluded')
            )
            ->add(
                (new Filter('reference', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Reference', [], 'Modules.Mymodule'),
                        ],
                    ])
                    ->setAssociatedColumn('reference')
            )
            ->add(
                (new Filter('name_customer', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Customer', [], 'Modules.Mymodule'),
                        ],
                    ])
                    ->setAssociatedColumn('name_customer')
            )
            ->add(
                (new Filter('rating_value', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Rating', [], 'Modules.Mymodule'),
                        ],
                    ])
                    ->setAssociatedColumn('rating_value')
            )
            ->add(
                (new Filter('active', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Active', [], 'Modules.Mymodule'),
                        ],
                    ])
                    ->setAssociatedColumn('active')
            )
            ->add(
                (new Filter('actions', SearchAndResetType::class))
                    ->setTypeOptions([
                        'reset_route' => 'admin_common_reset_search_by_filter_id',
                        'reset_route_params' => [
                            'filterId' => self::GRID_ID,
                        ],
                        'redirect_route' => 'my_module_index',
                    ])
                    ->setAssociatedColumn('actions')
            )
        ;
    }
}
