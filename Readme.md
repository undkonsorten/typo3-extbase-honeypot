# TYPO3 Extension extbase_honeypot

## What does it do?

This extension allows you to add a simple honeypot field to an extbase
extension. It can reduce SPAM for a given form but won‘t be able to
exclude all bots.

## Installation

Just require via composer:

```shell
composer require undkonsorten/typo3-extbase-honeypot
```

Activate the extension for TYPO3 versions prior to 11.

## Usage

### Controller

[Inject](https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/DependencyInjection/Index.html#using-di)
`\Undkonsorten\HoneyPot\Service\HoneyPotService` in your controller, eg a `$honeyPotService`.

Then add a call to it before the action that receives the form you want
to protect:

```php
    public function initializeCreateAction(): void
    {
        $this->honeyPotService->configureHoneyPotForArgument($this->arguments->getArgument('dto'), $this->request->getArgument('dto'), '_hp');
    }

    public function createAction(DTO $dto): ResponseInterface
```

where the `createAction` is the appropriated form action and `dto` is the name of your argument and `_hp` is the name of the fake
property for your honeypot field. Just be sure to avoid collisions with existing
properties.

### Template

Now add the field to your template like this:
```xml
    <f:render partial="Field/HoneyPot" section="Main" arguments="{field:'_hp'}" />
```
where `_hp` is the name you chose in your controller. What‘s now left to do
is configure your view to look in the right place for the partial, e.g. via **TypoScript**:

```typo3_typoscript
plugin.tx_myext {
    view.partialRootPaths.42 = EXT:extbase_honeypot/Resources/Private/Partials/
}
```

For showing error message if the field was filled, you can use the example in locallang files:
`typo3-extbase-honeypot/Resources/Private/Language/locallang.xlf`
Copy the lines with the proper error code to your extensions/site-packge/whatever and change property name if you not use the default `_hp`.

Add f:translate snippet to the used action template.

```html
<f:if condition="{validationResults.flattenedErrors}">
    <ul class="formerror">
        <f:for each="{validationResults.flattenedErrors}" key="propertyPath" as="errors">
            <f:for each="{errors}" as="error"><li>
                <f:translate key="error.{error.code}.{propertyPath}" arguments="{0:propertyPath}" />
            </li></f:for>
        </f:for>
    </ul>
</f:if>
```


## Configuration

No further configuration is needed - all you need is now in your code. You can
make things like the field name configurable, of course.
