<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>


## Who's Valkyrie

So you stop asking about who's Valkyrie or why. Valkyrie is character in one of my favirot show, [The Last Ship](https://g.co/kgs/xzxJ6Q).

## About The Project

This project was created inorder to provide an illustration of how modular architecture can be implemnted in Laravel. Modular architecture provides an approach to manage the complexity of large scale projects by breaking problems down into small components while maintaining low coupling between the different modules of the projct. 

Generally every project is compaination of set of different features or components that communicate and interact with each other to provide a solution for a business problem. Following the modular architecture, a number of these tightly coupled feature can be grouped together to form one module. This module can then be shared and reused with other projects inorder to reduce the time spent to deliver project to client or market.

<br/>
<br/>
<p align="center">
    <img src="https://drive.google.com/uc?export=view&id=1FS9hRGGSCZg71Z6weGBEwD_JBW4EUFF-" width="700">
</p>
<br/>
<br/>

## Inspiration

This project was mainly inspired by the approach Laravel has when developing composer packages that can be installed and easily integrated by any developer without having to write the code yourself (reinventing the wheel).

## Why the change

Laravel comes with a pretty neat structure that is suited for almost every small to medium project. However after completing a number of considerably large and complex projects such as [Zcova](https://www.zcova.com) and [e-MCQ](https://www.myemcq.com). The were serveral issues that made these projects very hard to maintain and very risky to introduce new features complex features without introducing bugs to the already built features.

This project aims to prevent these issues from happing again in future projects. 

## Learning Resources

- [Meduim Article On Modular Architecture](https://medium.com/on-software-architecture/on-modular-architectures-53ec61f88ff4)
- [Laravel Modules Package](https://github.com/nWidart/laravel-modules)

    Laravel Modules Package provides the tooling necessery to get setup and create new modules easily with having to create the new files by yourself.
    
- [Bagisto Source Code](https://github.com/bagisto/bagisto)
   
   Bagisto is an open source Ecommerce Application that has a real life example of how modular architecture can be implemented in complex projects. This github package can show you how features can be broken down into smaller modules and how they can interact with each other.
   
   
## Getting Started


1. Clone the repository and cd to the project folder.

```
git clone git@github.com:thetechyhub/valkyrie.git && cd valkyrie
```

2. Run composer install

```
composer install
```

3. Update the modules composer

This command will update all modules composer packages.


```
php artisan modules:update
```


4. Run migration and seed commands

```
php artisan migrate

php artisan module:migrate

php artisan db:seed

php artisan module:seed
```

5. cd to the Admin module and then install and compile the npm packages

```
cd Modules/Admin

npm install && npm run dev
```

6. Setup your domain

This may vary for windows and macs so just setup your localhost domain with Valet or XAMMP. Take a note that the Admin module is set to be served over sub-domain for example `admin.valkyrie.ts`


## Issues Reporting

If you discover any issues within Valkyrie, Please open an [issue](https://github.com/thetechyhub/valkyrie/issues) highliting the problem.
