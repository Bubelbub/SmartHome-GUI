<?php
/**
 * Created with IntelliJ IDEA.
 * Project: SmartHome GUI
 * User: Bubelbub <bubelbub@gmail.com>
 * Date: 08.12.13
 * Time: 17:30
 */

namespace Bubelbub\SmartHomeGUIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
 * @package Bubelbub\SmartHomeGUIBundle\Controller
 * @author Bubelbub <bubelbub@gmail.com>
 * @Route("/")
 */
class DefaultController extends Controller
{
	/**
	 * Redirect to desktop
	 *
	 * @Route("/")
	 */
	public function indexAction()
	{
		return $this->redirect($this->generateUrl('bubelbub_smarthomegui_desktop_index'));
	}
}
