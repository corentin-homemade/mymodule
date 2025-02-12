<?php

declare(strict_types=1);

namespace PrestaShop\Module\MyModule\Controller\Admin;


use mysql_xdevapi\Exception;
use PrestaShop\Module\MyModule\Grid\Definition\Factory\ProductGridDefinitionFactory;
use PrestaShop\Module\MyModule\Grid\Filters\ProductFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Service\Grid\ResponseBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class MyModuleController extends FrameworkBundleAdminController
{


    /**
     * List quotes
     *
     * @param ProductFilters $filters
     *
     * @return Response
     */

    public function indexAction(ProductFilters $filters)
    {
        $quoteGridFactory = $this->get('mymodule.grid.factory.products');
        $quoteGrid = $quoteGridFactory->getGrid($filters);


        return $this->render(
            '@Modules/mymodule/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('The welcome to my module with the table of product orders', 'Modules.Mymodule'),
                'quoteGrid' => $this->presentGrid($quoteGrid),
            ]
        );
    }


    /**
     * Provides filters functionality.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */

    public function searchAction(Request $request)
    {
        /** @var ResponseBuilder $responseBuilder */
        $responseBuilder = $this->get('prestashop.bundle.grid.response_builder');

        return $responseBuilder->buildSearchResponse(
            $this->get('mymodule.grid.definition.factory.products'),
            $request,
            ProductGridDefinitionFactory::GRID_ID,
            'my_module_index'
        );
    }



    public function updateReviews(Request $request)
    {
        $formHandler = $this->get('prestashop.module.mymodule.form.handler');
        $form = $formHandler->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $formHandler->save($form->getData());


            if (empty($errors)) {
                $this->addFlash('success', $this->trans('Edit successful.', 'Modules.Mymodule.Admin'));
                return $this->redirectToRoute('my_module_index');
            }
            $this->flashErrors($errors);
        }

        return $this->render('@Modules/mymodule/views/templates/admin/form-reviews.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    public function deleteReviews(int $review_id)    {
       /* dump($review_id);
        die();*/

        try {
            $connection = $this->get('prestashop.core.connection');

            $qb = $connection->createQueryBuilder();
            $qb->delete('ps_product_reviews')
                ->where('review_id = :review_id')
                ->setParameter('review_id', $review_id)
                ->execute();

            $this->addFlash('success', $this->trans('Review deleted successfully.', 'Modules.Mymodule.Admin'));
        }catch (Exception $e){
            $this->addFlash('error', $this->getErrorMessageForException($e, $this->getErrorMessages($e)));

        }
        return $this->redirectToRoute('my_module_index');
    }

}
