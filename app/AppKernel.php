<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new MairieVoreppe\DemandeTravauxBundle\MairieVoreppeDemandeTravauxBundle(),
            new Sp\BowerBundle\SpBowerBundle(),
            new Fkr\CssURLRewriteBundle\FkrCssURLRewriteBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new SimpleThings\EntityAudit\SimpleThingsEntityAuditBundle(),      

            //SONATA  
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\DatagridBundle\SonataDatagridBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),

            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new MairieVoreppe\AdminBundle\MairieVoreppeAdminBundle(),
            new Shtumi\UsefulBundle\ShtumiUsefulBundle(),      
            new MairieVoreppe\UsefulBundle\MairieVoreppeUsefulBundle(),
            new Misd\PhoneNumberBundle\MisdPhoneNumberBundle(),
            new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            // new SC\DatetimepickerBundle\SCDatetimepickerBundle(), bundle mal pensé
            new Lexik\Bundle\MaintenanceBundle\LexikMaintenanceBundle(),
            new Infinite\FormBundle\InfiniteFormBundle,
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
