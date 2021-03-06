<?php

namespace angularjsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use angularjsBundle\Entity\ProductImage;
use angularjsBundle\Form\ProductImageType;

/**
 * ProductImage controller.
 *
 */
class ProductImageController extends Controller
{

    /**
     * Lists all ProductImage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('angularjsBundle:ProductImage')->findAll();

        return $this->render('angularjsBundle:ProductImage:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ProductImage entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ProductImage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->upload();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('image_show', array('id' => $entity->getId())));
        }

        return $this->render('angularjsBundle:ProductImage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ProductImage entity.
     *
     * @param ProductImage $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ProductImage $entity)
    {
        $form = $this->createForm(new ProductImageType(), $entity, array(
            'action' => $this->generateUrl('image_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ProductImage entity.
     *
     */
    public function newAction()
    {
        $entity = new ProductImage();
        $form   = $this->createCreateForm($entity);

        return $this->render('angularjsBundle:ProductImage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ProductImage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('angularjsBundle:ProductImage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductImage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('angularjsBundle:ProductImage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ProductImage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('angularjsBundle:ProductImage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductImage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('angularjsBundle:ProductImage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ProductImage entity.
    *
    * @param ProductImage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProductImage $entity)
    {
        $form = $this->createForm(new ProductImageType(), $entity, array(
            'action' => $this->generateUrl('image_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Deletes a ProductImage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('angularjsBundle:ProductImage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProductImage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('image'));
    }

    /**
     * Creates a form to delete a ProductImage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('image_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
