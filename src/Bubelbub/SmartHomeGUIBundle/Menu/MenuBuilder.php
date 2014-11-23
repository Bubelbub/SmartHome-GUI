<?php
/**
 * Created with IntelliJ IDEA.
 * Project: SmartHome GUI
 * User: Bubelbub <bubelbub@gmail.com>
 * Date: 10.12.13
 * Time: 17:11
 */

namespace Bubelbub\SmartHomeGUIBundle\Menu;

use Bubelbub\SmartHomeGUIBundle\Entity\Central;
use Bubelbub\SmartHomePHP\Entity\Location;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MenuBuilder
 * @package Bubelbub\SmartHomeGUIBundle\Menu
 * @author Bubelbub <bubelbub@gmail.com>
 */
class MenuBuilder extends ContainerAware
{
	/**
	 * @var \Knp\Menu\FactoryInterface
	 */
	private $factory;

	/**
	 * @param FactoryInterface $factory
	 */
	public function __construct(FactoryInterface $factory, ContainerInterface $container)
	{
		$this->factory = $factory;
		$this->setContainer($container);
	}

	/**
	 * @return \Doctrine\Bundle\DoctrineBundle\Registry
	 */
	public function getDoctrine()
	{
		return $this->container->get('doctrine');
	}

	/**
	 * @return \Knp\Menu\ItemInterface
	 */
	public function createMainLeftMenu()
	{
		$menu = $this->factory->createItem('root');
		$menu->setChildrenAttribute('class', 'nav navbar-nav');

		$menu->addChild('Desktop', array('route' => 'bubelbub_smarthomegui_desktop_index'))
			->setAttribute('iconPrepend', 'globe')
			->setLinkAttribute('class', 'ajax');

		$roomSwitch = $menu->addChild('Raum wechseln')
			->setAttribute('iconPrepend', 'share-alt')
			->setAttribute('dropdown', true)
			->setAttribute('noCaret', true)
			->setAttribute('divider_prepend', true);

		/** @var Central[] $centrals */
		$centrals = $this->getDoctrine()->getRepository('BubelbubSmartHomeGUIBundle:Central')->findAll();

		$locations = array();
		foreach($centrals as $central)
		{
			$locations = array_merge($locations, $central->getSmartHome()->getLocations());
		}
		$locations = array_unique($locations);

		/** @var Location $location */
		foreach($locations as $location)
		{
			$roomSwitch->addChild($location->getName(), array('uri' => '#'))
//			           ->setAttribute('class', 'dropdown-header')
			;
		}

		return $menu;
	}

	/**
	 * @return \Knp\Menu\ItemInterface
	 */
	public function createMainRightMenu()
	{
		$menu = $this->factory->createItem('root');
		$menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

		$settings = $menu->addChild('Einstellungen')
			->setAttribute('dropdown', true);

		$settings->addChild('Zentrale', array('route' => 'bubelbub_smarthomegui_central_list'))
			->setLinkAttribute('class', 'ajax');
		$settings->addChild('Datenbank', array('uri' => '#'));
		$settings->addChild('Mailversand', array('uri' => '#'))
			->setAttribute('divider_append', true);
		$settings->addChild('Alle Geräte anzeigen', array('uri' => '#'));

		return $menu;
	}
}
