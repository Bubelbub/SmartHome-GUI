<?php
/**
 * Created with IntelliJ IDEA.
 * Project: SmartHome GUI
 * User: Bubelbub <bubelbub@gmail.com>
 * Date: 08.12.13
 * Time: 18:14
 */

namespace Bubelbub\SmartHomeGUIBundle\Controller;

use Bubelbub\SmartHomeGUIBundle\Entity\Central;
use Bubelbub\SmartHomeGUIBundle\Form\CentralType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CentralController
 * @package Bubelbub\SmartHomeGUIBundle\Controller
 * @author Bubelbub <bubelbub@gmail.com>
 * @Route("/central")
 */
class CentralController extends Controller
{
	/**
	 * List all centrals
	 * @Route("/list")
	 * @Template()
	 */
	public function listAction()
	{
		$centrals = $this->getRepository()->findAll();

		return array(
			'centrals' => $centrals
		);
	}

	/**
	 * @param int $id the id of entity or 0 to create one
	 * @Route("/form/{id}", requirements={"id" = "\d+|"}, defaults={"id" = 0})
	 * @Template()
	 */
	public function formAction(Request $request, $id = 0)
	{
		$entity = null;

		if($id > 0)
		{
			$entity = $this->getRepository()->find($id);
		}

		if($entity === null)
		{
			$entity = new Central();
		}

		$form = $this->getForm($entity);

		$form->handleRequest($request);

		if ($form->isValid()) {
			$shc = $entity->getSmartHome();
			$shc->login();

			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('bubelbub_smarthomegui_central_list'));
		}

		return array(
			'form'   => $form->createView()
		);
	}

	/**
	 * @param int $id optional id
	 * @return \Symfony\Component\Form\Form
	 */
	public function getForm($entity = null)
	{
		return $this->createForm(new CentralType(), $entity, array(
			'action' => $this->generateUrl('bubelbub_smarthomegui_central_form', $entity !== null ? array('id' => $entity->getId()) : array()),
			'method' => 'POST',
		));
	}

	/**
	 * @return \Doctrine\Common\Persistence\ObjectRepository
	 */
	public function getRepository()
	{
		return $this->getDoctrine()->getManager()->getRepository('BubelbubSmartHomeGUIBundle:Central');
	}
}
