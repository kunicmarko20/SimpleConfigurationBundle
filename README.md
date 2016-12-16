Symfony Sonata Configuration Panel
============
This bundle adds configuration panel to your sonata admin.


## Installation

**1.**  Add to composer.json to the `require` key

```
composer require kunicmarko/configuration-panel
```

**2.** Register the bundle in ``app/AppKernel.php``

```
$bundles = array(
    // ...
    new KunicMarko\ConfigurationPanelBundle\ConfigurationPanelBundle(),
);
```