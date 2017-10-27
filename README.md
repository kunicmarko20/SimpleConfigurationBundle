Sonata Configuration Panel
============
This bundle adds configuration panel to your sonata admin, also you can easily extend bundle and add your own types.


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
composer require kunicmarko/configuration-panel
```

**2.** Register the bundle in ``app/AppKernel.php``

```
$bundles = array(
    // ...
    new KunicMarko\SimpleConfigurationBundle\ConfigurationPanelBundle(),
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
                    ConfigurationPanelBundle: ~
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
{{ configuration.getAll() }}
{{ configuration.getValueFor(name) }}
```

if you want to use it in controller you can do :
```
$this->get('configuration_panel.global.service')->getAll()
$this->get('configuration_panel.global.service')->getValueFor()
```

## Add new type

If you want to add new types, you can do it like this
```
# app/config/config.yml

configuration_panel:
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
    public function getTemplate()
    {
        return 'SonataAdminBundle:CRUD:list_string.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function generateFormField(FormMapper $formMapper)
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

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return DateType
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getValue()
    {
        return $this->getDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplate()
    {
        //return 'SonataAdminBundle:CRUD:list_string.html.twig'; can also be used 
        
        return 'ConfigurationPanelBundle:CRUD:list_field_date.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function generateFormField(FormMapper $formMapper)
    {
        $formMapper->add('date', DateType::class, ['required' => false]);
    }
}

```
Do not forget to update database after adding new field :
                                 
```
app/console doctrine:schema:update --force
```

## Roles and Categories

This bundle was made as help to developers so only `ROLE_SUPER_ADMIN` can create and delete items, regular admins can only edit. ( You can create keys and allow other admins to just edit them ).
There are 2 categories when creating item, `Meta` and `General`, only `ROLE_SUPER_ADMIN` can see and edit items that are in `META` category while normal admins can only edit and see `General` items.


## Additional stuff

When including this bundle you get access to some twig filters I needed.

### Elapsed ###

In twig you can use `|elapsed` filter and you will get human readable time, it works with timestamps or DateTime objects.
```
{{ var|elapsed }}

#outputs "time" ago, 5 days ago, 5 minutes ago, just now, 1 month ago, etc.
```
