<?php

namespace Bubelbub\SmartHomeGUIBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class TabindexExtension
 * @package Bubelbub\SmartHomeGUIBundle\Twig
 * @author Bubelbub <bubelbub@gmail.com>
 */
class TabindexExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'tabindex' => new \Twig_Function_Method($this, 'tabindex'),
        );
    }

    /**
     * Renders the pagination template
     *
     * @param string $template
     * @param array $queryParams
     * @param array $viewParams
     *
     * @return string
     */
    public function tabindex($val = null)
    {
	    if($val != null || !array_key_exists('twig_tabindex', $GLOBALS))
	    {
		    $GLOBALS['twig_tabindex'] = $val == null ? 1 : $val;
	    }
        return $GLOBALS['twig_tabindex']++;
    }

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'bubelbub_smarthomegui_tabindex';
	}
}
