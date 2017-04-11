<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Admin;

use Knp\Menu\ItemInterface;
use KunicMarko\SonataConfigurationPanelBundle\Cache\Warmer\ConfigurationCacheWarmer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use KunicMarko\SonataConfigurationPanelBundle\Entity\AbstractConfiguration;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConfigurationAdmin extends AbstractAdmin
{
    const ADMIN_ROUTE = 'admin_kunicmarko_sonataconfigurationpanel_abstractconfiguration_list';
    /** @var AuthorizationChecker */
    private $authorizationChecker;
    /** @var ConfigurationCacheWarmer */
    private $cacheWarmer;
    /** @var array */
    private $additionalTypes;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('value')
            ->add('category', null, ['show_filter'=>false])
        ;
    }
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        // Don't you just hate that mosaic list mode?
        unset($this->listModes['mosaic']);

        $listMapper
            ->add('name')
            ->add('value', null, ['template' => 'ConfigurationPanelBundle:CRUD:list_field_value.html.twig'])
            ->add('createdAt', null, ['template' => 'ConfigurationPanelBundle:CRUD:list_field_created_at.html.twig'])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [
                        'template' => 'ConfigurationPanelBundle:CRUD:list_action_edit.html.twig'
                    ],
                    'delete' => [
                        'template' => 'ConfigurationPanelBundle:CRUD:list_action_delete.html.twig'
                    ],
                ]
            ]);
    }

    protected function configureTabMenu(ItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        $currentRoute = $this->getRequest()->get('_route');
        if ($currentRoute != self::ADMIN_ROUTE) {
            return;
        }
        if (!$this->getAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
            return;
        }
        $filters = AbstractConfiguration::getCategories();

        foreach ($filters as $k => $v) {
            $menu->addChild($v, [
                    'uri' => $this->generateUrl('list', [
                        'filter[category][type]'=>'','filter[category][value]'=>$k
                    ])]);
        }
    }

    public function getBatchActions()
    {
        if ($this->getAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
            return parent::getBatchActions();
        }
    }

    public function configureActionButtons($action, $object = null)
    {
        $list = [];
        if (in_array($action, ['tree', 'show', 'edit', 'delete', 'list', 'batch'])) {
            $list['create'] = [
                'template' => 'ConfigurationPanelBundle:CRUD:create_button.html.twig',
            ];
        }
        if (in_array($action, ['show', 'delete', 'acl', 'history']) && $object) {
            $list['edit'] = [
                'template' => 'SonataAdminBundle:Button:edit_button.html.twig',
            ];
        }

        if (in_array($action, ['show', 'edit', 'acl']) && $object) {
            $list['history'] = [
                'template' => 'SonataAdminBundle:Button:history_button.html.twig',
            ];
        }

        if (in_array($action, ['edit', 'history']) && $object) {
            $list['acl'] = [
                'template' => 'SonataAdminBundle:Button:acl_button.html.twig',
            ];
        }

        if (in_array($action, ['edit', 'history', 'acl']) && $object) {
            $list['show'] = [
                'template' => 'SonataAdminBundle:Button:show_button.html.twig',
            ];
        }

        if (in_array($action, ['show', 'edit', 'delete', 'acl', 'batch'])) {
            $list['list'] = [
                'template' => 'SonataAdminBundle:Button:list_button.html.twig',
            ];
        }
        return $list;
    }

    public function configure()
    {
        $this->setTemplate('list', 'ConfigurationPanelBundle:CRUD:list.html.twig');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $object = $this->getSubject();

        $formMapper
            ->with('Content');
        if ($this->getAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
            $formMapper
            ->add('name', TextType::class)
            ->add('category', ChoiceType::class, ['choices' => AbstractConfiguration::getCategories()]);
        }
        $object->generateFormField($formMapper);
    }

    /**
     * {@inheritdoc}
     */
    public function setSubClasses(array $subClasses)
    {
        $newSubClasses = array_merge($subClasses, $this->getAdditionalTypes());

        parent::setSubClasses($newSubClasses);
    }

    public function postPersist($object)
    {
        $this->updateCache();
    }

    public function postUpdate($object)
    {
        $this->updateCache();
    }

    public function postRemove($object)
    {
        $this->updateCache();
    }

    /**
     *  Updates cached data
     */
    public function updateCache()
    {
        $this
            ->getCacheWarmer()
            ->warmUp();
    }

    public function setAuthorizationChecker(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function getAuthorizationChecker()
    {
        return $this->authorizationChecker;
    }

    public function setCacheWarmer(ConfigurationCacheWarmer $cacheWarmer)
    {
        $this->cacheWarmer = $cacheWarmer;
    }

    public function getCacheWarmer()
    {
        return $this->cacheWarmer;
    }

    public function setAdditionalTypes(array $additionalTypes)
    {
        $this->additionalTypes = $additionalTypes;
    }

    public function getAdditionalTypes()
    {
        return $this->additionalTypes;
    }
}
