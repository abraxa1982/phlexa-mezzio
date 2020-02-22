<?php
/**
 * Build voice applications for Amazon Alexa with phlexa, PHP and Mezzio
 *
 * @author     Ralf Eggert <ralf@travello.audio>
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/phoice/phlexa-mezzio
 * @link       https://www.phoice.tech/
 * @link       https://www.travello.audio/
 */

declare(strict_types=1);

namespace PhlexaMezzio\Middleware;

use Interop\Container\ContainerInterface;
use Phlexa\Request\AlexaRequest;
use Phlexa\Configuration\SkillConfiguration;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class CheckApplicationMiddlewareFactory
 *
 * @package PhlexaMezzio\Middleware
 */
class CheckApplicationMiddlewareFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CheckApplicationMiddleware
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var AlexaRequest $alexaRequest */
        $alexaRequest = $container->get(AlexaRequest::class);

        if ($alexaRequest) {
            /** @var SkillConfiguration $skillConfiguration */
            $skillConfiguration = $container->get(SkillConfiguration::class);

            $applicationId = $skillConfiguration->getApplicationId();
        } else {
            $applicationId = null;
        }

        return new CheckApplicationMiddleware($applicationId, $alexaRequest);
    }
}
