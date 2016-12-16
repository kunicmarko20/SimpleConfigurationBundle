<?php

namespace KunicMarko\ConfigurationPanelBundle\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType  as FormChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType as FormTextType;
use Symfony\Component\Form\Extension\Core\Type\DateType as FormDateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType as FormEmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType as FormFileType;
use KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\TextType;
use KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\DateType;
use KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\BooleanType;
use KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\ChoiceType;
use KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\CheckboxType;
use KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\ColorType;
use KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\EmailType;
use KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\HtmlType;
use KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\TextareaType;
use KunicMarko\ConfigurationPanelBundle\Entity\Configuration;

class ConfigurationAdmin extends AbstractAdmin
{
    
    private $AuthorizationChecker;
    private $uploadDirectory;
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('value')
            ->add('category',null, array('show_filter'=>false))
        ;
    }
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        
        $listMapper
            ->add('name')   
            ->add('value',null,array('template' => 'ConfigurationPanelBundle:CRUD:list_field_value.html.twig'))
            ->add('createdAt',null,array('template' => 'ConfigurationPanelBundle:CRUD:list_field_created_at.html.twig'))   
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(
                        'template' => 'ConfigurationPanelBundle:CRUD:list_action_edit.html.twig'
                    ),
                    'delete' => array(
                        'template' => 'ConfigurationPanelBundle:CRUD:list_action_delete.html.twig'
                    ),
                )
            ));

    }
    protected function configureTabMenu(ItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        $routes = array('admin_kunicmarko_configurationpanel_configuration_list');
        $currentRoute = $this->getRequest()->get('_route');
        if(!in_array($currentRoute, $routes)) return;
        if(!$this->getAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) return;
        $filters = Configuration::getCategories();

        foreach($filters as $k => $v){
            $menu->addChild($v, [
                    'uri' => $this->generateUrl('list',[
                        'filter[category][type]'=>'','filter[category][value]'=>$k
            ])]);        
        }
    }
    public function getBatchActions() {
        if($this->getAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')){
           return parent::getBatchActions();     
        }
    }

    public function configureActionButtons($action, $object = null)
    {
        $list = array();
        if (in_array($action, array('tree', 'show', 'edit', 'delete', 'list', 'batch'))) {
            $list['create'] = array(
                'template' => 'ConfigurationPanelBundle:CRUD:create_button.html.twig',
            );
        }
        if (in_array($action, array('show', 'delete', 'acl', 'history')) && $object) {
            $list['edit'] = array(
                'template' => 'SonataAdminBundle:Button:edit_button.html.twig',
            );
        }

        if (in_array($action, array('show', 'edit', 'acl')) && $object) {
            $list['history'] = array(
                'template' => 'SonataAdminBundle:Button:history_button.html.twig',
            );
        }

        if (in_array($action, array('edit', 'history')) && $object) {
            $list['acl'] = array(
                'template' => 'SonataAdminBundle:Button:acl_button.html.twig',
            );
        }

        if (in_array($action, array('edit', 'history', 'acl')) && $object) {
            $list['show'] = array(
                'template' => 'SonataAdminBundle:Button:show_button.html.twig',
            );
        }

        if (in_array($action, array('show', 'edit', 'delete', 'acl', 'batch'))) {
            $list['list'] = array(
                'template' => 'SonataAdminBundle:Button:list_button.html.twig',
            );
        }
        return $list;
    }  
    
    public function configure() {
        $this->setTemplate('edit', 'ConfigurationPanelBundle:CRUD:edit.html.twig');
        $this->setTemplate('list', 'ConfigurationPanelBundle:CRUD:list.html.twig');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $object = $this->getSubject();

        $class = $this->getClass();
        $formMapper
            ->with('Content');
        if ($this->getAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
            $formMapper
            ->add('name', FormTextType::class)
            ->add('category', FormChoiceType::class, ['choices' => Configuration::getCategories()]);
        }
        switch($class) { 
            case TextType::class :
                $formMapper->add('value', FormTextType::class, ['required' => false]);
            break;
            case DateType::class :
                $formMapper->add('date', FormDateType::class, ['required' => false]);
            break;
            case HtmlType::class:
                $formMapper->add('value', CKEditorType::class, ['required' => false]); 
            break;
            case EmailType::class :
                $formMapper->add('value', FormEmailType::class,['required' => false]);
            break;
            case CheckboxType::class :
                if($object->formatChoices()){
                    $formMapper->add('value', FormChoiceType::class, ['choices' => $object->formatChoices(), 'required' => false, 'multiple' => true, 'expanded' => true]);                   
                }
            case ChoiceType::class :
                if($object->formatChoices() && $class === ChoiceType::class ){
                    $formMapper->add('value', FormChoiceType::class, ['choices' => $object->formatChoices(), 'required' => false]);                   
                }
                if ($this->getAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
                    $formMapper->add('choices', null, [
                            'label'=>'Options',
                            'attr' => [
                                'placeholder' => "option1:Option1\r\noption2:Option2\r\noption3:Option3"
                            ]
                    ]);
                }
            break;
            case BooleanType::class :
                $formMapper->add('value', FormChoiceType::class, ['required' => false, 'data' => $object->getId() ? $object->getValue() : 0,
                    'choices' => [
                        0 => 'no',
                        1 => 'yes'
                    ],
                ]);
            break;
            case ColorType::class :
                $formMapper->add('value', FormTextType::class, ['required' => false,'data' => $object->getId() ? $object->getValue() : '#FF0000','attr' => ['class' => 'colorpicker']]);
            break;
            case TextareaType::class :
                $formMapper->add('value', null, [ 'required' => false ]);
            break;
            default:
                if ($this->checkType('MediaType')) {
                    $formMapper->add('media', 'sonata_type_model_list', ['required' => false], ['link_parameters' => ['context' => 'default']]);
                    break;
                }
                if ($this->checkType('FileType')) {
                    $formMapper->add('value', FormFileType::class, ['label' => 'File','data_class' => null,'required'=>false]); 
                }
            break;
        }
    }
    
    public function prePersist($object) {
        if($this->checkType('FileType')){
            if($object->getValue() === null) return;
            $fileName = $this->uploadFile($object->getValue());
            $object->setValue($fileName);
        }
    }
    public function preUpdate($object) {
        if($this->checkType('FileType')){
            if($object->getValue() === null) return $object->setValue($object->getOldFile());
            $fileName = $this->uploadFile($object->getValue());
            if($object->getOldFile() !== null) $this->removeFile($object->getOldFile());
            $object->setValue($fileName);
        }
    }
    public function postPersist($object) {
        $this->updateCache();
    }

    public function postUpdate($object) {
        $this->updateCache();
    }

    public function postRemove($object) {
        if($this->checkType('FileType') && $object->getValue() !== null){
            $this->removeFile($object->getValue());
        }
        $this->updateCache();
    }

    public function updateCache(){
        $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('configuration.cache.warmer')
            ->warmUp();
    }
    
    public function checkType($type){
        return strpos($this->getClass(), $type) !== false ?: false;
    }
    
    private function uploadFile($file){
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getUploadDirectory(),
            $fileName
        );

        return $fileName;
    }
    
    private function removeFile($file){
        $dir = $this->getUploadDirectory();
        if(file_exists("$dir/$file")) unlink("$dir/$file");
    }
          
    public function setUploadDirectory($directory){
        $this->uploadDirectory = $directory;
    }
    
    public function getUploadDirectory(){
        return $this->uploadDirectory;
    }
       
    public function setAuthorizationChecker($AuhtorizationChecker) {
        $this->AuthorizationChecker = $AuhtorizationChecker;
    }
    
    public function getAuthorizationChecker() {
        return $this->AuthorizationChecker;
    }
    
}
