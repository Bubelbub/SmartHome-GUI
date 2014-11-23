<?php

namespace Bubelbub\SmartHomeGUIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bubelbub\SmartHomeGUIBundle\Entity\Central;
use Bubelbub\SmartHomeGUIBundle\Form\CentralType;

/**
 * Central controller.
 *
 * @Route("/central")
 */
class CentralController extends Controller
{

    /**
     * Lists all Central entities.
     *
     * @Route("/", name="central")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BubelbubSmartHomeGUIBundle:Central')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Central entity.
     *
     * @Route("/", name="central_create")
     * @Method("POST")
     * @Template("BubelbubSmartHomeGUIBundle:Central:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Central();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('central_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Central entity.
    *
    * @param Central $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Central $entity)
    {
        $form = $this->createForm(new CentralType(), $entity, array(
            'action' => $this->generateUrl('central_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Central entity.
     *
     * @Route("/new", name="central_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Central();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Central entity.
     *
     * @Route("/{id}", name="central_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BubelbubSmartHomeGUIBundle:Central')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Central entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Central entity.
     *
     * @Route("/{id}/edit", name="central_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BubelbubSmartHomeGUIBundle:Central')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Central entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Central entity.
    *
    * @param Central $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Central $entity)
    {
        $form = $this->createForm(new CentralType(), $entity, array(
            'action' => $this->generateUrl('central_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Central entity.
     *
     * @Route("/{id}", name="central_update")
     * @Method("PUT")
     * @Template("BubelbubSmartHomeGUIBundle:Central:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BubelbubSmartHomeGUIBundle:Central')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Central entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('central_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Central entity.
     *
     * @Route("/{id}", name="central_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BubelbubSmartHomeGUIBundle:Central')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Central entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('central'));
    }

    /**
     * Creates a form to delete a Central entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('central_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
