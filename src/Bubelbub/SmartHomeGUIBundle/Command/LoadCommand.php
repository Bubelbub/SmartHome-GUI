<?php
/**
 * Created with IntelliJ IDEA.
 * Project: SmartHome GUI
 * User: Bubelbub <bubelbub@gmail.com>
 * Date: 20.12.13
 * Time: 23:31
 */

namespace Bubelbub\SmartHomeGUIBundle\Command;

use Bubelbub\SmartHomeGUIBundle\Entity\Central;
use Bubelbub\SmartHomeGUIBundle\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LoadCommand
 * @package Bubelbub\SmartHomeGUIBundle\Command
 * @author Bubelbub <bubelbub@gmail.com>
 */
class LoadCommand extends ContainerAwareCommand
{
	/**
	 * Configure this load command
	 */
	protected function configure()
	{
		$this
			->setName('smarthome:load')
			->setDescription('Loads all entities from centrals and put them into database')
		;
	}

	/**
	 * Loads the entities from central
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$em = $this->getDoctrine()->getManager();
		$centralRepository = $this->getDoctrine()->getRepository('BubelbubSmartHomeGUIBundle:Central');
		$locationRepository = $this->getDoctrine()->getRepository('BubelbubSmartHomeGUIBundle:Location');

		$centrals = $centralRepository->findAll();
		$loaded = 0;

		/** @var $central Central */
		foreach($centrals as $central)
		{
			$smartHome = $central->getSmartHome();
			if($smartHome !== null)
			{
				$entities = $smartHome->getEntities();

				foreach($entities->LCs->LC as $lc)
				{
					$location = $locationRepository->find($lc->Id) ?: new Location($lc->Id);
					$location->setName($lc->Name);
					$location->setPosition($lc->Position);
					$em->persist($location);
				}

				$loaded++;
			}
		}

		$em->flush();
		$output->writeln('Loaded ' . $loaded . '/' . count($centrals) . ' central(s)');
	}

	/**
	 * @return \Doctrine\Bundle\DoctrineBundle\Registry
	 */
	private function getDoctrine()
	{
		return $this->getContainer()->get('doctrine');
	}
}
