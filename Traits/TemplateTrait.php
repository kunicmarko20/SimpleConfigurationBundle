<?php

namespace KunicMarko\ConfigurationPanelBundle\Traits;

trait TemplateTrait
{
   public function getTemplateFile(){
       return static::$template;
   }
}
