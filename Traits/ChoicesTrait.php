<?php

namespace KunicMarko\ConfigurationPanelBundle\Traits;

trait ChoicesTrait
{
    use TemplateTrait;
    
    private static $template = 'ConfigurationPanelBundle:CRUD:list_field_choice.html.twig';
     /**
     * @ORM\Column(type="text")
     */
    protected $choices;
    
    public function getChoices()
    {
        return $this->choices;
    }
 
    public function setChoices($choices)
    {
        $this->choices = $choices;
    }
    
    public function formatChoices(){
        if($this->choices == null) return null;
        $options = explode("\r\n",$this->choices);
        $arr = [];
        foreach($options as $option){
            $option = explode(":",$option);
            $arr[trim($option[0])] = trim($option[1]);
        }
        return $arr;
    }     
}
