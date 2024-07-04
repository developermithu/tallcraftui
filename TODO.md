## Component List


### Icon

- [x] name
- [x] class
- [x] blade heroicons support 
  

### Input 

- [x] label
- [x] inline label
- [x] icon 
- [x] icon left 
- [x] icon right
- [x] placeholder
- [x] hint
- [x] preffix
- [x] suffix
- [x] disabled
- [x] readonly
- [x] input type
- [x] file input
- [x] required attribute or (*) with label
- [x] wire:model
- [x] prepend
- [x] append
- [ ] floating label
- [ ] make usable without livewire wire:model
  

### Button

- [x] label
- [x] label or slot
- [ ] icon
- [ ] icon left
- [ ] icon right
- [ ] spinner
- [ ] type
- [ ] color attribute (primary, secondary, danger, warning, success)
- [ ] size attribute (xs, sm, md, lg, xl, xxl)


## 

Add this property in the `tailwind.config.js` content section through `php artisan install:tallcraftui` command.

```js
tailwind.config.js

    content: [

        // TallCraftUI
        "./vendor/developermithu/tallcraftui/src/View/Components/**/*.php",
    ],
```