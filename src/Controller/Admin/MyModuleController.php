<?php

declare(strict_types=1);

namespace PrestaShop\Module\MyModule\Controller\Admin;


use mysql_xdevapi\Exception;
use PrestaShop\Module\MyModule\Entity\Review;
use PrestaShop\Module\MyModule\Grid\Definition\Factory\ProductGridDefinitionFactory;
use PrestaShop\Module\MyModule\Grid\Filters\ProductFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Service\Grid\ResponseBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PrestaShop\Module\MyModule\Form\ReviewFormType;




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



    public function editReview(int $review_id, Request $request)
    {
        $connection = $this->get('doctrine.dbal.default_connection');
        $qb = $connection->createQueryBuilder();

        $qb ->select('*')
            ->from('ps_product_reviews')
            ->where('review_id = :review_id')
            ->setParameter('review_id', $review_id);


        $result = $qb->execute()->fetchAssociative();

        $review = new Review();
        $review->setRatingValue($result['rating_value']);
        $review->setReviewText($result['review_text']);

        $form = $this->createForm(ReviewFormType::class, $review);
        $form->handleRequest($request);

        $title = $this->trans('Update Review','Modules.Mymodule');

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $connection->update('ps_product_reviews', [
                'rating_value' =>$data->getRatingValue(),
                'review_text' => $data->getReviewText(),
            ], ['review_id' => $review_id]);

            $this->addFlash('success', $this->trans('Review updated successfully.', 'Modules.Mymodule'));
            return $this->redirectToRoute('my_module_index');
        }

        return $this->render('@Modules/mymodule/views/templates/admin/form-review.html.twig', [
            'form' => $form->createView(),
            'title' => $title,

        ]);
    }

    /**
     * Delete review functionality.
     *
     * @param review_id
     *
     * @return RedirectResponse
     */
    public function deleteReview(int $review_id)    {

        try {
            $connection = $this->get('doctrine.dbal.default_connection');
            $qb = $connection->createQueryBuilder();
            $qb->delete('ps_product_reviews')
                ->where('review_id = :review_id')
                ->setParameter('review_id', $review_id)
                ->execute();

            $this->addFlash('success', $this->trans('Review deleted successfully.', 'Modules.Mymodule'));
        }catch (Exception $e){
            $this->addFlash('error', $this->getErrorMessageForException($e, $this->getErrorMessages($e)));

        }
        return $this->redirectToRoute('my_module_index');
    }



    public function createReview(int $id_order, int $id_product, int $id_customer, Request $request)
    {
        $review = new Review();


        $form = $this->createForm(ReviewFormType::class, $review);
        $form->handleRequest($request);

        $title =$this->trans('Create Review','Modules.Mymodule' );

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $currentDate = new \DateTime();
            $connection = $this->get('doctrine.dbal.default_connection');

            $connection->insert('ps_product_reviews', [
                'order_id' => $id_order,
                'product_id' => $id_product,
                'user_id' => $id_customer,
                'rating_value' => $data->getRatingValue(),
                'review_text' => $data->getReviewText(),
                'review_date' => $currentDate->format('Y-m-d H:i:s'),
            ]);

            $this->addFlash('success', $this->trans('Review created successfully.', 'Modules.Mymodule'));

            return $this->redirectToRoute('my_module_index');
        }

        return $this->render('@Modules/mymodule/views/templates/admin/form-review.html.twig', [
            'form' => $form->createView(),
            'title' => $title,
        ]);
    }


}
