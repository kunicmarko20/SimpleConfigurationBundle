Simple Configuration Bundle
============

[![Build Status](https://travis-ci.org/kunicmarko20/SimpleConfigurationBundle.svg?branch=master)](https://travis-ci.org/kunicmarko20/SimpleConfigurationBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4b9c511d-3a09-442e-b882-db7da663bf11/mini.png)](https://insight.sensiolabs.com/projects/4b9c511d-3a09-442e-b882-db7da663bf11)
[![StyleCI](https://styleci.io/repos/108571141/shield)](https://styleci.io/repos/108571141)

This bundle adds key:value storage to your sonata admin, also you can easily extend bundle and add your own types.


This bundle depends on [SonataAdminBundle](https://github.com/sonata-project/SonataAdminBundle)

![Dashboard](https://cloud.githubusercontent.com/assets/13528674/21304601/a1c4936e-c5c6-11e6-9834-2d9f9942c5ff.png)
Documentation
-------------


* [Installation](#installation)
* [How to use](#how-to-use)
* [Add new type](#add-new-type)
* [Roles and Categories](#roles-and-categories)
* [Additional stuff](#additional-stuff)


## Installation

**1.**  Add to composer.json to the `require` key

```
composer require kunicmarko/simple-configuration-bundle
```

**2.** Register the bundle in ``app/AppKernel.php``

```
$bundles = array(
    // ...
    new KunicMarko\SimpleConfigurationBundle\SimpleConfigurationBundle(),
);
```
If you are not using auto_mapping add it to your orm mappings
```
# app/config/config.yml
   orm:
        entity_managers:
            default:
                mappings:
                    AppBundle: ~
                    ...
                    SimpleConfigurationBundle: ~
```

**3.** Update database

```
app/console doctrine:schema:update --force
```

**4.** Clear cache
```
app/console cache:clear
```

## How to use

In your twig template you can call it like :
```
{{ simple_configuration.getAll() }}
{{ simple_configuration.getValueFor('name') }}
```

if you want to use it in controller you can do :
```
$this->get('simple_configuration.service.configuration')->getAll()
$this->get('simple_configuration.service.configuration')->getValueFor('name')
```

## Add new type

If you want to add new types, you can do it like this
```
# app/config/config.yml

simple_configuration:
    types: 
        newtype: YourBundle\Entity\NewType
```

### Creating new Type ### 

Your new type has to extend AbstractConfigurationType, you also have to specify template used for sonata list (it can be sonata template, or your own created), and how should field be rendered in form.

**1.** New type without new column
```
namespace YourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
*
* @ORM\Entity(repositoryClass="KunicMarko\SimpleConfigurationBundle\Repository\ConfigurationRepository")
*
*/
class NewType extends AbstractConfigurationType
{
    /**
     * {@inheritDoc}
     */
    public function getTemplate() : string
    {
        return 'SonataAdminBundle:CRUD:list_string.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function generateFormField(FormMapper $formMapper) : void
    {
        $formMapper->add('value', TextType::class, ['required' => false]);
    }
}

```
**2.** New type with new column

As you can see from example code below, we added new `$date` field, the one thing that is necessary is to overwrite `getValue()` method with delegating to your getter for new field as shown below.

```

namespace YourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;

/**
*
* @ORM\Entity(repositoryClass="KunicMarko\SimpleConfigurationBundle\Repository\ConfigurationRepository")
*
*/
class NewType extends AbstractConfigurationType
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    public function setDate(?\DateTime $date) : self
    {
        $this->date = $date;

        return $this;
    }

    public function getDate() : ?\DateTime
    {
        return $this->date;
    }

    public function getValue() : ?\DateTime
    {
        return $this->getDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplate() : string
    {
        //return 'SonataAdminBundle:CRUD:list_string.html.twig'; can also be used 
        
        return 'ConfigurationPanelBundle:CRUD:list_field_date.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function generateFormField(FormMapper $formMapper) : void
    {
        $formMapper->add('date', DateType::class, ['required' => false]);
    }
}

```
Do not forget to update database after adding new field :
                                 
```
app/console doctrine:schema:update --force
```

## Additional stuff

When including this bundle you get access to some twig filters I needed.

### Elapsed ###

In twig you can use `|elapsed` filter and you will get human readable time, it works with timestamps or DateTime objects.
```
{{ var|elapsed }}

#outputs "time" ago, 5 days ago, 5 minutes ago, just now, 1 month ago, etc.
```
