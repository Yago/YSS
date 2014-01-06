#YSS : Yago Style Sheet

>YSS is styleguide framework written in **PHP and jQuery**. It display nicely all your commented CSS to create a very usefull tool.

Check the [demo](http://yago.io/project/yss/)

##Features
* YSS can read Markdown comments in multiple CSS files.
* Perfect to test responsive web design
* Starting with your titles hierarchy, YSS create a simple side navigation to access quickly to your elements
* It is the perfect tool to document your CSS and to read it

##Installation

1. Just copy the repository wherever you want.
2. Set the path to your CSS file(s) in the config file (**/config.php**)
3. Install the dependencies with [Composer](http://getcomposer.org/)

````
$ cd path/to/your/styleguide/dir/
$ composer install
````

4. Just open the url to the directory in your favorite browser/device. Ex: http://myapp.dev/styleguide/ 

##Usage
YSS can read the full Markdown syntax, but to create a understandable styleguide, **check the example below** (be careful to use the right `) :

````
/*
#Font styles
## Titles
''''
<h1>My title number 1</h1>
<h2>My title number 2</h2>
<h3>My title number 3</h3>
<h4>My title number 4</h4>
<h5>My title number 5</h5>
<h6>My title number 6</h6>
''''
##Paragraphs
''''
<p>
  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ego vero volo in virtute vim esse quam maximam; Sed quid attinet de rebus tam apertis plura requirere?
</p>
''''
*/

h1, h2, h3, h4, h5, h6 {
  font-weight: 900;
  color: red;
}

p {
  font-size: 14px;
}
````

##Dependencies
* [Parsedown](https://github.com/erusev/parsedown), by **Emanuil Rusev**
* [Scssphp](https://github.com/leafo/scssphp), by **Leaf Corcoran**
* [Rainbow](https://github.com/ccampbell/rainbow), by **Craig Campbell**
