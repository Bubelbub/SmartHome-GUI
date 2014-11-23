<?php

namespace Bubelbub\SmartHomeGUIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DesktopController
 * @package Bubelbub\SmartHomeGUIBundle\Controller
 * @author Bubelbub <bubelbub@gmail.com>
 * @Route("/desktop")
 */
class DesktopController extends Controller
{
	/**
	 * @Route("/index")
	 * @Template()
	 */
	public function indexAction()
	{
		$doctrine = $this->getDoctrine();
		$repository = $doctrine->getRepository('BubelbubSmartHomeGUIBundle:Central');
		$centrals = $repository->findAll();

		return array(
			'centrals' => $centrals
		);
	}
}
