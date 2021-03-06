.. _Rules:

Rules list
----------

Introduction
############

.. comment: The rest of the document is automatically generated. Don't modify it manually. 
.. comment: Rules details
.. comment: Generation date : Mon, 10 Jul 2017 16:44:17 +0000
.. comment: Generation hash : aa2b2b976dc82410678158d1a8a5ded6dd368d45


.. _$http\_raw\_post\_data:

$HTTP_RAW_POST_DATA
###################


Starting at PHP 5.6, $HTTP_RAW_POST_DATA is deprecated, and should be replaced by php://input. You may get ready by setting always_populate_raw_post_data to -1.

.. code-block:: php

   <?php
   
   // PHP 5.5 and older
   $postdata = $HTTP_RAW_POST_DATA;
   
   // PHP 5.6 and more recent
   $postdata = file_get_contents(php://input);
   
   ?>

+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/RawPostDataUsage                                                                                                                  |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+


.. _$this-belongs-to-classes-or-traits:

$this Belongs To Classes Or Traits
##################################


$this variable represents only the current object. 

It is a pseudo-variable, and should be used within class's or trait's methods (except for static) and not outside.

PHP 7.1 is stricter and check for $this at several positions. Some are found by static analysis, some are dynamic analysis.

.. code-block:: php

   <?php
   
   // as an argument
   function foo($this) {
       // Using global
       global $this;
       // Using static (not a property)
       static $this;
       
       // Can't unset it
       unset($this);
       
       try {
           // inside a foreach
           foreach($a as $this) {  }
           foreach($a as $this => $b) {  }
           foreach($a as $b => $this) {  }
       } catch (Exception $this) {
           // inside a catch
       }
       
       // with Variable Variable
       $a = this;
       $$a = 42;
   }
   
   class foo {
       function bar() {
           // Using references
           $a =& $this;
           $a = 42;
           
           // Using 'extract(), 'parse_str() or similar functions
           extract([this => 42]);  // throw new Error(Cannot re-assign $this)
           var_dump($this);
       }
   
       static function '__call($name, $args) {
           // Using '__call
           var_dump($this); // prints object(C)#1 (0) {}, php-7.0 printed NULL
           $this->test();   // prints ops
       }
   
   }
   ?>

+--------------+--------------------------+
| Command Line | Classes/ThisIsForClasses |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _$this-is-not-an-array:

$this Is Not An Array
#####################


`$this` variable represents the current object and it is not an array, unless the class (or its parents) has the `'ArrayAccess <http://php.net/manual/en/class.arrayaccess.php>`_ interface.

.. code-block:: php

   <?php
   
   // $this is an array
   class Foo extends 'ArrayAccess {
       function bar() {
           ++$this[3];
       }
   }
   
   // $this is not an array
   class Foo2 {
       function bar() {
           ++$this[3];
       }
   }
   
   ?>

+--------------+--------------------------+
| Command Line | Classes/ThisIsNotAnArray |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _$this-is-not-for-static-methods:

$this Is Not For Static Methods
###############################


Static methods shouldn't use $this variable.

$this variable represents an object (the current object) and it is not compatible with a static method, which may operate without any object. 

.. code-block:: php

   <?php
   
   class foo {
       static public function bar() {
           return $this->a;   // No $this usage in a static method
       }
   }
   
   ?>

+--------------+---------------------------------------------------------------------------------------------+
| Command Line | Classes/ThisIsNotForStatic                                                                  |
+--------------+---------------------------------------------------------------------------------------------+
| clearPHP     | `no-static-this <https://github.com/dseguy/clearPHP/tree/master/rules/no-static-this.md>`__ |
+--------------+---------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                              |
+--------------+---------------------------------------------------------------------------------------------+


.. _**-for-exponent:

** For Exponent
###############


PHP 5.6 introduced the operator `'** <http://php.net/manual/en/language.operators.arithmetic.php>`_ to provide exponents, instead of the slower function `'pow() <http://www.php.net/pow>`_.

.. code-block:: php

   <?php
       $cube = pow(2, 3); // 8
   
       $cubeInPHP56 = 2 '** 3; // 8
   ?>


If the code needs to be backward compatible to 5.5 or less, don't use the new operator.

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/NewExponent                                                                 |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55` |
+--------------+---------------------------------------------------------------------------------+


.. _...-usage:

... Usage
#########


Usage of the ... keyword, either in function definitions, either in functioncalls.

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/EllipsisUsage                                                               |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55` |
+--------------+---------------------------------------------------------------------------------+


.. _\:\:class:

::class
#######


PHP 5.5 introduced a special class constant, relying on the 'class' keyword. It will solve the classname that is used in the left part of the operator.

.. code-block:: php

   <?php
   class foo {
       public function bar( ) {
           echo ClassName::class; 
       }
   }
   
   $f = new Foo( );
   $f->bar( );
   // return Namespace\ClassName
   
   ?>

+--------------+------------------------------------------------------+
| Command Line | Php/StaticclassUsage                                 |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54` |
+--------------+------------------------------------------------------+


.. _<?=-usage:

<?= Usage
#########


Usage of the <?= tag, that echo's directly the following content.

<?= $variable; 
?>

+--------------+------------------+
| Command Line | Php/EchoTagUsage |
+--------------+------------------+
| Analyzers    | :ref:`Analyze`   |
+--------------+------------------+


.. _@-operator:

@ Operator
##########


@ is the 'no scream' operator : it will suppress error output. 

.. code-block:: php

   <?php
   
   // Set x with incoming value, or else null. 
   $x = @$_GET['x'];
   
   ?>


This operator is actually very slow : it will process the error all the way up, and finally decide not to display it. It is often faster to check the conditions first, then run the method without @.

You may also set display_error to 0 in the php.ini : this will avoid user's error display, but will keep the error in the PHP logs, for later processing. 

The only situation where @ is useful is when a native PHP function displays errors messages when error happens and there is no way to check it from the code. 

This is the case with `'fopen() <http://www.php.net/fopen>`_, `'stream_socket_server() <http://www.php.net/stream_socket_server>`_, `'token_get_all() <http://www.php.net/token_get_all>`_.

+--------------+---------------------------------------------------------------------------------------+
| Command Line | Structures/Noscream                                                                   |
+--------------+---------------------------------------------------------------------------------------+
| clearPHP     | `no-noscream <https://github.com/dseguy/clearPHP/tree/master/rules/no-noscream.md>`__ |
+--------------+---------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                        |
+--------------+---------------------------------------------------------------------------------------+


.. _abstract-static-methods:

Abstract Static Methods
#######################


Methods cannot be both abstract and static. Static methods belong to a class, and will not be overridden by the child class. For normal methods, PHP will start at the object level, then go up the hierarchy to find the method. With static, you have to mention the name, or use Late Static Binding, with self or static. Hence, it is useless to have an abstract static method : it should be a simple static method.

A child class is able to declare a method with the same name than a static method in the parent, but those two methods will stay independant.

+--------------+------------------------+
| Command Line | Classes/AbstractStatic |
+--------------+------------------------+
| Analyzers    | :ref:`Analyze`         |
+--------------+------------------------+


.. _access-protected-structures:

Access Protected Structures
###########################


It is not allowed to access protected properties or methods from outside the class or its relatives.

+--------------+-------------------------+
| Command Line | Classes/AccessProtected |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _accessing-private:

Accessing Private
#################


List of calls to private properties/methods that will compile but yield some fatal error upon execution.

.. code-block:: php

   <?php
   
   class a {
       private $a;
   }
   
   class b extends a {
       function c() {
           $this->a;
       }
   }
   
   ?>

+--------------+-----------------------+
| Command Line | Classes/AccessPrivate |
+--------------+-----------------------+
| Analyzers    | :ref:`Analyze`        |
+--------------+-----------------------+


.. _action-should-be-in-controller:

Action Should Be In Controller
##############################


Action methods should be in a controller and public.

.. code-block:: php

   <?php
   
   use Zend\Mvc\Controller\AbstractActionController;
   
   class SomeController extends AbstractActionController
   {
       // Good method
       public function indexAction()
       {
           doSomething();
       }
   
       // Bad method : protected
       // turn protected into public, or drop the Action suffix
       protected function protectedIndexAction()
       {
           doSomething();
       }
   
       // Bad method : private
       // turn private into public, or drop the Action suffix
       protected function privateIndexAction()
       {
           doSomething();
       }
   
   }
   
   
   ?>

+--------------+--------------------------+
| Command Line | ZendF/ActionInController |
+--------------+--------------------------+
| Analyzers    | :ref:`ZendFramework`     |
+--------------+--------------------------+


.. _adding-zero:

Adding Zero
###########


Adding 0 is useless, as 0 is the neutral element for addition. It triggers a cast to integer, though behavior changes from PHP 7.0 to PHP 7.1. 

.. code-block:: php

   <?php
   
   $a = 123 + 0;
   $a = 0 + 123;
   
   // Also works with minus
   $b = 0 - $c; // drop the 0, but keep the minus
   $b = $c - 0; // drop the 0 and the minus
   
   $a += 0;
   $a -= 0;
   
   ?>


If it is used to type cast a value to integer, then casting (integer) is clearer.

+--------------+-----------------------------------------------------------------------------------------------+
| Command Line | Structures/AddZero                                                                            |
+--------------+-----------------------------------------------------------------------------------------------+
| clearPHP     | `no-useless-math <https://github.com/dseguy/clearPHP/tree/master/rules/no-useless-math.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                |
+--------------+-----------------------------------------------------------------------------------------------+


.. _aliases-usage:

Aliases Usage
#############


PHP manual recommends to avoid function aliases.

Some functions have several names, and both may be used the same way. However, one of the names is the main name, and the others are aliases. Aliases may be removed or change or dropped in the future. Even if this is not forecast, it is good practice to use the main name, instead of the aliases. 

.. code-block:: php

   <?php
   
   // official way to count an array
   $n = count($array);
   
   // official way to count an array
   $n = sizeof($array);
   
   ?>


Aliases are compiled in PHP, and do not provide any performances over the normal function. 

Aliases are more likely to be removed later, but they have been around for a long time.

See documentation : `List of function aliases <http://php.net/manual/en/aliases.php>`_.

+--------------+-------------------------------------------------------------------------------------+
| Command Line | Functions/AliasesUsage                                                              |
+--------------+-------------------------------------------------------------------------------------+
| clearPHP     | `no-aliases <https://github.com/dseguy/clearPHP/tree/master/rules/no-aliases.md>`__ |
+--------------+-------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                      |
+--------------+-------------------------------------------------------------------------------------+


.. _all-uppercase-variables:

All Uppercase Variables
#######################


Usually, global variables are all in uppercase, so as to differentiate them easily. Though, this is not always the case, with examples like $argc, $argv or $http_response_header.

When using custom variables, try to use lowercase $variables, $camelCase, $sturdyCase or $snake_case.

.. code-block:: php

   <?php
   
   // PHP super global, also identified by the initial _
   $localVariable = $_POST;
   
   // PHP globals
   $localVariable = $GLOBALS['HTTPS'];
   
   ?>


`Predefined Variables <http://php.net/manual/en/reserved.variables.php>`_

+--------------+------------------------------------------------+
| Command Line | Variables/VariableUppercase                    |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _already-parents-interface:

Already Parents Interface
#########################


The same interface is implemented by a class and one of its children. 

That way, the child doesn't need to implement the interface, nor define its methods to be an instance of the interface. 

.. code-block:: php

   <?php
   
   interface i { 
       function i();
   }
   
   class A implements i {
       function i() {
           return '__METHOD__;
       }
   }
   
   // This implements is useless. 
   class AB extends A implements i {
       // No definition for function i()
   }
   
   // Implements i is understated
   class AB extends A {
       // redefinition of the i method
       function i() {
           return '__METHOD__.' ';
       }
   }
   
   $x = new AB;
   var_dump($x 'instanceof i);
   // true
   
   $x = new AC;
   var_dump($x 'instanceof i);
   // true
   
   ?>

+--------------+------------------------------------+
| Command Line | Interfaces/AlreadyParentsInterface |
+--------------+------------------------------------+
| Analyzers    | :ref:`Analyze`                     |
+--------------+------------------------------------+


.. _altering-foreach-without-reference:

Altering Foreach Without Reference
##################################


Foreach() loop that should use a reference. 

When using a foreach loop that modifies the original source, it is recommended to use referenced variables, rather than access the original value with $source[$index]. 

Using references is then must faster, and easier to read. 

.. code-block:: php

   <?php
   
   // Using references in foreach
   foreach($source as $key => &$value) {
       $value = newValue($value, $key);
   }
   
   // Avoid foreach : use array_map
   $source = array_walk($source, 'newValue');
       // Here, $key MUST be the second argument or newValue
   
   // Slow version to update the array
   foreach($source as $key => &$value) {
       $source[$key] = newValue($value, $key);
   }
   ?>


You may also use `'array_walk() <http://www.php.net/array_walk>`_ or `'array_map() <http://www.php.net/array_map>`_ (when $key is not used) to avoid the use of foreach.

+--------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/AlteringForeachWithoutReference                                                                                        |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------+
| clearPHP     | `use-reference-to-alter-in-foreach <https://github.com/dseguy/clearPHP/tree/master/rules/use-reference-to-alter-in-foreach.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                                                    |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------+


.. _alternative-syntax-consistence:

Alternative Syntax Consistence
##############################


PHP allows for two syntax : the alternative syntax, and the classic syntax. 

The classic syntax is almost always used. When used, the alternative syntax is used in templates. 

This analysis reports files that are using both syntax at the same time. This is confusing.

.. code-block:: php

   <?php
   
   // Mixing both syntax is confusing.
   foreach($array as $item) : 
       if ($item > 1) {
           print $item elements\n;
       } else {
           print $item element\n;
       }
   endforeach;
   
   ?>

+--------------+-----------------------------------------+
| Command Line | Structures/AlternativeConsistenceByFile |
+--------------+-----------------------------------------+
| Analyzers    | :ref:`Analyze`                          |
+--------------+-----------------------------------------+


.. _always-positive-comparison:

Always Positive Comparison
##########################


Some PHP native functions, such as `'count() <http://www.php.net/count>`_, strlen(), or `'abs() <http://www.php.net/abs>`_ only returns positive or null values. 

When comparing them to 0, the following expressions are always true and should be avoided. 

.. code-block:: php

   <?php
   
   $a = [1, 2, 3];
   
   var_dump(count($a) >= 0);
   var_dump(count($a) < 0); 
   
   ?>

+--------------+--------------------------+
| Command Line | Structures/NeverNegative |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _ambiguous-array-index:

Ambiguous Array Index
#####################


Those indexes are defined with different types, in the same array. 

Array indices only accept integers and strings, so any other type of literal is reported. 

.. code-block:: php

   <?php
   
   $x = [ 1  => 1,
         '1' => 2,
         1.0 => 3,
         true => 4];
   // $x only contains one element : 1 => 4
   
   // Still wrong, immediate typecast to 1
   $x[1.0]  = 5; 
   $x[true] = 6; 
   
   ?>


They are indeed distinct, but may lead to confusion.

+--------------+----------------------+
| Command Line | Arrays/AmbiguousKeys |
+--------------+----------------------+
| Analyzers    | :ref:`Analyze`       |
+--------------+----------------------+


.. _anonymous-classes:

Anonymous Classes
#################


Anonymous classes.

.. code-block:: php

   <?php
   
   // Anonymous class, available since PHP 7.0
   $object = new class { function '__construct() { echo '__METHOD__; } };
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Classes/Anonymous                                                                                          |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _assign-default-to-properties:

Assign Default To Properties
############################


Properties may be assigned default values at declaration time. Such values may be later modified, if needed. 

.. code-block:: php

   <?php
   
   class foo {
       private $propertyWithDefault = 1;
       private $propertyWithoutDefault;
       private $propertyThatCantHaveDefault;
       
       public function '__construct() {
           // Skip this extra line, and give the default value above
           $this->propertyWithoutDefault = 1;
   
           // Static expressions are available to set up simple computation at definition time.
           $this->propertyWithoutDefault = OtherClass::CONSTANT + 1;
   
           // Arrays, just like scalars, may be set at definition time
           $this->propertyWithoutDefault = [1,2,3];
   
           // Objects or resources can't be made default. That is OK.
           $this->propertyThatCantHaveDefault = fopen('/path/to/file.txt');
           $this->propertyThatCantHaveDefault = new Fileinfo();
       }
   }
   
   ?>


Default values will save some instructions in the constructor, and makes the value obvious in the code.

+--------------+---------------------------------------------------------------------------------------------------------------------------+
| Command Line | Classes/MakeDefault                                                                                                       |
+--------------+---------------------------------------------------------------------------------------------------------------------------+
| clearPHP     | `use-properties-default-values <https://github.com/dseguy/clearPHP/tree/master/rules/use-properties-default-values.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                                            |
+--------------+---------------------------------------------------------------------------------------------------------------------------+


.. _assigned-twice:

Assigned Twice
##############


The same variable is assigned twice in the same function.

While this is possible and quite common, it is also a good practice to avoid changing a value from one literal to another. It is far better to assign the new value to 

Incremental changes to a variables are not reported here.

.. code-block:: php

   <?php
   
   function foo() {
       // incremental changes of $a;
       $a = 'a';
       $a++;
       $a = uppercase($a);
       
       $b = 1;
       $c = bar($b);
       // B changed its purpose. Why not call it $d? 
       $b = array(1,2,3);
       
       // This is some forgotten debug
       $e = $config->getSomeList();
       $e = array('OneElement');
   }
   
   ?>

+--------------+-------------------------------+
| Command Line | Variables/AssignedTwiceOrMore |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _avoid-large-array-assignation:

Avoid Large Array Assignation
#############################


Avoid setting large arrays to local variables. This is done everytime the function is called.

There are different ways to avoid this : inject the array, build the array once. Using an constant or even a global variable is faster.

The effect on small arrays (less than 10 elements) is not significant. Arrays with 10 elements or more are reported here. The effect is also more important on functions that are called often, or within loops.

.. code-block:: php

   <?php
   
   // with constants, for functions
   const ARRAY = array(1,2,3,4,5,6,7,8,9,10,11);
   function foo() {
       $array = ARRAY;
       //more code
   }
   
   // with class constants, for methods 
   class x {
       const ARRAY = array(1,2,3,4,5,6,7,8,9,10,11);
       function foo() {
           $array = self::ARRAY;
           //more code
       }
   }
   
   // with properties, for methods 
   class x {
       private $array = array(1,2,3,4,5,6,7,8,9,10,11);
       
       function foo() {
           $array = $this->array;
           //more code
       }
   }
   
   // injection, leveraging default values
   function foo($array = array(1,2,3,4,5,6,7,8,9,10,11)) {
       //more code
   }
   
   // local cache with static
   function foo() {
       static $array;
       if ($array === null) {
           $array = array(1,2,3,4,5,6,7,8,9,10,11);
       }
       
       //more code
   }
   
   // Avoid creating the same array all the time in a function
   class x {
       function foo() {
           // assign to non local variable is OK. 
           // Here, to a property, though it may be better in a '__construct or as default values
           $this->s = array(1,2,3,4,5,6,7,8,9,10,11);
   
           // This is wasting resources, as it is done each time. 
           $array = array(1,2,3,4,5,6,7,8,9,10,11);
       }
   }
   
   ?>

+--------------+------------------------------------+
| Command Line | Structures/NoAssignationInFunction |
+--------------+------------------------------------+
| Analyzers    | :ref:`Performances`                |
+--------------+------------------------------------+


.. _avoid-non-wordpress-globals:

Avoid Non Wordpress Globals
###########################


Refren using any global variable that is not Wordpress's own. 

Global variables are available for write and read across the whole application, making their data both easily accessible, and difficult to track when a unexpected change happen. 
It is recommended to rely on a mix of arguments passing and classes structures to reduce the code of any variable to a smaller part of the code.

.. code-block:: php

   <?php
   
   my_hook() {
       // This is a Wordpress global
       $GLOBALS['is_safari'] = true;
       
       // is_iphone7 is not a Wordpress variable
       global $is_iphone7;
   }
   
   ?>


See also `Global Variables <https://codex.wordpress.org/Global_Variables>`_

+--------------+-----------------------------+
| Command Line | Wordpress/AvoidOtherGlobals |
+--------------+-----------------------------+
| Analyzers    | :ref:`Wordpress`            |
+--------------+-----------------------------+


.. _avoid-optional-properties:

Avoid Optional Properties
#########################


Avoid optional properties, to prevent litering the code with existence checks. 

When a property has to be checked once for existence, it is safer to check it each time. This leads to a decrease in readability.

Either make sure the property is set with an actual object rather than with null, or use a void object. A void object offers the same interface than the expected object, but does nothing. It allows calling its methods, without running into a Fatal error, nor testing it. 

.. code-block:: php

   <?php
   
   // Example is courtesy 'The Coding Machine' : it has been adapted from its original form. See link below.
   
   class MyMailer {
       private $logger;
   
       public function '__construct(LoggerInterface $logger = null) {
           $this->logger = $logger;
       }
   
       private function sendMail(Mail $mail) {
           // Since $this->logger may be null, it must be tested anytime it is used.
           if ($this->logger) {
               $this->logger->info('Mail successfully sent.');
           }
       }
   }
   
   ?>


See also `Avoid optional services as much as possible <http://bestpractices.thecodingmachine.com/php/design_beautiful_classes_and_methods.html#avoid-optional-services-as-much-as-possible>`_,
`The Null Object Pattern – Polymorphism in Domain Models <https://www.sitepoint.com/the-null-object-pattern-polymorphism-in-domain-models/>`_, and `Practical PHP Refactoring: Introduce Null Object <https://dzone.com/articles/practical-php-refactoring-26>`_.

+--------------+---------------------------------+
| Command Line | Classes/AvoidOptionalProperties |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`                  |
+--------------+---------------------------------+


.. _avoid-parenthesis:

Avoid Parenthesis
#################


Avoid Parenthesis for language construct. Languages constructs are a few PHP native elements, that looks like functions but are not. 

Among other distinction, those elements cannot be directly used as variable function call, and they may be used with or without parenthesis.

The usage of parenthesis actually give some feeling of confort, it won't prevent PHP from combining those argument with any later operators, leading to unexpected results.

Even if most of the time, usage of parenthesis is legit, it is recommended to avoid them.

+--------------+------------------------------------+
| Command Line | Structures/PrintWithoutParenthesis |
+--------------+------------------------------------+
| Analyzers    | :ref:`Analyze`                     |
+--------------+------------------------------------+


.. _avoid-those-hash-functions:

Avoid Those Hash Functions
##########################


The following cryptographic algorithms are considered unsecure, and should be replaced with new and more performant algorithms. 

MD2, MD4, MD5, SHA0, SHA1, CRC, DES, 3DES, RC2, RC4. 

When possible, avoid using them, may it be as PHP functions, or hashing function configurations (mcrypt, hash...).

.. code-block:: php

   <?php
   
   // Weak cryptographic algorithm
   echo md5('The quick brown fox jumped over the lazy dog.');
   
   // Weak crypotgraphic algorthim, used with a modern PHP extension (easier to update)
   echo hash('md5', 'The quick brown fox jumped over the lazy dog.');
   
   // Strong crypotgraphic algorthim, used with a modern PHP extension
   echo hash('sha156', 'The quick brown fox jumped over the lazy dog.');
   
   ?>


Weak crypto are commonly used for hashing values when caching them. In such cases, security is not a primary concern. However, it may later become such, when hackers get access to the cache folders, or if the cached identifier is published. As a preventive protection, it is recommended to always use a secure hashing function.

See also ` <https://en.wikipedia.org/wiki/Secure_Hash_Algorithms>`_.

+--------------+---------------------------+
| Command Line | Security/AvoidThoseCrypto |
+--------------+---------------------------+
| Analyzers    | :ref:`Security`           |
+--------------+---------------------------+


.. _avoid-using-stdclass:

Avoid Using stdClass
####################


stdClass is the default class for PHP. It is instantiated when PHP needs to return a object, but no class is specifically available.

It is recommended to avoid instantiating this class, nor use it is any way.

.. code-block:: php

   <?php
   
   $json = '{a:1,b:2,c:3}';
   $object = json_decode($json);
   // $object is a stdClass, as returned by json_decode
   
   // Fast building of $o
   $a = [];
   $a['a'] = 1;
   $a['b'] = 2;
   $a['c'] = 3;
   json_encode( (object) $a);
   
   // Slow building of $o
   $o = new stdClass();
   $o->a = 1;
   $o->b = 2;
   $o->c = 3;
   json_encode($o);
   
   ?>


If you need a stdClass object, it is faster to build it as an array, then cast it, than instantiate stdClass. This is a micro-optimisation.

+--------------+-----------------+
| Command Line | Php/UseStdclass |
+--------------+-----------------+
| Analyzers    | :ref:`Analyze`  |
+--------------+-----------------+


.. _avoid-array\_push():

Avoid array_push()
##################


`'array_push() <http://www.php.net/array_push>`_ is slower than the [] operator.

This is also true if the [] operator is called several times, while `'array_push() <http://www.php.net/array_push>`_ may be called only once. 
And using count after the push is also faster than collecting `'array_push() <http://www.php.net/array_push>`_ return value. 

.. code-block:: php

   <?php
   
   $a = [1,2,3];
   // Fast version
   $a[] = 4;
   
   $a[] = 5;
   $a[] = 6;
   $a[] = 7;
   $count = count($a);
   
   // Slow version
   array_push($a, 4);
   $count = array_push($a, 5,6,7);
   
   // Multiple version : 
   $a[] = 1;
   $a[] = 2;
   $a[] = 3;
   array_push($a, 1, 2, 3);
   
   
   ?>


This is a micro-optimisation.

+--------------+-----------------------------+
| Command Line | Performances/AvoidArrayPush |
+--------------+-----------------------------+
| Analyzers    | :ref:`Performances`         |
+--------------+-----------------------------+


.. _avoid-array\_unique():

Avoid array_unique()
####################


The native function `'array_unique() <http://www.php.net/array_unique>`_ is much slower than using other alternative, such as `'array_count_values() <http://www.php.net/array_count_values>`_, `'array_flip() <http://www.php.net/array_flip>`_/`'array_keys() <http://www.php.net/array_keys>`_, or even a `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_ loops. 

.. code-block:: php

   <?php
   
   // using 'array_unique()
   $uniques = array_unique($someValues);
   
   // When values are strings or integers
   $uniques = array_keys(array_count_values($someValues));
   $uniques = array_flip(array_flip($someValues))
   
   //even some loops are faster.
   $uniques = [];
   foreach($someValues as $s) {
       if (!in_array($uniques, $s)) {
           $uniques[] $s;
       }
   }
   
   ?>

+--------------+--------------------------+
| Command Line | Structures/NoArrayUnique |
+--------------+--------------------------+
| Analyzers    | :ref:`Performances`      |
+--------------+--------------------------+


.. _avoid-get\_class():

Avoid get_class()
#################


get_class() should be replaced with the `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ operator to check the class of an object. 

get_class() will only compare the full namespace name of the object's class, while `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ actually resolve the name, using the local namespace and aliases.

.. code-block:: php

   <?php
   
       use Stdclass as baseClass;
       
       function foo($arg) {
           // Slow and prone to namespace errors
           if (get_class($arg) === 'Stdclass') {
               // doSomething()
           }
       }
   
       function bar($arg) {
           // Faster, and uses aliases.
           if ($arg 'instanceof baseClass) {
               // doSomething()
           }
       }
   ?>

+--------------+--------------------------+
| Command Line | Structures/UseInstanceof |
+--------------+--------------------------+
| Analyzers    | none                     |
+--------------+--------------------------+


.. _avoid-sleep()/usleep():

Avoid sleep()/usleep()
######################


`'sleep() <http://www.php.net/sleep>`_ and `'usleep() <http://www.php.net/usleep>`_ help saturate the web server. 

Pausing the script for a specific amount of time means that the Web server is also making all related ressources sleep, such as database, sockets, session, etc. This may used to set up a DOS on the server.  

.. code-block:: php

   <?php
   
   $begin = microtime(true);
   checkLogin($user, $password);
   $end   = microtime(true);
   
   // Making all login checks looks the same
   usleep(1000000 - ($end - $begin) * 1000000); 
   
   // Any hit on this page now uses 1 second, no matter if load is high or not
   // Is it now possible to saturate the webserver in 1 s ? 
   
   ?>


As much as possible, avoid delaying the end of the script. 

`'sleep() <http://www.php.net/sleep>`_ and `'usleep() <http://www.php.net/usleep>`_ have less impact in commandline (CLI).

+--------------+------------------+
| Command Line | Security/NoSleep |
+--------------+------------------+
| Analyzers    | :ref:`Security`  |
+--------------+------------------+


.. _bail-out-early:

Bail Out Early
##############


When using conditions, it is recommended to quit in the current context, and avoid else clause altoghter. 

The main benefit is to make clear the method applies a condition, and stop quickly went it is not satisfied. 
The main sequence is then focused on the useful code. 

This works with the `'break <http://php.net/manual/en/control-structures.break.php>`_, `'continue <http://php.net/manual/en/control-structures.continue.php>`_, throw and goto keywords too, depending on situations.

.. code-block:: php

   <?php
   
   // Bailing out early, low level of indentation
   function foo1($a) {
       if ($a > 0) {
           return false;
       } 
       
       $a++;
       return $a;
   }
   
   // Works with 'continue too
   foreach($array as $a => $b) {
       if ($a > 0) {
           'continue false;
       } 
       
       $a++;
       return $a;
   }
   
   // No need for else
   function foo2($a) {
       if ($a > 0) {
           return false;
       } else {
           $a++;
       }
       
       return $a;
   }
   
   // No need for else : return goes into then. 
   function foo3($a) {
       if ($a < 0) {
           $a++;
       } else {
           return false;
       }
       
       return $a;
   }
   
   ?>

+--------------+-------------------------+
| Command Line | Structures/BailOutEarly |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _binary-glossary:

Binary Glossary
###############


List of all the integer values using the binary format.

.. code-block:: php

   <?php
   
   $a = 0b10;
   $b = 0B0101;
   
   ?>

+--------------+---------------------------+
| Command Line | Type/Binary               |
+--------------+---------------------------+
| Analyzers    | :ref:`CompatibilityPHP53` |
+--------------+---------------------------+


.. _bracketless-blocks:

Bracketless Blocks
##################


PHP allows one liners as `'for() <http://php.net/manual/en/control-structures.for.php>`_, `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_, `'while() <http://php.net/manual/en/control-structures.while.php>`_, `'do..while() <http://php.net/manual/en/control-structures.do.while.php>`_ loops, or as then/else expressions. 

It is generally considered a bad practice, as readability is lower and there are non-négligeable risk of excluding from the loop the next instruction.

.. code-block:: php

   <?php
   
   // Legit one liner
   foreach(range('a', 'z') as $letter) ++$letterCount;
   
   // More readable version, even for a one liner.
   foreach(range('a', 'z') as $letter) {
       ++$letterCount;
   }
   
   ?>


`'switch() <http://php.net/manual/en/control-structures.switch.php>`_ cannot be without bracket.

+--------------+------------------------------------------------+
| Command Line | Structures/Bracketless                         |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _break-outside-loop:

Break Outside Loop
##################


Starting with PHP 7, `'break <http://php.net/manual/en/control-structures.break.php>`_ or `'continue <http://php.net/manual/en/control-structures.continue.php>`_ that are outside a loop (for, `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_, do...`'while() <http://php.net/manual/en/control-structures.while.php>`_, `'while()) <http://php.net/manual/en/control-structures.while.php>`_ or a `'switch() <http://php.net/manual/en/control-structures.switch.php>`_ statement won't compile anymore.

It is not possible anymore to include a piece of code inside a loop that will then `'break <http://php.net/manual/en/control-structures.break.php>`_.

.. code-block:: php

   <?php
   
       // outside a loop : This won't compile
       'break 1; 
       
       foreach($array as $a) {
           'break 1; // Compile OK
   
           'break 2; // This won't compile, as this 'break is in one loop, and not 2
       }
   
       foreach($array as $a) {
           foreach($array2 as $a2) {
               'break 2; // OK in PHP 5 and 7
           }
       }
   ?>

+--------------+----------------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/BreakOutsideLoop                                                                                                |
+--------------+----------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+----------------------------------------------------------------------------------------------------------------------------+


.. _break-with-0:

Break With 0
############


Cannot `'break <http://php.net/manual/en/control-structures.break.php>`_ 0, as this makes no sense. Break 1 is the minimum, and is the default value.

.. code-block:: php

   <?php
       // Can't 'break 0. Must be 1 or more, depending on the level of nesting.
       for($i = 0; $i < 10; $i++) {
           'break 0;
       }
   
       for($i = 0; $i < 10; $i++) {
           for($j = 0; $j < 10; $j++) {
               'break 2;
           }
       }
   
   ?>

+--------------+---------------------------+
| Command Line | Structures/Break0         |
+--------------+---------------------------+
| Analyzers    | :ref:`CompatibilityPHP53` |
+--------------+---------------------------+


.. _break-with-non-integer:

Break With Non Integer
######################


When using a `'break <http://php.net/manual/en/control-structures.break.php>`_, the argument of the operator must be a positive non-null integer literal or be omitted.

Other values were acceptable in PHP 5.3 and previous version, but this is now reported as an error.

.. code-block:: php

   <?php
       // Can't 'break $a, even if it contains an integer.
       $a = 1;
       for($i = 0; $i < 10; $i++) {
           'break $a;
       }
   
       // can't 'break on float
       for($i = 0; $i < 10; $i++) {
           for($j = 0; $j < 10; $j++) {
               'break 2.2;
           }
       }
   
   ?>

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/BreakNonInteger                                                                                                                                                                  |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _buried-assignation:

Buried Assignation
##################


Those assignations are buried in the code, and placed in unexpected situations. They will be difficult to spot, and may be confusing. It is advised to place them in a more visible place.

+--------------+------------------------------+
| Command Line | Structures/BuriedAssignation |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _cakephp-2.5.0-undefined-classes:

CakePHP 2.5.0 Undefined Classes
###############################


CakePHP classes, interfaces and traits that are not defined in version 2.5.0.

+--------------+-------------------+
| Command Line | Cakephp/Cakephp25 |
+--------------+-------------------+
| Analyzers    | :ref:`Cakephp`    |
+--------------+-------------------+


.. _cakephp-2.6.0-undefined-classes:

CakePHP 2.6.0 Undefined Classes
###############################


CakePHP classes, interfaces and traits that are not defined in version 2.6.0.
5 new classes

+--------------+-------------------+
| Command Line | Cakephp/Cakephp26 |
+--------------+-------------------+
| Analyzers    | :ref:`Cakephp`    |
+--------------+-------------------+


.. _cakephp-2.7.0-undefined-classes:

CakePHP 2.7.0 Undefined Classes
###############################


CakePHP classes, interfaces and traits that are not defined in version 2.7.0.
12 new classes 
 
2 removed classes

+--------------+-------------------+
| Command Line | Cakephp/Cakephp27 |
+--------------+-------------------+
| Analyzers    | :ref:`Cakephp`    |
+--------------+-------------------+


.. _cakephp-2.8.0-undefined-classes:

CakePHP 2.8.0 Undefined Classes
###############################


CakePHP classes, interfaces and traits that are not defined in version 2.8.0.
8 new classes

+--------------+-------------------+
| Command Line | Cakephp/Cakephp28 |
+--------------+-------------------+
| Analyzers    | :ref:`Cakephp`    |
+--------------+-------------------+


.. _cakephp-2.9.0-undefined-classes:

CakePHP 2.9.0 Undefined Classes
###############################


CakePHP classes, interfaces and traits that are not defined in version 2.9.0.
16 new classes 
 
2 removed classes

+--------------+-------------------+
| Command Line | Cakephp/Cakephp29 |
+--------------+-------------------+
| Analyzers    | :ref:`Cakephp`    |
+--------------+-------------------+


.. _cakephp-3.0-deprecated-class:

CakePHP 3.0 Deprecated Class
############################


According to the `Cake 3.0 migration guide <http://book.cakephp.org/3.0/en/appendices/3-0-migration-guide.html>`_, the following class is deprecated and should be removed.

* Set (Cake\Utility\Set) : replace it with Hash (Cake\Utility\Hash)

+--------------+-------------------------------+
| Command Line | Cakephp/Cake30DeprecatedClass |
+--------------+-------------------------------+
| Analyzers    | :ref:`Cakephp`                |
+--------------+-------------------------------+


.. _cakephp-3.0.0-undefined-classes:

CakePHP 3.0.0 Undefined Classes
###############################


CakePHP classes, interfaces and traits that are not defined in version 3.0.0.
754 new classes 
13 new interfaces 
34 new traits 
 
1062 removed classes 
7 removed interfaces

+--------------+-------------------+
| Command Line | Cakephp/Cakephp30 |
+--------------+-------------------+
| Analyzers    | :ref:`Cakephp`    |
+--------------+-------------------+


.. _cakephp-3.1.0-undefined-classes:

CakePHP 3.1.0 Undefined Classes
###############################


CakePHP classes, interfaces and traits that are not defined in version 3.1.0.
64 new classes 
5 new interfaces 
5 new traits 
 
16 removed classes

+--------------+-------------------+
| Command Line | Cakephp/Cakephp31 |
+--------------+-------------------+
| Analyzers    | :ref:`Cakephp`    |
+--------------+-------------------+


.. _cakephp-3.2.0-undefined-classes:

CakePHP 3.2.0 Undefined Classes
###############################


CakePHP classes, interfaces and traits that are not defined in version 3.2.0.
27 new classes 
4 new interfaces 
4 new traits 
 
1 removed classe

+--------------+-------------------+
| Command Line | Cakephp/Cakephp32 |
+--------------+-------------------+
| Analyzers    | :ref:`Cakephp`    |
+--------------+-------------------+


.. _cakephp-3.3-deprecated-class:

CakePHP 3.3 Deprecated Class
############################


According to the `Cake 3.3 migration guide <http://book.cakephp.org/3.0/en/appendices/3-3-migration-guide.html>`_, the following class is deprecated and should be removed.

* Mcrypt (Cake\Utility\Crypto\Mcrypt) : replace it with Cake\Utility\Crypto\Openssl or ext/openssl

+--------------+-------------------------------+
| Command Line | Cakephp/Cake33DeprecatedClass |
+--------------+-------------------------------+
| Analyzers    | :ref:`Cakephp`                |
+--------------+-------------------------------+


.. _cakephp-3.3.0-undefined-classes:

CakePHP 3.3.0 Undefined Classes
###############################


CakePHP classes, interfaces and traits that are not defined in version 3.3.0.
93 new classes 
5 new interfaces 
1 new trait 
 
19 removed classes 
1 removed interface

+--------------+-------------------+
| Command Line | Cakephp/Cakephp33 |
+--------------+-------------------+
| Analyzers    | :ref:`Cakephp`    |
+--------------+-------------------+


.. _cakephp-3.4.0-undefined-classes:

CakePHP 3.4.0 Undefined Classes
###############################


CakePHP classes, interfaces and traits that are not defined in version 3.4.0.
41 new classes 
1 new interface 
1 new trait 
 
16 removed classes 
2 removed traits

+--------------+-------------------+
| Command Line | Cakephp/Cakephp34 |
+--------------+-------------------+
| Analyzers    | :ref:`Cakephp`    |
+--------------+-------------------+


.. _cakephp-used:

CakePHP Used
############


CakePHP classes, interfaces and traits being used in the code.

.. code-block:: php

   <?php
   
   namespace App\Controller;
   
   use Cake\Controller\Controller;
   
   class AppController extends Controller
   {
   
       public function initialize()
       {
           // Always enable the CSRF component.
           $this->loadComponent('Csrf');
       }
   
   }
   
   ?>


See also `CakePHP <https://www.cakephp.org/>`_.

+--------------+---------------------+
| Command Line | Cakephp/CakePHPUsed |
+--------------+---------------------+
| Analyzers    | :ref:`Cakephp`      |
+--------------+---------------------+


.. _calltime-pass-by-reference:

Calltime Pass By Reference
##########################


PHP doesn't allow when a value is turned into a reference at functioncall, since PHP 5.4. 

Either the function use a reference in its signature, either the reference won't pass.

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/CalltimePassByReference                                                                                                                                                          |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _can't-extend-final:

Can't Extend Final
##################


It is not possible to extend final classes. 

Since PHP fails with a fatal error, this means that the extending class is probably not used in the rest of the code. Check for dead code.

.. code-block:: php

   <?php
       // File Foo
       final class foo {
           public final function bar() {
               // doSomething
           }
       }
   ?>


In a separate file : 

.. code-block:: php

   <?php
       // File Bar
       class bar extends foo {
       
       }
   ?>

+--------------+----------------------------------------------+
| Command Line | Classes/CantExtendFinal                      |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>` |
+--------------+----------------------------------------------+


.. _cant-inherit-abstract-method:

Cant Inherit Abstract Method
############################


Inheriting abstract methods was made available in PHP 7.2. In previous versions, it emits a Fatal error.

.. code-block:: php

   <?php
   
   abstract class A           { abstract function bar(stdClass $x);  }
   abstract class B extends A { abstract function bar($x): stdClass; }
   
   //   Fatal error: Can't inherit abstract function A::bar()
   ?>


See also `PHP RFC: Allow abstract function override <https://wiki.php.net/rfc/allow-abstract-function-override>`_.

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Classes/CantInheritAbstractMethod                                                                                                                                |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _cant-use-return-value-in-write-context:

Cant Use Return Value In Write Context
######################################


Until PHP 5.5, it was not possible to use directly function calls inside an `'empty() <http://www.php.net/empty>`_ function call : they were met with a 'Can't use function return value in write context' fatal error. 

.. code-block:: php

   <?php
   
   function foo($boolean) {
       return $boolean;
   }
   
   // Valid since PHP 5.5
   echo empty(foo(true)) : 'true' : 'false';
   
   ?>


This also applies to methodcalls, static or not.

+--------------+------------------------------------------------------+
| Command Line | Php/CantUseReturnValueInWriteContext                 |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54` |
+--------------+------------------------------------------------------+


.. _cast-to-boolean:

Cast To Boolean
###############


This expression may be reduced by casting to boolean type.

.. code-block:: php

   <?php
   
   $variable = $condition == 'met' ? 1 : 0;
   // Same as 
   $variable = (bool) $condition == 'met';
   
   $variable = $condition == 'met' ? 0 : 1;
   // Same as (Note the condition inversion)
   $variable = (bool) $condition != 'met';
   // also, with an indentical condition
   $variable = !(bool) $condition == 'met';
   
   
   
   ?>

+--------------+--------------------------+
| Command Line | Structures/CastToBoolean |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _catch-overwrite-variable:

Catch Overwrite Variable
########################


The try...catch structure uses some variables that also in use in this scope. In case of a caught exception, the exception will be put in the catch variable, and overwrite the current value, loosing some data.

It is recommended to use another name for these catch variables.

+--------------+-----------------------------------------------------------------------------------------------------+
| Command Line | Structures/CatchShadowsVariable                                                                     |
+--------------+-----------------------------------------------------------------------------------------------------+
| clearPHP     | `no-catch-overwrite <https://github.com/dseguy/clearPHP/tree/master/rules/no-catch-overwrite.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                      |
+--------------+-----------------------------------------------------------------------------------------------------+


.. _check-all-types:

Check All Types
###############


When checking for time, avoid using else. Mention explicitely all tested type, and raise an exception when reaching else.

PHP has a short list of scalar types : null, boolean, integer, real, strings, object, resource and array. When a variable is not holding one the the type, then it may be of any other type. 

Most of the time, when using a simple is_*() / else test, this is relying on the conception of the code. By construction, the arguments may be one of two types : array or string. 

What happens often is that in case of failure in the code (database not working, another class not checking its results), a third type is pushed to the structure, and it ends up breaking the execution. 

The safe way is to check the various types all the time, and use the default case (here, the else) to throw exception() or test an assertion and handle the special case.

.. code-block:: php

   <?php
   
   // hasty version
   if (is_array($argument)) {
       $out = $argument;
   } else {
       // Here, $argument is NOT an array. What if it is an object ? or a NULL ? 
       $out = array($argument);
   }
   
   // Safe type checking : do not assume that 'not an array' means that it is the other expected type.
   if (is_array($argument)) {
       $out = $argument;
   } elseif (is_string($argument)) {
       $out = array($argument);
   } else {
       assert(false, '$argument is not an array nor a string, as expected!');
   }
   
   ?>


Using `'is_callable() <http://www.php.net/is_callable>`_, is_iterable() with this structure is fine : when variable is callable or not, while a variable is an integer or else. 

Using a type test without else is also accepted here. This is a special treatment for this test, and all others are ignored. This aspect may vary depending on situations and projects.

+--------------+--------------------------+
| Command Line | Structures/CheckAllTypes |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _class-const-with-array:

Class Const With Array
######################


Constant defined with const keyword may be arrays but only stating with PHP 5.6. Define never accept arrays : it only accepts scalar values.

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/ClassConstWithArray                                                         |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55` |
+--------------+---------------------------------------------------------------------------------+


.. _class-function-confusion:

Class Function Confusion
########################


Avoid classes and functions bearing the same name. 

When functions and classes bear the same name, calling them may be confusing. This may also lead to forgotten 'new' keyword.

.. code-block:: php

   <?php
   
   class foo {}
   
   function foo() {}
   
   // Forgetting the 'new' operator is easy
   $object = new foo();
   $object = foo();
   
   ?>

+--------------+----------------------------+
| Command Line | Php/ClassFunctionConfusion |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _class-name-case-difference:

Class Name Case Difference
##########################


The spotted classes are used with a different case than their definition. While PHP accepts this, it makes the code harder to read. 

It may also be a violation of coding conventions.

.. code-block:: php

   <?php
   
   // This use statement has wrong case for origin.
   use Foo as X;
   
   // Definition of the class
   class foo {}
   
   // Those instantiations have wrong case
   new FOO();
   new X();
   
   ?>


See also `PHP class name constant case sensitivity and PSR-11 <https://gist.github.com/bcremer/9e8d6903ae38a25784fb1985967c6056>`_.

+--------------+----------------------------------------------------------------+
| Command Line | Classes/WrongCase                                              |
+--------------+----------------------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>`, :ref:`Analyze` |
+--------------+----------------------------------------------------------------+


.. _class-should-be-final-by-ocramius:

Class Should Be Final By Ocramius
#################################


'Make your classes always final, if they implement an interface, and no other public methods are defined'.

When a class should be final, as explained by Ocramiux (Marco Pivetta).

Full article : `When to declare classes final <http://ocramius.github.io/blog/when-to-declare-classes-final/>`_.

.. code-block:: php

   <?php
   
   interface i1 {
       function i1() ;
   }
   
   // Class should final, as its public methods are in an interface
   class finalClass implements i1 {
       // public interface 
       function i1 () {}
       
       // private method
       private function a1 () {}
   }
   
   ?>

+--------------+-------------------------+
| Command Line | Classes/FinalByOcramius |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _class,-interface-or-trait-with-identical-names:

Class, Interface Or Trait With Identical Names
##############################################


The following names are used at the same time for classes, interfaces or traits. For example, 

class a {}
interface a {}
trait a {}

Even if they are in different namespaces, this makes them easy to confuse. Besides, it is recommended to have markers to differentiate classes from interfaces from traits.

+--------------+---------------------+
| Command Line | Classes/CitSameName |
+--------------+---------------------+
| Analyzers    | :ref:`Analyze`      |
+--------------+---------------------+


.. _classes-mutually-extending-each-other:

Classes Mutually Extending Each Other
#####################################


Those classes are extending each other, creating an extension loop. PHP will yield a fatal error at running time, even if it is compiling the code.

.. code-block:: php

   <?php
   
   // This code is lintable but won't run
   class Foo extends Bar { }
   class Bar extends Foo { }
   
   // The loop may be quite large
   class Foo extends Bar { }
   class Bar extends Bar2 { }
   class Bar2 extends Foo { }
   
   ?>

+--------------+-------------------------+
| Command Line | Classes/MutualExtension |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _close-tags:

Close Tags
##########


PHP manual recommends that script should be left open, without the final closing ?>. This way, one will avoid the infamous bug 'Header already sent', associated with left-over spaces, that are lying after this closing tag.

+--------------+-------------------------------------------------------------------------------------------------------------+
| Command Line | Php/CloseTags                                                                                               |
+--------------+-------------------------------------------------------------------------------------------------------------+
| clearPHP     | `leave-last-closing-out <https://github.com/dseguy/clearPHP/tree/master/rules/leave-last-closing-out.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>`                                                              |
+--------------+-------------------------------------------------------------------------------------------------------------+


.. _closure-may-use-$this:

Closure May Use $this
#####################


When closure were introduced in PHP, they couldn't use the $this variable, making is cumbersome to access local properties when the closure was created within an object. 

This is not the case anymore since PHP 5.4.

+--------------+---------------------------+
| Command Line | Php/ClosureThisSupport    |
+--------------+---------------------------+
| Analyzers    | :ref:`CompatibilityPHP53` |
+--------------+---------------------------+


.. _common-alternatives:

Common Alternatives
###################


In the following conditional structures, expressions were found that are common to both 'then' and 'else'. It may be interesting, though not always possible, to put them both out of the conditional, and reduce line count. 

.. code-block:: php

   <?php
   if ($c == 5) {
       $b = strtolower($b[2]); 
       $a++;
   } else {
       $b = strtolower($b[2]); 
       $b++;
   }
   ?>


may be rewritten in : 

.. code-block:: php

   <?php
   
   $b = strtolower($b[2]); 
   if ($c == 5) {
       $a++;
   } else {
       $b++;
   }
   
   ?>

+--------------+-------------------------------+
| Command Line | Structures/CommonAlternatives |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _compare-hash:

Compare Hash
############


When comparing hash values, it is important to use the strict comparison : === or !==. 

In a number of situations, the hash value will start with '0e', and PHP will understand that the comparison involves integers : it will then convert the strings into numbers, and it may end up converting them to 0.

Here is an example 

.. code-block:: php

   <?php
   
   // The two following passwords hashes matches, while they are not the same. 
   $hashed_password = 0e462097431906509000000000000;
   if (hash('md5','240610708',false) == $hashed_password) {
     print Matched.\n;
   }
   ?>


You may also use `'password_hash() <http://www.php.net/password_hash>`_ and `'password_verify() <http://www.php.net/password_verify>`_. 

See also `Magic Hashes <https://blog.whitehatsec.com/magic-hashes/>`_.

+--------------+-----------------------------------------------------------------------------------------------------+
| Command Line | Security/CompareHash                                                                                |
+--------------+-----------------------------------------------------------------------------------------------------+
| clearPHP     | `strict-comparisons <https://github.com/dseguy/clearPHP/tree/master/rules/strict-comparisons.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Security`                                                                                     |
+--------------+-----------------------------------------------------------------------------------------------------+


.. _compared-comparison:

Compared Comparison
###################


Usually, comparison are sufficient, and it is rare to have to compare the result of comparison. Check if this two-stage comparison is really needed.

+--------------+-------------------------------+
| Command Line | Structures/ComparedComparison |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _concrete-visibility:

Concrete Visibility
###################


Methods that implements an interface in a class must be public. 

PHP doesn't lint this, but won't start a script with a Fatal error : 'Access level to c::iPrivate() must be public (as in class i) ';

.. code-block:: php

   <?php
   
   interface i {
       function iPrivate() ;
       function iProtected() ;
       function iPublic() ;
   }
   
   class c implements i {
       // Methods that implements an interface in a class must be public.  
       private function iPrivate() {}
       protected function iProtected() {}
       public function iPublic() {}
   }
   
   ?>


See also `Interfaces <http://php.net/manual/en/language.oop5.interfaces.php>`_.

+--------------+-------------------------------+
| Command Line | Interfaces/ConcreteVisibility |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _confusing-names:

Confusing Names
###############


The following variables's name are very close and may lead to confusion.

Variables are 3 letters long (at least). Variables names build with an extra 's' are omitted.
Variables may be scattered across the code, or close to each other. 

.. code-block:: php

   <?php
   
       // Variable names with one letter difference
       $fWScale = 1;
       $fHScale = 1;
       $fScale = 2;
       
       $oFrame = 3;
       $iFrame = new Foo();
       
       $v2_norm = array();
       $v1_norm = 'string';
       
       $exept11 = 1;
       $exept10 = 2;
       $exept8 = 3;
       
       // This even looks like a typo
       $privileges  = 1;
       $privilieges = true;
       
       // This is not reported : Adding extra s is tolerated.
       $rows[] = $row;
       
   ?>

+--------------+-----------------------+
| Command Line | Variables/CloseNaming |
+--------------+-----------------------+
| Analyzers    | :ref:`Analyze`        |
+--------------+-----------------------+


.. _const-with-array:

Const With Array
################


The const keyword supports array since PHP 5.6.

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/ConstWithArray                                                              |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55` |
+--------------+---------------------------------------------------------------------------------+


.. _constant-class:

Constant Class
##############


A class or an interface only made up of constants. Constants usually have to be used in conjunction of some behavior (methods, class...) and never alone. 

As such, they should be PHP constants (build with define or const), or included in a class with other methods and properties.

+--------------+-----------------------+
| Command Line | Classes/ConstantClass |
+--------------+-----------------------+
| Analyzers    | :ref:`Analyze`        |
+--------------+-----------------------+


.. _constant-comparison:

Constant Comparison
###################


Constant to the left or right is a favorite. 

Comparisons are commutative : they may be $a == B or B == $a. The analyzed code show less than 10% of one of the two : for consistency reasons, it is recommended to make them all the same. 

Putting the constant on the left is also called 'Yoda Comparison', as it mimics the famous characters style of speech. It prevents errors like 'B = $a' where the comparison is turned into an assignation. 

The natural way is to put the constant on the right. It is often less surprising. 

Every comparison operator is used when finding the favorite.

.. code-block:: php

   <?php
   
   // 
   if ($a === B) { doSomething(); }
   if ($c > D) { doSomething(); }
   if ($e !== G) { doSomething(); }
   do { doSomething(); } while ($f === B);
   while ($a === B) { doSomething(); }
   
   // be consistent
   if (B === $a) {}
   
   // Compari
   if (B <= $a) {}
   
   ?>

+--------------+------------------------------------------------+
| Command Line | Structures/ConstantComparisonConsistance       |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _constant-scalar-expressions:

Constant Scalar Expressions
###########################


Starting with PHP 5.6, it is possible to define constant that are the result of expressions.

Those expressions (using simple operators) may only manipulate other constants, and all values must be known at compile time. 

This is not compatible with previous versions.

+--------------+---------------------------------------------------------------------------------+
| Command Line | Structures/ConstantScalarExpression                                             |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55` |
+--------------+---------------------------------------------------------------------------------+


.. _constants-created-outside-its-namespace:

Constants Created Outside Its Namespace
#######################################


Constants Created Outside Its Namespace.

Using the `'define() <http://www.php.net/define>`_ function, it is possible to create constant outside their namespace, but using the fully qualified namespace.

.. code-block:: php

   <?php
   
   namespace A\B {
       // define A\B\C as 1
       define('C', 1);
   }
   
   namespace D\E {
       // define A\B\C as 1, while outside the A\B namespace
       define('A\B\C', 1);
   }
   
   ?>


However, this makes the code confusing and difficult to debug. It is recommended to move the constant definition to its namespace.

+--------------+--------------------------------------+
| Command Line | Constants/CreatedOutsideItsNamespace |
+--------------+--------------------------------------+
| Analyzers    | :ref:`Analyze`                       |
+--------------+--------------------------------------+


.. _constants-with-strange-names:

Constants With Strange Names
############################


List of constants being defined with names that are incompatible with PHP standards. 

.. code-block:: php

   <?php
   
   // Define a valid PHP constant
   define('ABC', 1); 
   const ABCD = 2; 
   
   // Define an invalid PHP constant
   define('ABC!', 1); 
   echo defined('ABC!') ? constant('ABC!') : 'Undefined';
   
   // Const doesn't allow illegal names
   
   ?>

+--------------+--------------------------------+
| Command Line | Constants/ConstantStrangeNames |
+--------------+--------------------------------+
| Analyzers    | :ref:`Analyze`                 |
+--------------+--------------------------------+


.. _could-be-class-constant:

Could Be Class Constant
#######################


When a property is defined and read, but never modified, it may be a constant. 

.. code-block:: php

   <?php
   
   class foo {
       // $this->bar is never modified. 
       private $bar = 1;
       
       // $this->foofoo is modified, at least once
       private $foofoo = 2;
       
       function method($a) {
           $this->foofoo = $this->bar + $a + $this->foofoo;
           
           return $this->foofoo;
       }
       
   }
   
   ?>


Starting with PHP 5.6, even array() may be defined as constants.

+--------------+------------------------------+
| Command Line | Classes/CouldBeClassConstant |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _could-be-protected-property:

Could Be Protected Property
###########################


Those properties are declared public, but are never used publicly. They may be made protected. 

.. code-block:: php

   <?php
   
   class foo {
       // Public, and used publicly
       public $publicProperty;
       // Public, but never used outside the class or its children
       public $protectedProperty;
       
       function bar() {
           $this->protectedProperty = 1;
       }
   }
   
   $foo = new Foo();
   $foo->publicProperty = 3;
   
   ?>


This property may even be made private.

+--------------+----------------------------------+
| Command Line | Classes/CouldBeProtectedProperty |
+--------------+----------------------------------+
| Analyzers    | :ref:`Analyze`                   |
+--------------+----------------------------------+


.. _could-be-static:

Could Be Static
###############


This global is only used in one function or method. It may be called 'static', instead of global. This allows you to keep the value between call to the function, but will not be accessible outside this function.

.. code-block:: php

   <?php
   function foo( ) {
       static $variableIsReservedForX; // only accessible within foo( ), even between calls.
       global $variableIsGlobal;       //      accessible everywhere in the application
   }
   ?>

+--------------+--------------------------+
| Command Line | Structures/CouldBeStatic |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _could-be-typehinted-callable:

Could Be Typehinted Callable
############################


Those arguments may use the callable Typehint. 

'callable' is a PHP keyword that represents callback functions. Those may be used in dynamic function call, like $function(); or as callback functions, like with `'array_map() <http://www.php.net/array_map>`_;

callable may be a string representing a function name or a static call (including ::), an array with two elements, (a class or object, and a method), or a closure.

When arguments are used to call a function, but are not marked with 'callable', they are reported by this analysis.

.. code-block:: php

   <?php
   
   function foo(callable $callable) {
       // very simple callback
       return $callable();
   }
   
   function foo2($array, $callable) {
       // very simple callback
       return array_map($array, $callable);
   }
   
   ?>


See also `Callback / callable <http://php.net/manual/en/language.types.callable.php>`_.

+--------------+---------------------------+
| Command Line | Functions/CouldBeCallable |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _could-make-a-function:

Could Make A Function
#####################


When a function is called across the code with the same arguments often enough, it should be turned into a local API. 

This approach is similar to turning literals into constants : it centralize the value, it helps refactoring by updating it. It also makes the code more readable. Moreover, it often highlight common grounds between remote code locations. 

The analysis looks for functions calls, and checks the arguments. When the calls occurs more than 4 times, it is reported. 

.. code-block:: php

   <?php
   
   // str_replace is used to clean '&' from strings. 
   // It should be upgraded to a central function
   function foo($arg ) {
       $arg = str_replace('&', '', $arg);
       // do something with $arg
   }
   
   class y {
       function bar($database ) {
           $value = $database->queryName();
           $value = str_replace('&', '', $value);
           // $value = removeAmpersand($value);
           // do something with $arg2
       }
   }
   
   // helper function
   function removeAmpersand($string) {
       return str_replace('&', '', $string);
   }
   
   ?>

+--------------+---------------------------+
| Command Line | Functions/CouldCentralize |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _could-typehint:

Could Typehint
##############


Arguments that are tested with `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ gain from making it a Typehint.

.. code-block:: php

   <?php
   
   function foo($a, $b) {
       // $a is tested for B with 'instanceof. 
       if (!$a 'instanceof B) {
           return;
       }
       
       // More code
   }
   
   function foo(B $a, $b) {
       // May omit the initial test
       
       // More code
   }
   
   ?>

+--------------+-------------------------+
| Command Line | Functions/CouldTypehint |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _could-use-alias:

Could Use Alias
###############


This long name may be reduced by using an available alias.

.. code-block:: php

   <?php
   
   use a\b\c;
   
   // This may be reduced with the above alias
   new a\b\c\d();
   
   // This too
   new a\b\c\d\e\f();
   
   // This yet again
   new a\b\c();
   
   ?>

+--------------+--------------------------+
| Command Line | Namespaces/CouldUseAlias |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _could-use-short-assignation:

Could Use Short Assignation
###########################


Some operators have a compact 'do-and-assign' version.

They looks like a compacted version for = and the operator. This syntax is good for readability, and saves some memory in the process. 

.. code-block:: php

   <?php
   
   $a = $a + 0;
   $a += 0;
   
   $b = $b - 1;
   $b -= 1;
   
   $c = $c * 2;
   $c *= 2;
   
   $d = $d / 3;
   $d /= 3;
   
   $e = $e % 4;
   $e %= 4;
   
   $f = $f | 5;
   $f |= 5;
   
   $g = $g & 6;
   $g &= 6;
   
   $h = $h ^ 7;
   $h ^= 7;
   
   $i = $i >> 8;
   $i >>= 8;
   
   $j = $j << 9;
   $j <<= 9;
   
   ?>

+--------------+-------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/CouldUseShortAssignation                                                                         |
+--------------+-------------------------------------------------------------------------------------------------------------+
| clearPHP     | `use-short-assignations <https://github.com/dseguy/clearPHP/tree/master/rules/use-short-assignations.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Performances`                                                                         |
+--------------+-------------------------------------------------------------------------------------------------------------+


.. _could-use-\_\_dir\_\_:

Could Use __DIR__
#################


Use `'__DIR__ <http://php.net/manual/en/language.constants.predefined.php>`_ function to access the current file's parent directory. 

.. code-block:: php

   <?php
   
   assert(dirname('__FILE__) == '__DIR__);
   
   ?>


`'__DIR__ <http://php.net/manual/en/language.constants.predefined.php>`_ has been introduced in PHP 5.3.0.

+--------------+------------------------+
| Command Line | Structures/CouldUseDir |
+--------------+------------------------+
| Analyzers    | :ref:`Analyze`         |
+--------------+------------------------+


.. _could-use-self:

Could Use self
##############


'self' keyword refers to the current class, or any of its parents. Using it is just as fast as the full classname, it is as readable and it is will not be changed upon class or namespace change.

It is also routinely used in traits : there, 'self' represents the class in which the trait is used, or the trait itself. 

.. code-block:: php

   <?php
   
   class x {
       const FOO = 1;
       
       public function bar() {
           return self::FOO;
   // same as return x::FOO;
       }
   }
   
   ?>

+--------------+-----------------------+
| Command Line | Classes/ShouldUseSelf |
+--------------+-----------------------+
| Analyzers    | :ref:`Analyze`        |
+--------------+-----------------------+


.. _could-use-str\_repeat():

Could Use str_repeat()
######################


Use `'str_repeat() <http://www.php.net/str_repeat>`_ or `'str_pad() <http://www.php.net/str_pad>`_ instead of making a loop.

Making a loop to repeat the same concatenation is actually much longer than using str_repeat. As soon as the loop repeats more than twice, `'str_repeat() <http://www.php.net/str_repeat>`_ is much faster. With arrays of 30, the difference is significative, though the whole operation is short by itself. 

.. code-block:: php

   <?php
   
   // This adds 7 'e' to $x
   $x .= str_repeat('e', 7);
   
   // This is the same as above, 
   for($a = 3; $a < 10; ++$a) {
       $x .= 'e';
   }
   
   // here, $default must contains 7 elements to be equivalent to the previous code
   foreach($default as $c) {
       $x .= 'e';
   }
   
   ?>

+--------------+------------------------------+
| Command Line | Structures/CouldUseStrrepeat |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _crc32()-might-be-negative:

Crc32() Might Be Negative
#########################


`'crc32() <http://www.php.net/crc32>`_ may return a negative number, on 32bits platforms.

According to the manual : Because PHP\'s integer type is signed many crc32 checksums will result in negative integers on 32bit platforms. On 64bit installations all `'crc32() <http://www.php.net/crc32>`_ results will be positive integers though.

.. code-block:: php

   <?php
   
   // display the checksum with %u, to make it unsigned
   echo sprintf('%u', crc32($str));
   
   // turn the checksum into an unsigned hexadecimal
   echo dechex(crc32($str));
   
   // avoid concatenating crc32 to a string, as it may be negative on 32bits platforms 
   echo 'prefix'.crc32($str);
   
   ?>


See also `crc32() <http://php.net/crc32>`_.

+--------------+--------------------------+
| Command Line | Php/Crc32MightBeNegative |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _curly-arrays:

Curly Arrays
############


It is possible to access individual elements in an array by using its offset between square brackets [] or curly brackets {}. 

Curly brackets are seldom used, and will probably confuse or surprise the reader. It is recommended not to used them.

+--------------+------------------------------------------------+
| Command Line | Arrays/CurlyArrays                             |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _dangling-array-references:

Dangling Array References
#########################


Always unset a referenced-variable used in a loop.

It is highly recommended to unset blind variables when they are set up as references after a loop. 

.. code-block:: php

   <?php
   
   $array = array(1,2,3,4);
   
   foreach($array as &$a) {
       $a += 1;
   }
   // This only unset the reference, not the value
   unset($a);
   
   
   
   
   // Dangling array problem
   foreach($array as &$a) {
       $a += 1;
   }
   //$array === array(3,4,5,6);
   
   // This does nothing (apparently)
   foreach($array as $a) {}
   //$array === array(3,4,5,6);
   
   ?>


When omitting this step, the next loop that will also require this variable will deal with garbage values, and produce unexpected results.

See also : `No Dangling Reference <https://github.com/dseguy/clearPHP/blob/master/rules/no-dangling-reference.md>`_.

+--------------+-----------------------------------------------------------------------------------------------------------+
| Command Line | Structures/DanglingArrayReferences                                                                        |
+--------------+-----------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-dangling-reference <https://github.com/dseguy/clearPHP/tree/master/rules/no-dangling-reference.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                            |
+--------------+-----------------------------------------------------------------------------------------------------------+


.. _deep-definitions:

Deep Definitions
################


Structures, such as functions, classes, interfaces, traits, etc. may be defined anywhere in the code, including inside functions. This is legit code for PHP. 

Since the availability of __autoload, there is no need for that kind of code. Structures should be defined, and accessible to the autoloading. Inclusion and deep definitions should be avoided, as they compell code to load some definitions, while autoloading will only load them if needed. 

Functions are excluded from autoload, but shall be gathered in libraries, and not hidden inside other code.

Constants definitions are tolerated inside functions : they may be used for avoiding repeat, or noting the usage of such function.

+--------------+---------------------------+
| Command Line | Functions/DeepDefinitions |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _define-with-array:

Define With Array
#################


PHP 7.0 has the ability to define an array as a constant, using the `'define() <http://www.php.net/define>`_ native call. This was not possible until that version, only with the const keyword.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/DefineWithArray                                                                                        |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _dependant-trait:

Dependant Trait
###############


Traits should be autonomous. It is recommended to avoid depending on methods or properties that should be in the using class.

The following traits make usage of methods and properties, static or not, that are not defined in the trait. This means the host class must provide those methods and properties, but there is no way to enforce this. 

This may also lead to dead code : when the trait is removed, the host class have unused properties and methods.

.. code-block:: php

   <?php
   
   // autonomous trait : all it needs is within the trait
   trait t {
       private $p = 0;
       
       function foo() {
           return ++$this->p;
       }
   }
   
   // dependant trait : the host class needs to provide some properties or methods
   trait t2 {
       function foo() {
           return ++$this->p;
       }
   }
   
   class x {
       use t2;
       
       private $p = 0;
   }
   ?>

+--------------+-----------------------+
| Command Line | Traits/DependantTrait |
+--------------+-----------------------+
| Analyzers    | :ref:`Analyze`        |
+--------------+-----------------------+


.. _deprecated-code:

Deprecated Code
###############


The following functions have been deprecated in PHP. Whatever the version you are using, it is recommended to stop using them and replace them with a durable equivalent.

+--------------+-------------------------------------------------------------------------------------------+
| Command Line | Php/Deprecated                                                                            |
+--------------+-------------------------------------------------------------------------------------------+
| clearPHP     | `no-deprecated <https://github.com/dseguy/clearPHP/tree/master/rules/no-deprecated.md>`__ |
+--------------+-------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                            |
+--------------+-------------------------------------------------------------------------------------------+


.. _deprecated-methodcalls-in-cake-3.2:

Deprecated Methodcalls in Cake 3.2
##################################


According to the `Cake 3.2 migration guide <http://book.cakephp.org/3.0/en/appendices/3-2-migration-guide.html>`_, the following are deprecated and should be changed.

* Shell::error()
* Cake\Database\Expression\QueryExpression::type()
* Cake\ORM\ResultSet::_calculateTypeMap()                 
* Cake\ORM\ResultSet::_castValues()

+--------------+---------------------------------+
| Command Line | Cakephp/Cake32DeprecatedMethods |
+--------------+---------------------------------+
| Analyzers    | :ref:`Cakephp`                  |
+--------------+---------------------------------+


.. _deprecated-methodcalls-in-cake-3.3:

Deprecated Methodcalls in Cake 3.3
##################################


According to the `Cake 3.3 migration guide <http://book.cakephp.org/3.0/en/appendices/3-3-migration-guide.html>`_, the following are deprecated and should be changed.

* Shell::error()

+--------------+---------------------------------+
| Command Line | Cakephp/Cake33DeprecatedMethods |
+--------------+---------------------------------+
| Analyzers    | :ref:`Cakephp`                  |
+--------------+---------------------------------+


.. _deprecated-static-calls-in-cake-3.3:

Deprecated Static calls in Cake 3.3
###################################


According to the `Cake 3.3 migration guide <http://book.cakephp.org/3.0/en/appendices/3-3-migration-guide.html>`_, the following are deprecated and should be changed.

* Router::mapResources() is deprecated. Use routing scopes and $routes->resources() instead.
* Router::redirect() is deprecated. Use routing scopes and $routes->redirect() instead.

+--------------+------------------------------------------+
| Command Line | Cakephp/Cake33DeprecatedStaticmethodcall |
+--------------+------------------------------------------+
| Analyzers    | :ref:`Cakephp`                           |
+--------------+------------------------------------------+


.. _deprecated-trait-in-cake-3.3:

Deprecated Trait in Cake 3.3
############################


According to the `Cake 3.3 migration guide <http://book.cakephp.org/3.0/en/appendices/3-3-migration-guide.html>`_, the following are deprecated and should be changed.

* Cake\Routing\RequestActionTrait

+--------------+--------------------------------+
| Command Line | Cakephp/Cake33DeprecatedTraits |
+--------------+--------------------------------+
| Analyzers    | :ref:`Cakephp`                 |
+--------------+--------------------------------+


.. _dereferencing-string-and-arrays:

Dereferencing String And Arrays
###############################


PHP 5.5 introduced the direct dereferencing of strings and array. No need anymore for an intermediate variable between a string and array (or any expression generating such value) and accessing an index.

$x = array(4,5,6); 
$y = $x[2] ; // is 6

May be replaced by 
$y = array(4,5,6)[2];
$y = [4,5,6][2];

+--------------+------------------------------------------------------+
| Command Line | Structures/DereferencingAS                           |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54` |
+--------------+------------------------------------------------------+


.. _direct-injection:

Direct Injection
################


The following code act directly upon PHP incoming variables like $_GET and $_POST. This make those snippet very unsafe.

+--------------+--------------------------+
| Command Line | Security/DirectInjection |
+--------------+--------------------------+
| Analyzers    | :ref:`Security`          |
+--------------+--------------------------+


.. _don't-change-incomings:

Don't Change Incomings
######################


PHP hands over a lot of information using special variables like $_GET, $_POST, etc... Modifying those variables and those values inside de variables means that the original content is lost, while it will still look like raw data, and, as such, will be untrustworthy.

.. code-block:: php

   <?php
   
   // filtering and keeping the incoming value. 
   $_DATA'id'] = (int) $_GET['id'];
   
   // filtering and changing the incoming value. 
   $_GET['id'] = strtolower($_GET['id']);
   
   ?>


It is recommended to put the modified values in another variable, and keep the original one intact.

+--------------+--------------------------------------+
| Command Line | Structures/NoChangeIncomingVariables |
+--------------+--------------------------------------+
| Analyzers    | :ref:`Analyze`                       |
+--------------+--------------------------------------+


.. _dont-change-the-blind-var:

Dont Change The Blind Var
#########################


When using a `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_, the blind variables are a copy. It is confusing to change them. 

.. code-block:: php

   <?php
   
   $foo = [1, 2, 3];
   foreach($foo as $bar) {
       // $bar is updated but its final value is lost
       print $bar . ' => ' . ($bar + 1) . PHP_EOL;
       // if $bar + 1 is repeated several times, consider assigning it to a variable.
       foobar($bar + 1);
   
   }
   
   $foo = [1, 2, 3];
   foreach($foo as $bar) {
       // $bar is updated but its final value is lost
       print $bar . ' => ' . (++$bar) . PHP_EOL;
       // Now that $bar is reused, it is easy to confuse its value
       foobar($bar);
   }
   
   ?>

+--------------+-------------------------------+
| Command Line | Structures/DontChangeBlindKey |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _dont-echo-error:

Dont Echo Error
###############


It is recommended to avoid displaying error messages directly to the browser.

.. code-block:: php

   <?php
   
   // Inside a 'or' test
   mysql_connect('localhost', $user, $pass) or 'die(mysql_error());
   
   // Inside a if test
   $result = pg_query( $db, $query );
   if( !$result )
   {
   	echo Erreur SQL: . pg_error();
   	'exit;
   }
   
   ?>


Error messages should be logged, but not displayed.

+--------------+---------------------------------+
| Command Line | Security/DontEchoError          |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Security` |
+--------------+---------------------------------+


.. _double-assignation:

Double Assignation
##################


This happens when a container (variable, property, array index) is assigned with values twice in a row. One of them is probably a debug instruction, that was forgotten. 

.. code-block:: php

   <?php
   
   // Normal assignation
   $a = 1;
   
   // Double assignation
   $b = 2;
   $b = 3;
   
   ?>

+--------------+------------------------------+
| Command Line | Structures/DoubleAssignation |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _double-instructions:

Double Instructions
###################


Twice the same call in a row. This is worth a check.

.. code-block:: php

   <?php
   
   ?>

+--------------+------------------------------+
| Command Line | Structures/DoubleInstruction |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _drop-else-after-return:

Drop Else After Return
######################


Avoid else clause when the then clause returns, but not the else. 

The else may simply be set in the main sequence of the function. 

This is also true if else has a return, and then not : simply reverse the condition. 

.. code-block:: php

   <?php
   
   // drop the else
   if ($a) {
       return $a;
   } else {
       doSomething();
   }
   
   // drop the then
   if ($b) {
       doSomething();
   } else {
       return $a;
   }
   
   // return in else and then
   if ($a3) {
       return $a;
   } else {
       $b = doSomething();
       return $b;
   }
   
   ?>

+--------------+--------------------------------+
| Command Line | Structures/DropElseAfterReturn |
+--------------+--------------------------------+
| Analyzers    | :ref:`Analyze`                 |
+--------------+--------------------------------+


.. _echo-or-print:

Echo Or Print
#############


Echo and print have the same functional use. <?= is also considered in this analysis. 

There seems to be a choice that is not enforced : one form is dominent, (> 90%) while the others are rare. 

The analyzed code has less than 10% of one of the three : for consistency reasons, it is recommended to make them all the same. 

It happens that print, echo or <?= are used depending on coding style and files. One file may be consistently using print, while the others are all using echo. 

.. code-block:: php

   <?php
   
   echo 'a';
   echo 'b';
   echo 'c';
   echo 'd';
   echo 'e';
   echo 'f';
   echo 'g';
   echo 'h';
   echo 'i';
   echo 'j';
   echo 'k';
   
   // This should probably be written 'echo';
   print 'l';
   
   ?>

+--------------+------------------------------------------------+
| Command Line | Structures/EchoPrintConsistance                |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _echo-with-concat:

Echo With Concat
################


Optimize your echo's by not concatenating at echo() time, but serving all argument separated. This will save PHP a memory copy.
If values (literals and variables) are small enough, this won't have impact. Otherwise, this is less work and less memory waste.

.. code-block:: php

   <?php
     echo $a, ' b ', $c;
   ?>


instead of

.. code-block:: php

   <?php
     echo  $a . ' b ' . $c;
     echo $a b $c;
   ?>

+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/EchoWithConcat                                                                                                             |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-unnecessary-string-concatenation <https://github.com/dseguy/clearPHP/tree/master/rules/no-unnecessary-string-concatenation.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Performances`, :ref:`Analyze`                                                                                                   |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+


.. _else-if-versus-elseif:

Else If Versus Elseif
#####################


Always use elseif instead of else and if. 

"The keyword elseif SHOULD be used instead of else if so that all control keywords look like single words". Quoted from the PHP-FIG documentation

.. code-block:: php

   <?php
   
   // Using elseif 
   if ($a == 1) { doSomething(); }
   elseif ($a == 2) { doSomethingElseIf(); }
   else { doSomethingElse(); }
   
   // Using else if 
   if ($a == 1) { doSomething(); }
   else if ($a == 2) { doSomethingElseIf(); }
   else { doSomethingElse(); }
   
   // Using else if, no {}
   if ($a == 1)  doSomething(); 
   else if ($a == 2) doSomethingElseIf(); 
   else  doSomethingElse(); 
   
   ?>

.

+--------------+-------------------------+
| Command Line | Structures/ElseIfElseif |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _empty-blocks:

Empty Blocks
############


The listed control structures are empty, or have one of the commanded block empty. It is recommended to remove those blocks, so as to reduce confusion in the code. 

.. code-block:: php

   <?php
   
   foreach($foo as $bar) ; // This block seems erroneous
       $foobar++;
   
   if ($a === $b) {
       doSomething();
   } else {
       // Empty block. Remove this
   }
   
   // Blocks containing only empty expressions are also detected
   for($i = 0; $i < 10; $i++) {
       ;
   }
   
   // Although namespaces are not control structures, they are reported here
   namespace A;
   namespace B;
   
   ?>

+--------------+------------------------+
| Command Line | Structures/EmptyBlocks |
+--------------+------------------------+
| Analyzers    | :ref:`Analyze`         |
+--------------+------------------------+


.. _empty-classes:

Empty Classes
#############


List of empty classes. Classes that are directly derived from an exception are omited.

.. code-block:: php

   <?php
   
   //Empty class
   class foo extends bar {}
   
   //Not an empty class
   class foo2 extends bar {
       const FOO = 2;
   }
   
   //Not an empty class, as derived from Exception
   class barException extends \Exception {}
   
   ?>

+--------------+--------------------+
| Command Line | Classes/EmptyClass |
+--------------+--------------------+
| Analyzers    | :ref:`Analyze`     |
+--------------+--------------------+


.. _empty-function:

Empty Function
##############


Function or method whose body is empty. 

Such functions or methods are rarely useful. As a bare minimum, the function should return some useful value, even if constant.

.. code-block:: php

   <?php
   
   // classic empty function
   function emptyFunction() {}
   
   class bar {
       // classic empty method
       function emptyMethod() {}
   
       // classic empty function
       function emptyMethodWithParent() {}
   }
   
   class barbar extends bar {
       // NOT an empty method : it overwrites the parent method
       function emptyMethodWithParent() {}
   }
   
   ?>

+--------------+-------------------------+
| Command Line | Functions/EmptyFunction |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _empty-instructions:

Empty Instructions
##################


Empty instructions are part of the code that have no instructions. This may be trailing semi-colon or empty blocks for if-then structures.

$condition = 3;;;;
if ($condition) { }

+--------------+----------------------------------------------+
| Command Line | Structures/EmptyLines                        |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Dead code <dead-code>`, :ref:`Analyze` |
+--------------+----------------------------------------------+


.. _empty-interfaces:

Empty Interfaces
################


Empty interfaces are a code smell. Interfaces should contains at least a method or a constant, and not be totally empty.

.. code-block:: php

   <?php
   
   // an empty interface
   interface empty {}
   
   // an normal interface
   interface normal {
       public function i() ;
   }
   
   // a constants interface
   interface constantsOnly {
       const FOO = 1;
   }
   
   ?>


See also `Empty interfaces are bad practice <https://r.je/empty-interfaces-bad-practice.html>`_ and `Blog : Are empty interfaces code smell? <https://hackernoon.com/are-interfaces-code-smell-bd19abc266d3>`_.

+--------------+---------------------------+
| Command Line | Interfaces/EmptyInterface |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _empty-list:

Empty List
##########


Empty list() are not allowed anymore in PHP 7. There must be at least one variable in the list call.

.. code-block:: php

   <?php
   
   //Not accepted since PHP 7.0
   list() = array(1,2,3);
   
   //Still valid PHP code
   list(,$x) = array(1,2,3);
   
   ?>

+--------------+----------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/EmptyList                                                                                                              |
+--------------+----------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+----------------------------------------------------------------------------------------------------------------------------+


.. _empty-namespace:

Empty Namespace
###############


Declaring a namespace in the code and not using it for structure declarations (classes, interfaces, etc...) or global instructions is useless.

Using simple style : 

.. code-block:: php

   <?php
   
   namespace X;
   // This is useless
   
   namespace Y;
   
   class foo {}
   
   ?>


Using bracket-style syntax : 

.. code-block:: php

   <?php
   
   namespace X {
       // This is useless
   }
   
   namespace Y {
   
       class foo {}
   
   }
   
   ?>

+--------------+-----------------------------------------------------------------------------------------------------+
| Command Line | Namespaces/EmptyNamespace                                                                           |
+--------------+-----------------------------------------------------------------------------------------------------+
| clearPHP     | `no-empty-namespace <https://github.com/dseguy/clearPHP/tree/master/rules/no-empty-namespace.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>`                                                        |
+--------------+-----------------------------------------------------------------------------------------------------+


.. _empty-slots-in-arrays:

Empty Slots In Arrays
#####################


PHP tolerates the last element of an array to be empty.

.. code-block:: php

   <?php
       $a = array( 1, 2, 3, );
       $b =      [ 4, 5, ];
   ?>

+--------------+------------------------------------------------+
| Command Line | Arrays/EmptySlots                              |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _empty-traits:

Empty Traits
############


List of all empty trait defined in the code. 

.. code-block:: php

   <?php
   
   // empty trait
   trait t { }
   
   // Another empty trait
   trait t2 {
       use t; 
   }
   
   ?>


Such traits may be reserved for future use. They may also be forgotten, and dead code.

+--------------+-------------------+
| Command Line | Traits/EmptyTrait |
+--------------+-------------------+
| Analyzers    | :ref:`Analyze`    |
+--------------+-------------------+


.. _empty-try-catch:

Empty Try Catch
###############


The code does try, then catch errors but do no act upon the error. 

.. code-block:: php

   <?php
   
   try { 
       doSomething();
   } catch ('Throwable $e) {
       // simply ignore this
   }
   
   ?>


At worst, the error should be logged, so as to measure the actual usage of the catch expression.

catch( Exception $e) (PHP 5) or catch(`'Throwable <http://php.net/manual/fr/class.throwable.php>`_ $e) with empty catch block should be banned, as they will simply ignore any error.

+--------------+--------------------------+
| Command Line | Structures/EmptyTryCatch |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _empty-with-expression:

Empty With Expression
#####################


`'empty() <http://www.php.net/empty>`_ doesn't accept expressions until PHP 5.5. Until then, it is necessary to store the result of the expression in a variable and then, test it with `'empty() <http://www.php.net/empty>`_.

.. code-block:: php

   <?php
   
   // PHP 5.5+ 'empty() usage
   if (empty(strtolower($b . $c))) {
       doSomethingWithoutA();
   }
   
   // Compatible 'empty() usage
   $a = strtolower($b . $c);
   if (empty($a)) {
       doSomethingWithoutA();
   }
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/EmptyWithExpression                                                                                                                                   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _encoded-simple-letters:

Encoded Simple Letters
######################


Some simple letters are written in escape sequence. 

Usually, escape sequences are made to encode unusual characters. Using escape sequences for simple characters, like letters or numbers is suspicious.

.. code-block:: php

   <?php
   
   // This escape sequence makes eval hard to spot
   $a = ev1l;
   $a('php_info();');
   
   // With a PHP 7.0 unicode code point sequence
   $a = ev\u{41}l;
   $a('php_info();');
   
   // With a PHP 5.0+ hexadecimal sequence
   $a = ev\x41l;
   $a('php_info();');
   
   ?>

+--------------+-------------------------+
| Command Line | Security/EncodedLetters |
+--------------+-------------------------+
| Analyzers    | :ref:`Security`         |
+--------------+-------------------------+


.. _error-messages:

Error Messages
##############


Error message when an error is reported in the code. Those messages will be read by whoever is triggering the error, and it has to be helpful. 

It is a good excercice to read the messages out of context, and try to understand what is about.

.. code-block:: php

   <?php
   
   // Not so helpful messages
   'die('Here be monsters');
   'exit('An error happened');
   throw new Exception('Exception thrown at runtime');
   
   ?>


Error messages are spotted via `'die <http://www.php.net/die>`_, `'exit <http://www.php.net/exit>`_ or exception.

+--------------+--------------------------+
| Command Line | Structures/ErrorMessages |
+--------------+--------------------------+
| Analyzers    | :ref:`ZendFramework`     |
+--------------+--------------------------+


.. _eval()-usage:

Eval() Usage
############


Using `'eval() <http://www.php.net/eval>`_ is bad for performances (compilation time), for caches (it won't be compiled), and for security (if it includes external data).

.. code-block:: php

   <?php
       // Avoid using incoming data to build the 'eval() expression : any filtering error leads to PHP injection
       $mathExpression = $_GET['mathExpression']; 
       $mathExpression = preg_replace('#[^0-9+\-*/\(/)]#is', '', $mathExpression); // expecting 1+2
       $literalCode = '$a = '.$mathExpression.';';
       eval($literalCode);
       echo $a;
   
       // If eval'ed code is known at compile time, it is best to put it inline
       $literalCode = ''phpinfo();';
       eval($literalCode);
   
   ?>


Most of the time, it is possible to replace the code by some standard PHP, like variable variable for accessing a variable for which you have the name.
At worse, including a pre-generated file will be faster. 

For PHP 7.0 and later, it is important to put `'eval() <http://www.php.net/eval>`_ in a try..catch expression.

+--------------+-------------------------------------------------------------------------------+
| Command Line | Structures/EvalUsage                                                          |
+--------------+-------------------------------------------------------------------------------+
| clearPHP     | `no-eval <https://github.com/dseguy/clearPHP/tree/master/rules/no-eval.md>`__ |
+--------------+-------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Performances`                                           |
+--------------+-------------------------------------------------------------------------------+


.. _exception-order:

Exception Order
###############


When catching exception, the most specialized exceptions must be in the early catch, and the most general exceptions must be in the later catch. Otherwise, the general catches intercept the exception, and the more specialized will not be read.

.. code-block:: php

   <?php
   
   class A extends \Exception {}
   class B extends A {}
   
   try {
       throw new A();
   } 
   catch(A $a1) { }
   catch(B $b2 ) { 
       // Never reached, as previous Catch is catching the early worm
   }
   
   ?>

+--------------+------------------------------+
| Command Line | Exceptions/AlreadyCaught     |
+--------------+------------------------------+
| Analyzers    | :ref:`Dead code <dead-code>` |
+--------------+------------------------------+


.. _exit()-usage:

Exit() Usage
############


Using `'exit <http://www.php.net/exit>`_ or `'die() <http://www.php.net/die>`_ in the code makes the code untestable (it will `'break <http://php.net/manual/en/control-structures.break.php>`_ unit tests). Morover, if there is no reason or string to display, it may take a long time to spot where the application is stuck. 

.. code-block:: php

   <?php
   
   // Throw an exception, that may be caught somewhere
   throw new \Exception('error');
   
   // Dying with error message. 
   'die('error');
   
   function foo() {
       //exiting the function but not dying
       if (somethingWrong()) {
           return true;
       }
   }
   ?>


Try exiting the function/class with return, or throw exception that may be caught later in the code.

+--------------+-------------------------------------------------------------------------------+
| Command Line | Structures/ExitUsage                                                          |
+--------------+-------------------------------------------------------------------------------+
| clearPHP     | `no-exit <https://github.com/dseguy/clearPHP/tree/master/rules/no-exit.md>`__ |
+--------------+-------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`ZendFramework`                                          |
+--------------+-------------------------------------------------------------------------------+


.. _exponent-usage:

Exponent Usage
##############


Usage of the `'** <http://php.net/manual/en/language.operators.arithmetic.php>`_ operator or \*\*\=, to make exponents.

.. code-block:: php

   <?php
   
   $eight = 2 '** 3;
   
   $sixteen = 4;
   $sixteen \*\*\= 2;
   
   ?>

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/ExponentUsage                                                               |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55` |
+--------------+---------------------------------------------------------------------------------+


.. _failed-substr-comparison:

Failed Substr Comparison
########################


The extracted string must be of the size of the compared string.

This is also true for negative lengths.

.. code-block:: php

   <?php
   
   // Possible comparison
   if (substr($a, 0, 3) === 'abc') { }
   if (substr($b, 4, 3) === 'abc') { }
   
   // Always failing
   if (substr($a, 0, 3) === 'ab') { }
   if (substr($a, 3, -3) === 'ab') { }
   
   // Omitted in this analysis
   if (substr($a, 0, 3) !== 'ab') { }
   
   ?>

+--------------+------------------------------------+
| Command Line | Structures/FailingSubstrComparison |
+--------------+------------------------------------+
| Analyzers    | :ref:`Analyze`                     |
+--------------+------------------------------------+


.. _fetch-one-row-format:

Fetch One Row Format
####################


When reading results with ext/Sqlite3, it is recommended to explicitely request SQLITE3_NUM or SQLITE3_ASSOC, while avoiding the default value and SQLITE3_BOTH.

.. code-block:: php

   <?php
   
   $res = $database->query($query);
   
   // Fastest version, but less readable
   $row = $res->fetchArray(\SQLITE3_NUM);
   // Almost the fastest version, and more readable
   $row = $res->fetchArray(\SQLITE3_ASSOC);
   
   // Default version. Quite slow
   $row = $res->fetchArray();
   
   // Worse case
   $row = $res->fetchArray(\SQLITE3_BOTH);
   
   ?>


This is a micro-optimisation. The difference may be visible with 200k rows fetches, and measurable with 10k.

+--------------+--------------------------------+
| Command Line | Performances/FetchOneRowFormat |
+--------------+--------------------------------+
| Analyzers    | :ref:`Performances`            |
+--------------+--------------------------------+


.. _for-using-functioncall:

For Using Functioncall
######################


It is recommended to avoid functioncall in the `'for() <http://php.net/manual/en/control-structures.for.php>`_ statement. 

.. code-block:: php

   <?php
   
   // Fastest way
   $nb = count($array); 
   for($i = 0; $i < $nb; ++$i) {
       doSomething($i);
   } 
   
   // Same as above, but slow
   for($i = 0; $i < count($array); ++$i) {
       doSomething($i);
   } 
   
   // Same as above, but slow
   foreach($portions as &$portion) {
       // here, 'array_sum() doesn't depends on the $grade. It should be out of the loop
       $portion = $portion / array_sum($portions);
   } 
   
   $total = array_sum($portion);
   foreach($portion as &$portion) {
       $portion = $portion / $total;
   } 
   
   ?>


This is true with any kind of functioncall that returns the same value throughout the loop.

+--------------+---------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/ForWithFunctioncall                                                                                |
+--------------+---------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-functioncall-in-loop <https://github.com/dseguy/clearPHP/tree/master/rules/no-functioncall-in-loop.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Performances`                                                                           |
+--------------+---------------------------------------------------------------------------------------------------------------+


.. _foreach-don't-change-pointer:

Foreach Don't Change Pointer
############################


In PHP 7.0, the foreach loop won't change the internal pointer of the array, but will work on a copy. So, applying array pointer's functions such as `'current() <http://www.php.net/current>`_ or `'next() <http://www.php.net/next>`_ to the source array won't have the same behavior than in PHP 5.

This anly applies when a `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_ by reference is used.

.. code-block:: php

   <?php
   
   $numbers = range(1, 10);
   next($numbers);
   foreach($numbers as &$number){
       print $number;
       print current($numbers).\n; // Always 
   }
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/ForeachDontChangePointer                                                                               |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _foreach-needs-reference-array:

Foreach Needs Reference Array
#############################


When using foreach with a reference as value, the source must be a referenced array, which is a variable (or array or property or static property). 
When the array is the result of an expression, the array is not kept in memory after the foreach loop, and any change made with & are lost.

This will do nothing

.. code-block:: php

   <?php
       foreach(array(1,2,3) as &$value) {
           $value *= 2;
       }
   ?>


This will have an actual effect

.. code-block:: php

   <?php
       $array = array(1,2,3);
       foreach($array as &$value) {
           $value *= 2;
       }
   ?>

+--------------+----------------------------------------+
| Command Line | Structures/ForeachNeedReferencedSource |
+--------------+----------------------------------------+
| Analyzers    | :ref:`Analyze`                         |
+--------------+----------------------------------------+


.. _foreach-reference-is-not-modified:

Foreach Reference Is Not Modified
#################################


Foreach statement may loop using a reference, especially when the loop has to change values of the array it is looping on. In the spotted loop, reference are used but never modified. They may be removed.

+--------------+------------------------------------------+
| Command Line | Structures/ForeachReferenceIsNotModified |
+--------------+------------------------------------------+
| Analyzers    | :ref:`Analyze`                           |
+--------------+------------------------------------------+


.. _foreach-with-list():

Foreach With list()
###################


PHP 5.5 introduced the ability to use list in foreach loops. This was not possible in the earlier versions.

.. code-block:: php

   <?php
       foreach($array as list($a, $b)) { 
           // do something 
       }
   ?>


Previously, it was compulsory to extract the data from the blind array : 

.. code-block:: php

   <?php
       foreach($array as $c) { 
           list($a, $b) = $c;
           // do something 
       }
   ?>

+--------------+------------------------------------------------------+
| Command Line | Structures/ForeachWithList                           |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54` |
+--------------+------------------------------------------------------+


.. _forgotten-interface:

Forgotten Interface
###################


The following classes have been found implementing an interface's methods, though it doesn't explicitely implements this interface. This may have been forgotten.

.. code-block:: php

   <?php
   
   interface i {
       function i(); 
   }
   
   // i is not implemented and declared
   class foo {
       function i() {}
       function j() {}
   }
   
   // i is implemented and declared
   class foo implements i {
       function i() {}
       function j() {}
   }
   
   ?>

+--------------+------------------------------+
| Command Line | Interfaces/CouldUseInterface |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _forgotten-thrown:

Forgotten Thrown
################


An exception is instantiated, but not thrown. 

.. code-block:: php

   <?php
   
   class MyException() extends \Exception { }
   
   if ($error !== false) {
       // This looks like 'throw' was omitted
       new MyException();
   }
   
   ?>

+--------------+----------------------------+
| Command Line | Exceptions/ForgottenThrown |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _forgotten-visibility:

Forgotten Visibility
####################


Some classes elements (property, method, and constant in PHP 7.1) are missing their explicit visibility.

By default, it is public. It should at least be mentioned as public, or may be reviewed as protected or private. 

final, static and abstract are not counted as visibility. Only public, private and protected. The PHP 4 var keyword is counted as undefined.

Traits, classes and interfaces are checked. 

.. code-block:: php

   <?php
   
   // Explicit visibility
   class X {
       protected sconst NO_VISIBILITY_CONST = 1; // For PHP 7.2 and later
   
       private $noVisibilityProperty = 2; 
       
       public function Method() {}
   }
   
   // Missing visibility
   class X {
       const NO_VISIBILITY_CONST = 1; // For PHP 7.2 and later
   
       var $noVisibilityProperty = 2; // Only with var
       
       function NoVisibilityForMethod() {}
   }
   
   ?>

+--------------+-------------------------------------------------------------------------------------------------------------+
| Command Line | Classes/NonPpp                                                                                              |
+--------------+-------------------------------------------------------------------------------------------------------------+
| clearPHP     | `always-have-visibility <https://github.com/dseguy/clearPHP/tree/master/rules/always-have-visibility.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                              |
+--------------+-------------------------------------------------------------------------------------------------------------+


.. _forgotten-whitespace:

Forgotten Whitespace
####################


Those are white space that are at either end of a script : at the beginning or the end. 

.. code-block:: php

   <?php
       // This script has no forgotten whitespace, not at the beginning
       function foo() {}
   
       // This script has no forgotten whitespace, not at the end
   ?>


Usually, such white space are forgotten, and may end up summoning the infamous 'headers already sent' error. It is better to remove them. 

See also `How to fix Headers already sent error in PHP <http://stackoverflow.com/questions/8028957/how-to-fix-headers-already-sent-error-in-php>`_.

+--------------+--------------------------------+
| Command Line | Structures/ForgottenWhiteSpace |
+--------------+--------------------------------+
| Analyzers    | :ref:`Analyze`                 |
+--------------+--------------------------------+


.. _fully-qualified-constants:

Fully Qualified Constants
#########################


Constants defined with their namespace.

When defining constants with `'define() <http://www.php.net/define>`_ function, it is possible to include the actual namespace : 

.. code-block:: php

   <?php
   
   define('a\b\c', 1); 
   
   ?>


However, the name should be fully qualified without the initial \. Here, \a\b\c constant will never be accessible as a namespace constant, though it will be accessible via the `'constant() <http://www.php.net/constant>`_ function.

Also, the namespace will be absolute, and not a relative namespace of the current one.

+--------------+-----------------------------------+
| Command Line | Namespaces/ConstantFullyQualified |
+--------------+-----------------------------------+
| Analyzers    | :ref:`Analyze`                    |
+--------------+-----------------------------------+


.. _function-subscripting:

Function Subscripting
#####################


This is a new PHP 5.4 feature, where one may use the result of a method directly as an array, given that the method actually returns an array. 

.. code-block:: php

   <?php
   
   function foo() {
       return array(1 => 'a', 'b', 'c');
   }
   
   echo foo()[1]; // displays 'a';
   
   // Function subscripting, the old way
   function foo() {
       return array(1 => 'a', 'b', 'c');
   }
   
   $x = foo();
   echo $x[1]; // displays 'a';
   
   ?>


This was not possible until PHP 5.4. Is used to be necessary to put the result in a variable, and then access the desired index.

+--------------+---------------------------------+
| Command Line | Structures/FunctionSubscripting |
+--------------+---------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`       |
+--------------+---------------------------------+


.. _function-subscripting,-old-style:

Function Subscripting, Old Style
################################


Since PHP 5.4, it is now possible use function results as an array, and access directly its element : 

.. code-block:: php

   <?php
   
   function foo() {
       return array(1 => 'a', 'b', 'c');
   }
   
   echo foo()[1]; // displays 'a';
   
   // Function subscripting, the old way
   function foo() {
       return array(1 => 'a', 'b', 'c');
   }
   
   $x = foo();
   echo $x[1]; // displays 'a';
   
   ?>

+--------------+------------------------------------+
| Command Line | Structures/FunctionPreSubscripting |
+--------------+------------------------------------+
| Analyzers    | :ref:`Analyze`                     |
+--------------+------------------------------------+


.. _functions-removed-in-php-5.4:

Functions Removed In PHP 5.4
############################


Those functions were removed in PHP 5.4.

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/Php54RemovedFunctions                                                                                                                                                                   |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _functions-removed-in-php-5.5:

Functions Removed In PHP 5.5
############################


Those functions were removed in PHP 5.5.

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/Php55RemovedFunctions                                                                                                                                        |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _getting-last-element:

Getting Last Element
####################


Getting the last element of an array is done with `'count() <http://www.php.net/count>`_ or `'end() <http://www.php.net/end>`_.

.. code-block:: php

   <?php
   
   $array = [1, 2, 3];
   
   // Best solutions, just as quick as each other
   $last = $array[count($array) - 1];
   $last = end($array);
   
   // Bad solutions
   
   // popping, but restoring the value. 
   $last = array_pop($array);
   $array[] = $last; 
   
   // array_unshift would be even worse
   
   // reversing array
   $last = array_reverse($array)[0];
   
   // slicing the array
   $last = array_slice($array, -1)[0]',
   $last = current(array_slice($array, -1));
   );
   
   ?>

+--------------+---------------------------+
| Command Line | Arrays/GettingLastElement |
+--------------+---------------------------+
| Analyzers    | :ref:`Performances`       |
+--------------+---------------------------+


.. _global-inside-loop:

Global Inside Loop
##################


The global keyword must be out of loops. It is evaluated each loop, slowing the whole process.

.. code-block:: php

   <?php
   
   // Good idea, global is used once
   global $total;
   foreach($a as $b) {
       $total += $b;
   }
   
   // Bad idea, this is slow.
   foreach($a as $b) {
       global $total;
       $total += $b;
   }
   ?>

+--------------+------------------------------+
| Command Line | Structures/GlobalOutsideLoop |
+--------------+------------------------------+
| Analyzers    | :ref:`Performances`          |
+--------------+------------------------------+


.. _global-usage:

Global Usage
############


List usage of globals variables, with global keywords or direct access to $GLOBALS.

It is recommended to avoid using global variables, at it makes it very difficult to track changes in values across the whole application.

+--------------+-----------------------------------------------------------------------------------+
| Command Line | Structures/GlobalUsage                                                            |
+--------------+-----------------------------------------------------------------------------------+
| clearPHP     | `no-global <https://github.com/dseguy/clearPHP/tree/master/rules/no-global.md>`__ |
+--------------+-----------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                    |
+--------------+-----------------------------------------------------------------------------------+


.. _group-use-declaration:

Group Use Declaration
#####################


The group use declaration is used in the code.

.. code-block:: php

   <?php
   
   // Adapted from the RFC documentation 
   // Pre PHP 7 code
   use some\name_space\ClassA;
   use some\name_space\ClassB;
   use some\name_space\ClassC as C;
   
   use function some\name_space\fn_a;
   use function some\name_space\fn_b;
   use function some\name_space\fn_c;
   
   use const some\name_space\ConstA;
   use const some\name_space\ConstB;
   use const some\name_space\ConstC;
   
   // PHP 7+ code
   use some\name_space\{ClassA, ClassB, ClassC as C};
   use function some\name_space\{fn_a, fn_b, fn_c};
   use const some\name_space\{ConstA, ConstB, ConstC};
   
   ?>


See also `Group Use Declaration RFC <https://wiki.php.net/rfc/group_use_declarations>`_ and `Using namespaces: Aliasing/Importing <http://php.net/manual/en/language.namespaces.importing.php>`_.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/GroupUseDeclaration                                                                                    |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _hardcoded-passwords:

Hardcoded Passwords
###################


Hardcoded passwords in the code. 

Hardcoding passwords is a bad idea. Not only it make the code difficult to change, but it is an information leak. It is better to hide this kind of information out of the code.

.. code-block:: php

   <?php
   
   $ftp_server = '300.1.2.3';   // 
   $conn_id = ftp_connect($ftp_server); 
   
   // login with username and password
   $login_result = ftp_login($conn_id, 'login', 'password'); 
   
   ?>

+--------------+---------------------------------------------------------------------------------------------------------------+
| Command Line | Functions/HardcodedPasswords                                                                                  |
+--------------+---------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-hardcoded-credential <https://github.com/dseguy/clearPHP/tree/master/rules/no-hardcoded-credential.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Security`                                                                               |
+--------------+---------------------------------------------------------------------------------------------------------------+


.. _hash-algorithms:

Hash Algorithms
###############


There is a long but limited list of hashing algorithm available to PHP. The one found below doesn't seem to be existing.

+--------------+----------------+
| Command Line | Php/HashAlgos  |
+--------------+----------------+
| Analyzers    | :ref:`Analyze` |
+--------------+----------------+


.. _hash-algorithms-incompatible-with-php-5.3:

Hash Algorithms Incompatible With PHP 5.3
#########################################


List of hash algorithms incompatible with PHP 5.3. They were introduced in newer version, and, as such, are not available with older versions.

fnv132, fnv164 and joaat were added in PHP 5.4.

.. code-block:: php

   <?php
   
   // Valid in PHP 5.4 +
   hash('joaat', 'string');
   
   // Valid in PHP all versions
   hash('crc32', 'string');
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/HashAlgos53                                                                                                                                                                                                        |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _hash-algorithms-incompatible-with-php-5.4/5:

Hash Algorithms Incompatible With PHP 5.4/5
###########################################


List of hash algorithms incompatible with PHP 5.4 and 5.5. They were introduced in newer version, or removed in PHP 5.4. As such, they are not available with older versions.

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/HashAlgos54                                                                                                                                                                             |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _heredoc-delimiter:

Heredoc Delimiter
#################


Heredoc and Nowdoc expressions may use a variety of delimiters. 

There seems to be a standard delimiter in the code, and some exceptions : one or severals forms are dominent (> 90%), while the others are rare. 

The analyzed code has less than 10% of the rare delimiters. For consistency reasons, it is recommended to make them all the same. 

Generally, one or two delimiters are used, with generic value. It is recommended to use a humanly readable delimiter : SQL, HTML, XML, GREMLIN, etc. This helps readability in the code.

.. code-block:: php

   <?php
   
   echo <<<SQL
   SELECT * FROM table1;
   SQL;
   
   echo <<<SQL
   SELECT * FROM table2;
   SQL;
   
   echo <<<SQL
   SELECT * FROM table3;
   SQL;
   
   echo <<<SQL
   SELECT * FROM table4;
   SQL;
   
   echo <<<SQL
   SELECT * FROM table5;
   SQL;
   
   echo <<<SQL
   SELECT * FROM table11;
   SQL;
   
   echo <<<SQL
   SELECT * FROM table12;
   SQL;
   
   echo <<<SQL
   SELECT * FROM table13;
   SQL;
   
   // Nowdoc
   echo <<<'SQL'
   SELECT * FROM table14;
   SQL;
   
   echo <<<SQL
   SELECT * FROM table15;
   SQL;
   
   
   echo <<<HEREDOC
   SELECT * FROM table215;
   HEREDOC;
   
   ?>

+--------------+------------------------------------------------+
| Command Line | Structures/HeredocDelimiterFavorite            |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _hexadecimal-in-string:

Hexadecimal In String
#####################


Mark strings that may be confused with hexadecimal. 

Until PHP 7.0, PHP recognizes hexadecimal numbers inside strings, and converts them accordingly. 

PHP 7.0 and until 7.1, converts the string to 0, silently. 

PHP 7.1 and later, emits a 'A non-numeric value encountered' warning, and convert the string to 0. 

.. code-block:: php

   <?php
       $a = '0x0030';
       print $a + 1;
       // Print 49
   
       $c = '0x0030zyc';
       print $c + 1;
       // Print 49
   
       $b = 'b0x0030';
       print $b + 1;
       // Print 0
   ?>

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Type/HexadecimalString                                                                                     |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _hidden-use-expression:

Hidden Use Expression
#####################


The use expression for namespaces should always be at te beginning of the namespace block. 

It is where everyone expect them, and it is less confusing than having them at various levels.

.. code-block:: php

   <?php
   
   // This is visible 
   use A;
   
   class B {}
   
   // This is hidden 
   use C as D;
   
   class E extends D {
       use traitT; // This is a use for a trait
   
       function foo() {
           // This is a use for a closure
           return function ($a) use ($b) {}
       }
   }
   
   ?>

+--------------+----------------------+
| Command Line | Namespaces/HiddenUse |
+--------------+----------------------+
| Analyzers    | :ref:`Analyze`       |
+--------------+----------------------+


.. _htmlentities-calls:

Htmlentities Calls
##################


`'htmlentities() <http://www.php.net/htmlentities>`_ and `'htmlspecialchars() <http://www.php.net/htmlspecialchars>`_ are used to prevent injecting special characters in HTML code. As a bare minimum, they take a string and encode it for HTML.

The second argument of the functions is the type of protection. The protection may apply to quotes or not, to HTML4 or 5, etc. It is highly recommended to set it explicitely.

The third argument of the functions is the encoding of the string. In PHP 5.3, it as 'ISO-8859-1', in 5.4, was 'UTF-8', and in 5.6, it is now default_charset, a php.ini configuration that has the default value of 'UTF-8'. It is highly recommended to set this argument too, to avoid distortions from the configuration.

Also, note that arguments 2 and 3 are constants and string (respectively), and should be issued from the list of values available in the manual. Other values than those will make PHP use the default values.

+--------------+-----------------------------+
| Command Line | Structures/Htmlentitiescall |
+--------------+-----------------------------+
| Analyzers    | :ref:`Analyze`              |
+--------------+-----------------------------+


.. _identical-conditions:

Identical Conditions
####################


These logical expressions contain members that are identical. 

This means those expressions may be simplified. 

.. code-block:: php

   <?php
   
   // twice $a
   if ($a || $b || $c || $a) {  }
   
   // Hiding is parenthesis is bad
   if (($a) ^ ($a)) {}
   
   // expressions may be large
   if ($a === 1 && 1 === $a) {}
   
   ?>

+--------------+--------------------------------+
| Command Line | Structures/IdenticalConditions |
+--------------+--------------------------------+
| Analyzers    | :ref:`Analyze`                 |
+--------------+--------------------------------+


.. _if-with-same-conditions:

If With Same Conditions
#######################


Successive If / then structures that have the same condition may be either merged or have one of the condition changed. 

.. code-block:: php

   <?php
   
   if ($a == 1) {
       doSomething();
   }
   
   if ($a == 1) {
       doSomethingElse();
   }
   
   // May be replaced by 
   if ($a == 1) {
       doSomething();
       doSomethingElse();
   }
   
   ?>


Note that if the values used in the condition have been modified in the first if/then structure, the two distinct conditions may be needed. 

.. code-block:: php

   <?php
   
   // May not be merged
   if ($a == 1) {
       // Check that this is really the situation
       $a = checkSomething();
   }
   
   if ($a == 1) {
       doSomethingElse();
   }
   
   ?>

+--------------+---------------------------------+
| Command Line | Structures/IfWithSameConditions |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`                  |
+--------------+---------------------------------+


.. _iffectations:

Iffectations
############


Affectations that appears in a conditions. 

Iffectations are a way to do both a test and an affectations. 
They may also be typos, such as if ($x = 3) { ... }, leading to a constant condition. 

.. code-block:: php

   <?php
   
   // an iffectation : assignation in a If condition
   if($connexion = mysql_connect($host, $user, $pass)) {
       $res = mysql_query($connexion, $query);
   }
   
   // Iffectation may happen in while too.
   while($row = mysql_fetch($res)) {
       $store[] = $row;
   }
   
   ?>

+--------------+------------------------+
| Command Line | Structures/Iffectation |
+--------------+------------------------+
| Analyzers    | :ref:`Analyze`         |
+--------------+------------------------+


.. _illegal-name-for-method:

Illegal Name For Method
#######################


PHP has reserved usage of methods starting with __ for magic methods. It is recommended to avoid using this prefix, to prevent confusions.

.. code-block:: php

   <?php
   
   class foo{
       // Constructor
       function '__construct() {}
   
       // Constructor's typo
       function __constructor() {}
   
       // Illegal function name, even as private
       private function __bar() {}
   }
   
   ?>

+--------------+-------------------+
| Command Line | Classes/WrongName |
+--------------+-------------------+
| Analyzers    | :ref:`Analyze`    |
+--------------+-------------------+


.. _implement-is-for-interface:

Implement Is For Interface
##########################


When deriving classes, implements should be used for interfaces, and extends with classes.

+--------------+---------------------------------+
| Command Line | Classes/ImplementIsForInterface |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`                  |
+--------------+---------------------------------+


.. _implemented-methods-are-public:

Implemented Methods Are Public
##############################


Class methods that are defined in an interface must be public. They cannot be either private, nor protected.

This error is not reported by lint, but is reported at execution time.

.. code-block:: php

   <?php
   
   interface i {
       function foo();
   }
   
   class X {
       // This method is defined in the interface : it must be public
       protected function foo() {}
       
       // other methods may be private
       private function bar() {}
   }
   
   ?>

+--------------+-------------------------------------+
| Command Line | Classes/ImplementedMethodsArePublic |
+--------------+-------------------------------------+
| Analyzers    | :ref:`Analyze`                      |
+--------------+-------------------------------------+


.. _implicit-global:

Implicit Global
###############


Global variables, that are used in local scope with global keyword, but are not declared as global in the global scope. They may be mistaken with distinct values, while, in PHP, variables in the global scope are truly global.

.. code-block:: php

   <?php
   
   // This is implicitely global
   $implicitGlobal = 1;
   
   global $explicitGlobal;
   $explicitGlobal = 2;
   
   foo();
   echo $explicitFunctionGlobal;
   
   function foo() {
       // This global is needed, but not the one in the global space
       global $implicitGlobal, $explicitGlobal, $explicitFunctionGlobal;
       
       // This won't be a global, as it must be 'global' in a function scope
       $notImplicitGlobal = 3;
       $explicitFunctionGlobal = 3;
   }
   
   ?>

+--------------+---------------------------+
| Command Line | Structures/ImplicitGlobal |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _incompilable-files:

Incompilable Files
##################


Files that cannot be compiled, and, as such, be run by PHP. Scripts are linted against PHP versions 5.2, 5.3, 5.4, 5.5, 5.6, 7.0-dev and 7.1. 

This is usually undesirable, as all code must compile before being executed. It may simply be that such files are not compilable because they are not yet ready for an upcoming PHP version.

.. code-block:: php

   <?php
   
   // Can't compile this : Print only accepts one argument
   print $a, $b, $c;
   
   ?>


Code that is incompilable with older PHP versions means that the code is breaking backward compatibility : good or bad is project decision.

+--------------+-----------------------------------------------------------------------------------------------+
| Command Line | Php/Incompilable                                                                              |
+--------------+-----------------------------------------------------------------------------------------------+
| clearPHP     | `no-incompilable <https://github.com/dseguy/clearPHP/tree/master/rules/no-incompilable.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                |
+--------------+-----------------------------------------------------------------------------------------------+


.. _indices-are-int-or-string:

Indices Are Int Or String
#########################


Indices in an array notation such as $array['indice'] may only be integers or string.

Boolean, Null or float will be converted to their integer or string equivalent.

.. code-block:: php

   <?php
       $a = [true => 1,
             1.0  => 2,
             1.2  => 3,
             1    => 4,
             '1'  => 5,
             0.8  => 6,
             0x1  => 7,
             01   => 8,
             
             null  => 1,
             ''    => 2,
             
             false => 1,
             0     => 2,
   
             '0.8' => 3,
             '01'  => 4,
             '2a'  => 5
             ];
             
       print_r($a);
   ?>::

   
   Array
   (
       [1] => 8
       [0] => 2
       [] => 2
       [0.8] => 3
       [01] => 4
       [2a] => 5
   )
   


Decimal numbers are rounded to the closest integer; Null is transtyped to '' (empty string); true is 1 and false is 0; Integers in strings are transtyped, while partial numbers or decimals are not analyzed in strings. 

As a general rule of thumb, only use integers or strings that don\'t look like integers. 

This analyzer may find constant definitions, when available.

+--------------+----------------------------------+
| Command Line | Structures/IndicesAreIntOrString |
+--------------+----------------------------------+
| Analyzers    | :ref:`Analyze`                   |
+--------------+----------------------------------+


.. _indirect-injection:

Indirect Injection
##################


Look for injections through indirect usage for GPRC values ($_GET, $_POST, $_REQUEST, $_COOKIE). 

.. code-block:: php

   <?php
   
   $a = $_GET['a'];
   echo $a;
   
   ?>

+--------------+----------------------------+
| Command Line | Security/IndirectInjection |
+--------------+----------------------------+
| Analyzers    | :ref:`Security`            |
+--------------+----------------------------+


.. _instantiating-abstract-class:

Instantiating Abstract Class
############################


Those code will raise a PHP fatal error at execution time : 'Cannot instantiate abstract class'. The classes are actually abstract classes, and should be derived into a concrete class to be instantiated.

+--------------+------------------------------------+
| Command Line | Classes/InstantiatingAbstractClass |
+--------------+------------------------------------+
| Analyzers    | :ref:`Analyze`                     |
+--------------+------------------------------------+


.. _interpolation:

Interpolation
#############


The following strings contain variables that are will be replaced. However, the following characters are ambiguous, and may lead to confusion. 

For example, "$x[1]->b".will be read by PHP as $x[1].\->b" and not like "{$x[1]->b}". 

It is advised to add curly brackets around those structures to make them non-ambiguous.

+--------------+------------------------------------------------+
| Command Line | Type/StringInterpolation                       |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _invalid-constant-name:

Invalid Constant Name
#####################


According to PHP's manual, constant names, ' A valid constant name starts with a letter or underscore, followed by any number of letters, numbers, or underscores.'.

Constant, when defined using `'define() <http://www.php.net/define>`_ function, must follow this regex :::

   
   /[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/

+--------------+-----------------------+
| Command Line | Constants/InvalidName |
+--------------+-----------------------+
| Analyzers    | :ref:`Analyze`        |
+--------------+-----------------------+


.. _invalid-octal-in-string:

Invalid Octal In String
#######################


Starting with PHP 7.1, any octal sequence inside a string can't be beyong 7. Those will be a fatal error at parsing time. 

In PHP 7.0 and older, those sequences were silently adapted (divided by 0).

.. code-block:: php

   <?php
   
   // Emit no error in PHP 7.1
   echo 0; // @
   
   // Emit an error in PHP 7.1
   echo 0; // @
   
   ?>

+--------------+---------------------------------------------------------------------------------+
| Command Line | Type/OctalInString                                                              |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------+


.. _is-zend-framework-1-controller:

Is Zend Framework 1 Controller
##############################


Mark a class as being a Zend Framework Controller.

.. code-block:: php

   <?php
   
   class AController extends Zend_Controller_Action {
       // Controller code
   }
   
   ?>

+--------------+----------------------+
| Command Line | ZendF/IsController   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _is-zend-framework-1-helper:

Is Zend Framework 1 Helper
##########################


Mark a class as being a Zend Framework Helper.

.. code-block:: php

   <?php
   
   class AnHelper extends Zend_View_Helper_Abstract {
       // Controller code
   }
   
   ?>

+--------------+----------------------+
| Command Line | ZendF/IsHelper       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _isset-with-constant:

Isset With Constant
###################


Until PHP 7, it was possible to use arrays as constants, but it was not possible to test them with `'isset <http://www.php.net/isset>`_.

.. code-block:: php

   <?php
   const X = [1,2,3];
   
   if ('isset(X[4])) {}
   ?>


This would yield an error : 

Fatal error: Cannot use `'isset() <http://www.php.net/isset>`_ on the result of an expression (you can use "null !== expression" instead) in test.php on line 7

This is a backward incompatibility.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/IssetWithConstant                                                                               |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _join-file():

Join file()
###########


Applying `'join() <http://www.php.net/join>`_ or `'implode() <http://www.php.net/implode>`_ to the result of `'file() <http://www.php.net/file>`_ provides the same results than using `'file_get_contents() <http://www.php.net/file_get_contents>`_, but at a higher cost of memory and processing.

.. code-block:: php

   <?php
   
   // memory and CPU intensive
   $content = join('', file('path/to/file.txt'));
   
   // memory intensive
   $content = file_get_contents('path/to/file.txt');
   
   // Consider reading the data line by line and processing it along the way, 
   // to save memory 
   $fp = fopen('path/to/file.txt', 'r');
   while($line = fget($fp)) {
       // process a line
   }
   fclose($fp);
   
   ?>


Always use `'file_get_contents() <http://www.php.net/file_get_contents>`_ to get the content of a file as a string.

+--------------+-----------------------+
| Command Line | Performances/JoinFile |
+--------------+-----------------------+
| Analyzers    | :ref:`Performances`   |
+--------------+-----------------------+


.. _list-short-syntax:

List Short Syntax
#################


Usage of short syntax version of list().

.. code-block:: php

   <?php
   
   // PHP 7.1 short list syntax
   // PHP 7.1 may also use key => value structures with list
   [$a, $b, $c] = ['2', 3, '4'];
   
   // PHP 7.0 list syntax
   list($a, $b, $c) = ['2', 3, '4'];
   
   ?>

+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/ListShortSyntax                                                                                                                   |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+


.. _list-with-appends:

List With Appends
#################


List() behavior has changed in PHP 7.0 and it has impact on the indexing when list is used with the [] operator. 

.. code-block:: php

   <?php
   
   $x = array();
   list($x[], $x[], $x[]) = [1, 2, 3];
   
   print_r($x);
   
   ?>


In PHP 7.0, results are :::

   
   Array
   (
       [0] => 1
       [1] => 2
       [2] => 3
   )
   


In PHP 5.6, results are :::

   
   Array
   (
       [0] => 3
       [1] => 2
       [2] => 1
   )

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/ListWithAppends                                                                                                                                              |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _list-with-keys:

List With Keys
##############


Setting keys when using list() is a PHP 7.1 feature.

.. code-block:: php

   <?php
   
   // PHP 7.1 and later only
   list('a' => $a, 'b' => $b) = ['b' => 1, 'c' => 2, 'a' => 3];
   
   ?>

+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/ListWithKeys                                                                                                                      |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+


.. _locally-unused-property:

Locally Unused Property
#######################


Those properties are defined in a class, and this class doesn't have any method that makes use of them. 

While this is syntacticly correct, it is unusual that defined ressources are used in a child class. It may be worth moving the definition to another class, or to move accessing methods to the class.

+--------------+----------------------------------------------+
| Command Line | Classes/LocallyUnusedProperty                |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>` |
+--------------+----------------------------------------------+


.. _logical-mistakes:

Logical Mistakes
################


Spot logical mistakes within logical expressions. 

Sometimes, the logic is not what it seems. It is important to check the actual impact of every part of the logical expression. Do not hesitate to make a table with all possible cases. If those cases are too numerous, it may be time to rethink the whole expression. 

.. code-block:: php

   <?php 
   
   // Always false
   if ($a != 1 || $a != 2) { } 
   
   // $a == 1 is useless
   if ($a == 1 || $a != 2) {}
   
   // Always false
   if ($a == 1 && $a == 2) {}
   
   // $a != 2 is useless
   if ($a == 1 && $a != 2) {}
   
   ?>


Based on article from Andrey Karpov  `Logical Expressions in C/C++. Mistakes Made by Professionals <http://www.viva64.com/en/b/0390/>`_

+--------------+----------------------------+
| Command Line | Structures/LogicalMistakes |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _logical-should-use-symbolic-operators:

Logical Should Use Symbolic Operators
#####################################


Logical operators come in two flavors :  and / &&, || / or, ^ / xor. However, they are not exchangeable, as && and and have different precedence. 

It is recommended to use the symbol operators, rather than the letter ones.

+--------------+---------------------------------------------------------------------------------------------------+
| Command Line | Php/LogicalInLetters                                                                              |
+--------------+---------------------------------------------------------------------------------------------------+
| clearPHP     | `no-letter-logical <https://github.com/dseguy/clearPHP/tree/master/rules/no-letter-logical.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                    |
+--------------+---------------------------------------------------------------------------------------------------+


.. _lone-blocks:

Lone Blocks
###########


Blocks are compulsory when defining a structure, such as a class or a function. They are most often used with flow control instructions, like if then or switch. 

Blocks are also valid syntax that group several instructions together, though they have no effect at all, except confuse the reader. Most often, it is a ruin from a previous flow control instruction, whose condition was removed or commented. They should be removed. 

.. code-block:: php

   <?php
   
       //foreach($a as $b) 
       {
           $b++;
       }
   ?>

+--------------+----------------------+
| Command Line | Structures/LoneBlock |
+--------------+----------------------+
| Analyzers    | :ref:`Analyze`       |
+--------------+----------------------+


.. _long-arguments:

Long Arguments
##############


Long arguments should be put in variable, to preserve readability. 

When literal arguments are too long, they `'break <http://php.net/manual/en/control-structures.break.php>`_ the hosting structure by moving the next argument too far on the right. Whenever possible, long arguments should be set in a local variable to keep the readability.

.. code-block:: php

   <?php
   
   // Now the call to foo() is easier to read.
   $reallyBigNumber = <<<BIGNUMBER
   123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890
   BIGNUMBER
   foo($reallyBigNumber, 2, '12345678901234567890123456789012345678901234567890');
   
   // where are the next arguments ? 
   foo('123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890', 2, '123456789012345678901234567890123456789012345678901234567890');
   
   // This is still difficult to read
   foo(<<<BIGNUMBER
   123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890
   BIGNUMBER
   , 2, '123456789012345678901234567890123456789012345678901234567890');
   
   ?>


Literal strings and heredoc strings, including variables, that are over 50 chars longs are reported here.

+--------------+--------------------------+
| Command Line | Structures/LongArguments |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _lost-references:

Lost References
###############


Either avoid references, or propagate them correctly.

When assigning a referenced variable with another reference, the initial reference is lost, while the intend was to transfer the content. 

.. code-block:: php

   <?php
   
   function foo(&$lostReference, &$keptReference)
   {
       $c = 'c';
   
       // $lostReference was a reference, but now, it is another
       $lostReference =& $c;
       // $keptReference was a reference : now it contains the actual value
       $keptReference = $c;
   }
   
   $bar = 'bar';
   $bar2 = 'bar';
   foo($bar, $bar2); 
   
   //displays bar c, instead of bar bar
   print $bar. ' '.$bar2;
   
   ?>


Do not reassign a reference with another reference. Assign new content to the reference to change its value.

+--------------+--------------------------+
| Command Line | Variables/LostReferences |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _magic-visibility:

Magic Visibility
################


The class magic methods must have public visibility and cannot be static.

.. code-block:: php

   <?php
   
   class foo{
       // magic method must bt public and non-static
       public static function '__clone($name) {    }
   
       // magic method can't be private
       private function '__get($name) {    }
   
       // magic method can't be protected
       private function '__set($name, $value) {    }
   
       // magic method can't be static
       public static function '__isset($name) {    }
   }
   
   ?>


See `Magic methods <http://php.net/manual/en/language.oop5.magic.php>`_.

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Classes/toStringPss                                                                                                                                                                         |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _make-global-a-property:

Make Global A Property
######################


Calling global (or $GLOBALS) in methods is slower and less testable than setting the global to a property, and using this property.

Using properties is slightly faster than calling global or $GLOBALS, though the gain is not important. 

Setting the property in the constructor (or in a factory), makes the class easier to test, as there is now a simple point of configuration.

.. code-block:: php

   <?php 
   
   // Wrong way
   class fooBad {
       function x() {
           global $a;
           $a->do();
           // Or $GLOBALS['a']->do();
       }
   }
   
   class fooGood {
       private $bar = null;
       
       function '__construct() {
           global $bar; 
           $this->bar = $bar;
           // Even better, do this via arguments
       }
       
       function x() {
           $this->a->do();
       }
   }
   
   ?>

+--------------+-----------------------------+
| Command Line | Classes/MakeGlobalAProperty |
+--------------+-----------------------------+
| Analyzers    | :ref:`Analyze`              |
+--------------+-----------------------------+


.. _make-one-call-with-array:

Make One Call With Array
########################


Call preg_replace_call() and `'str_replace() <http://www.php.net/str_replace>`_ with an array.  once with `'preg_replace_callback_array() <http://www.php.net/preg_replace_callback_array>`_.

Calling the same function to chain modifications tends to be slower than calling the same function with all the transformations at the same time. Some PHP functions accept scalars or arrays, and using the later is more efficient.

.. code-block:: php

   <?php
   
   $string = 'abcdef'; 
   
   //'str_replace() accepts arrays as arguments
   $string = str_replace( ['a', 'b', 'c'],
                          ['A', 'B', 'C'],
                          $string);
   
   // Too many calls to str_replace
   $string = str_replace( 'a', 'A', $string);
   $string = str_replace( 'b', 'B', $string);
   $string = str_replace( 'c', 'C', $string);
   
   // Too many nested calls to str_replace
   $string = str_replace( 'a', 'A', str_replace( 'b', 'B', str_replace( 'c', 'C', $string)));
   
   ?>


Potential replacements : 

+-------------------------------------------------------------------------+------------------------------------------------------------------------------------+
| Function                                                                | Replacement                                                                        |
+-------------------------------------------------------------------------+------------------------------------------------------------------------------------+
| `'str_replace() <http://www.php.net/str_replace>`_                      | `'str_replace() <http://www.php.net/str_replace>`_                                 |
| `'str_ireplace() <http://www.php.net/str_ireplace>`_                    | `'str_replace() <http://www.php.net/str_replace>`_                                 |
| `'substr_replace() <http://www.php.net/substr_replace>`_                | `'substr_replace() <http://www.php.net/substr_replace>`_                           |
| `'preg_replace() <http://www.php.net/preg_replace>`_                    | `'preg_replace() <http://www.php.net/preg_replace>`_                               |
| `'preg_replace_callback() <http://www.php.net/preg_replace_callback>`_  | `'preg_replace_callback_array() <http://www.php.net/preg_replace_callback_array>`_ |
+-------------------------------------------------------------------------+------------------------------------------------------------------------------------+

.. code-block:: php

   <?php
   $subject = 'Aaaaaa Bbb';
   
   
   //'preg_replace_callback_array() is better than multiple preg_replace_callback : 
   preg_replace_callback_array(
       [
           '~[a]+~i' => function ($match) {
               echo strlen($match[0]), ' matches for a found', PHP_EOL;
           },
           '~[b]+~i' => function ($match) {
               echo strlen($match[0]), ' matches for b found', PHP_EOL;
           }
       ],
       $subject
   );
   
   $result = preg_replace_callback('~[a]+~i', function ($match) {
               echo strlen($match[0]), ' matches for a found', PHP_EOL;
           }, $subject);
   
   $result = preg_replace_callback('~[b]+~i', function ($match) {
               echo strlen($match[0]), ' matches for b found', PHP_EOL;
           }, $subject);
   
   //'str_replace() accepts arrays as arguments
   $string = str_replace( ['a', 'b', 'c'],
                          ['A', 'B', 'C'],
                          $string);
   
   // Too many calls to str_replace
   $string = str_replace( 'a', 'A');
   $string = str_replace( 'b', 'B');
   $string = str_replace( 'c', 'C');
   
   ?>

+--------------+--------------------------+
| Command Line | Performances/MakeOneCall |
+--------------+--------------------------+
| Analyzers    | :ref:`Performances`      |
+--------------+--------------------------+


.. _malformed-octal:

Malformed Octal
###############


Those numbers starts with a 0, so they are using the PHP octal convention. Therefore, one can't use 8 or 9 figures in those numbers, as they don't belong to the octal base. The resulting number will be truncated at the first erroneous figure. For example, 090 is actually 0, and 02689 is actually 22. 

.. code-block:: php

   <?php
   
   // A long way to write 0 in PHP 5
   $a = 0890; 
   
   // A fatal error since PHP 7
   
   ?>


Also, note that very large octal, usually with more than 21 figures, will be turned into a real number and undergo a reduction in precision.

See also `Integers <http://php.net/manual/en/language.types.integer.php>`_.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Type/MalformedOctal                                                                                        |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _methodcall-on-new:

Methodcall On New
#################


This was added in PHP 5.4+

+--------------+---------------------------+
| Command Line | Php/MethodCallOnNew       |
+--------------+---------------------------+
| Analyzers    | :ref:`CompatibilityPHP53` |
+--------------+---------------------------+


.. _mismatched-ternary-alternatives:

Mismatched Ternary Alternatives
###############################


A ternary operator should yield the same type on both branches.

Ternary operator applies a condition, and yield two different results. Those results will then be processed by code that expects the same types. It is recommended to match the types on both branches of the ternary operator.

.. code-block:: php

   <?php
   
   // $object may end up in a very unstable state
   $object = ($type == 'Type') ? new $type() : null;
   
   //same result are provided by both alternative, though process is very different
   $result = ($type == 'Addition') ? $a + $b : $a * $b;
   
   //Currently, this is omitted
   $a = 1;
   $result = empty($condition) ? $a : 'default value';
   $result = empty($condition) ? $a : getDefaultValue();
   
   ?>

+--------------+------------------------------+
| Command Line | Structures/MismatchedTernary |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _missing-cases-in-switch:

Missing Cases In Switch
#######################


It seems that some cases are missing in this switch structure.

When comparing two differents `'switch() <http://php.net/manual/en/control-structures.switch.php>`_ structures, it appears that some cases are missing in one of them. The set of cases are almost identical, but one of the values are missing. 

Switch() structures using strings as literals are compared in this analysis. When the discrepancy between two lists is below 25%, both switches are reported.

.. code-block:: php

   <?php
   
   // This switch operates on a, b, c, d and default 
   switch($a) {
       case 'a': doSomethingA(); 'break 1;
       case 'b': doSomethingB(); 'break 1;
       case 'c': doSomethingC(); 'break 1;
       case 'd': doSomethingD(); 'break 1;
       default: doNothing();
   }
   
   // This switch operates on a, b, d and default 
   switch($o->p) {
       case 'a': doSomethingA(); 'break 1;
       case 'b': doSomethingB(); 'break 1;
   
       case 'd': doSomethingD(); 'break 1;
       default: doNothing();
   }
   
   ?>


In the example, one may argue that the 'c' case is actually handled by the 'default' case. Otherwise, business logic may request that omission.

+--------------+-------------------------+
| Command Line | Structures/MissingCases |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _mixed-concat-and-interpolation:

Mixed Concat And Interpolation
##############################


Mixed usage of concatenation and string interpolation is error prone. It is harder to read, and leads to overlooking the concatenation or the interpolation.

.. code-block:: php

   <?php
   
   // Concatenation string
   $a = $b . 'c' . $d;
   
   // Interpolation strings
   $a = {$b}c{$d};   // regular form
   $a = {$b}c$d;     // irregular form
   
   // Mixed Concatenation and Interpolation string
   $a = {$b}c . $d;
   $a = $b . c$d;
   $a = $b . c{$d};
   
   ?>


This issue doesn't change the output. It makes code less error prone.

+--------------+----------------------------------------------------------------+
| Command Line | Structures/MixedConcatInterpolation                            |
+--------------+----------------------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>`, :ref:`Analyze` |
+--------------+----------------------------------------------------------------+


.. _mixed-keys-arrays:

Mixed Keys Arrays
#################


Avoid mixing constants and literals in array keys.

When defining default values in arrays, it is recommended to avoid mixing constants and literals, as PHP may mistake them and overwrite the previous with the latter.

Either switch to a newer version of PHP (5.5 or newer), or make sure the resulting array is the one you expect. If not, reorder the definitions.

.. code-block:: php

   <?php
   
   const ONE = 1;
   
   $a = [ 1   => 2,
          ONE => 3];
   
   ?>

+--------------+------------------------------------------------------+
| Command Line | Arrays/MixedKeys                                     |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54` |
+--------------+------------------------------------------------------+


.. _mkdir-default:

Mkdir Default
#############


`'mkdir() <http://www.php.net/mkdir>`_ gives universal access to created folders, by default. It is recommended to gives a more limited set of rights (0755, 0700), or to explicitely set the rights to 0777. 

.. code-block:: php

   <?php
   
   // By default, this dir is 777
   mkdir('/path/to/dir');
   
   // Explicitely, this is wanted. It may also be audited easily
   mkdir('/path/to/dir', 0777);
   
   // This dir is limited to the current user. 
   mkdir('/path/to/dir', 0700);
   
   ?>


See also `Why 777 Folder Permissions are a Security Risk <https://www.spiralscripts.co.uk/Blog/why-777-folder-permissions-are-a-security-risk.html>`_.

+--------------+-----------------------+
| Command Line | Security/MkdirDefault |
+--------------+-----------------------+
| Analyzers    | :ref:`Security`       |
+--------------+-----------------------+


.. _modernize-empty-with-expression:

Modernize Empty With Expression
###############################


`'empty() <http://www.php.net/empty>`_ accept expressions since PHP 5.5. There is no need to store the expression in a variable before testing, unless it is reused later.

.. code-block:: php

   <?php
   
   // PHP 5.5+ 'empty() usage
   if (empty(strtolower($b . $c))) {
       doSomethingWithoutA();
   }
   
   // Compatible 'empty() usage
   $a = strtolower($b . $c);
   if (empty($a)) {
       doSomethingWithoutA();
   }
   
   // $a2 is reused, storage is legit
   $a2 = strtolower($b . $c);
   if (empty($a2)) {
       doSomething();
   } else {
       echo $a2;
   }
   
   ?>

+--------------+------------------------+
| Command Line | Structures/ModernEmpty |
+--------------+------------------------+
| Analyzers    | :ref:`Analyze`         |
+--------------+------------------------+


.. _multiple-alias-definitions:

Multiple Alias Definitions
##########################


Some aliases are representing differents classes across the repository. This leads to potential confusion. 

Across an application, it is recommended to use the same namespace for one alias. Failing to do this lead to the same keyword to represent different values in different files, with different behavior. Those are hard to find bugs. 

.. code-block:: php

   <?php
   
   namespace A {
       use d\d; // aka D
   }
   
   // Those are usually in different files, rather than just different namespaces.
   
   namespace B {
       use b\c as D; // also D. This could be named something else
   }
   
   ?>

+--------------+-------------------------------------+
| Command Line | Namespaces/MultipleAliasDefinitions |
+--------------+-------------------------------------+
| Analyzers    | :ref:`Analyze`                      |
+--------------+-------------------------------------+


.. _multiple-alias-definitions-per-file:

Multiple Alias Definitions Per File
###################################


Avoid aliasing the same name with different aliases. This leads to confusion.

.. code-block:: php

   <?php
   
   // first occurrence
   use name\space\ClasseName;
   
   // when this happens, several other uses are mentionned
   
   // name\space\ClasseName has now two names
   use name\space\ClasseName as anotherName;
   
   ?>


See also `Multiple Alias Definitions`_.

+--------------+-------------------------------------------+
| Command Line | Namespaces/MultipleAliasDefinitionPerFile |
+--------------+-------------------------------------------+
| Analyzers    | :ref:`Analyze`                            |
+--------------+-------------------------------------------+


.. _multiple-class-declarations:

Multiple Class Declarations
###########################


It is possible to declare several times the same class in the code. PHP will not mention it until execution time, since declarations may be conditional. 

.. code-block:: php

   <?php
   
   $a = 1;
   
   // Conditional declaration
   if ($a == 1) {
       class foo {
           function method() { echo 'class 1';}
       }
   } else {
       class foo {
           function method() { echo 'class 2';}
       }
   }
   
   (new foo())->method();
   ?>


It is recommended to avoid declaring several times the same class in the code. The best practice is to separate them with namespaces, they are for here for that purpose. In case those two classes are to be used interchangeably, the best is to use an abstract class or an interface.

+--------------+------------------------------+
| Command Line | Classes/MultipleDeclarations |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _multiple-classes-in-one-file:

Multiple Classes In One File
############################


It is regarded as a bad practice to cram more than one class per file. This is usually done to make life of __autoload() easier. 

It is often difficult to find class foo in the bar.php file. This is also the case for interfaces and traits.

One good reason to have multiple classes in one file is to reduce include time by providing everything into one nice include.

+--------------+------------------------------------------------+
| Command Line | Classes/MultipleClassesInFile                  |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _multiple-constant-definition:

Multiple Constant Definition
############################


Some constants are defined several times in your code. This will lead to a fatal error, if they are defined during the same execution.

+--------------+--------------------------------------+
| Command Line | Constants/MultipleConstantDefinition |
+--------------+--------------------------------------+
| Analyzers    | :ref:`Analyze`                       |
+--------------+--------------------------------------+


.. _multiple-definition-of-the-same-argument:

Multiple Definition Of The Same Argument
########################################


A method's signature is holding twice (or more) the same argument. For example, function x ($a, $a) { ... }. 

This is accepted as is by PHP 5, and the last parameter's value will be assigned to the variable. PHP 7.0 and more recent has dropped this feature, and reports a fatal error when linting the code.

.. code-block:: php

   <?php
     function x ($a, $a) { print $a; };
     x(1,2); => display 2
   ?>


However, this is not common programming practise : all arguments should be named differently.

See also `Prepare for PHP 7 error messages (part 3) <https://www.exakat.io/prepare-for-php-7-error-messages-part-3/>`_.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Functions/MultipleSameArguments                                                                            |
+--------------+------------------------------------------------------------------------------------------------------------+
| clearPHP     | `all-unique-arguments <https://github.com/dseguy/clearPHP/tree/master/rules/all-unique-arguments.md>`__    |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _multiple-exceptions-catch():

Multiple Exceptions Catch()
###########################


Starting with PHP 7.1, it is possible to have several distinct exceptions class caught by the same catch, preventing code repetition. 

.. code-block:: php

   <?php
   
   // PHP 7.1 and more recent
   try {  
       throw new someException(); 
   } catch (Single $s) {
       doSomething();
   } catch (oneType | anotherType $s) {
       processIdentically();
   } finally {
   
   }
   
   // PHP 7.0 and older
   try {  
       throw new someException(); 
   } catch (Single $s) {
       doSomething();
   } catch (oneType $s) {
       processIdentically();
   } catch (anotherType $s) {
       processIdentically();
   } finally {
   
   }
   
   ?>


This is a backward incompabitible feature of PHP 7.1.

+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Exceptions/MultipleCatch                                                                                                              |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+


.. _multiple-identical-trait-or-interface:

Multiple Identical Trait Or Interface
#####################################


There is no need to use the same trait, or implements the same interface  more than once.

Up to PHP 7.1 (at least), this doesn't raise any warning. Traits are only imported once, and interfaces may be implemented as many times as wanted.

.. code-block:: php

   <?php
   
   class foo {
       use t3,t3,t3;
   }
   
   class bar implements i,i,i {
   
   }
   
   ?>

+--------------+----------------------------------+
| Command Line | Classes/MultipleTraitOrInterface |
+--------------+----------------------------------+
| Analyzers    | :ref:`Analyze`                   |
+--------------+----------------------------------+


.. _multiple-index-definition:

Multiple Index Definition
#########################


Indexes that are defined multiple times in the same array. 

.. code-block:: php

   <?php
       // Multiple identical keys
       $x = array(1 => 2, 
                  2 => 3,  
                  1 => 3);
   
       // Multiple identical keys (sneaky version)
       $x = array(1 => 2, 
                  1.1 => 3,  
                  true => 4);
   
       // Multiple identical keys (automated version)
       $x = array(1 => 2, 
                  3,        // This will be index 2
                  2 => 4);  // this index is overwritten
   ?>


They are indeed overwriting each other. This is most probably a typo.

+--------------+------------------------------+
| Command Line | Arrays/MultipleIdenticalKeys |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _multiples-identical-case:

Multiples Identical Case
########################


Some cases are defined multiple times, but only one will be processed. Check the list of cases, and remove the extra one.

Exakat tries to find the value of the case as much as possible, and ignore any dynamic cases (using variables).

.. code-block:: php

   <?php
   
   case ($x) {
       case 1 : 
           'break;
       case true:    // This is a duplicate of the previous
           'break; 
       case 1 + 0:   // This is a duplicate of the previous
           'break; 
       case 1.0 :    // This is a duplicate of the previous
           'break; 
       case $y  :    // This is not reported.
           'break; 
       default:
           
   }
   ?>

+--------------+---------------------------------------------------------------------------------------------------+
| Command Line | Structures/MultipleDefinedCase                                                                    |
+--------------+---------------------------------------------------------------------------------------------------+
| clearPHP     | `no-duplicate-case <https://github.com/dseguy/clearPHP/tree/master/rules/no-duplicate-case.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                    |
+--------------+---------------------------------------------------------------------------------------------------+


.. _multiply-by-one:

Multiply By One
###############


Multiplying by 1 is useless. 

If it is used to type cast a value to number, then casting (integer) or (real) is clearer. This behavior may change with PHP 7.1, which has unified the behavior of all hidden casts. 

.. code-block:: php

   <?php
   
   // Still the same value than $m, but now cast to integer or real
   $m = $m * 1; 
   
   // Still the same value than $m, but now cast to integer or real
   $n *= 1; 
   
   // make typecasting clear, and merge it with the producing call.
   $n = (int) $n;
   
   ?>

+--------------+-----------------------------------------------------------------------------------------------+
| Command Line | Structures/MultiplyByOne                                                                      |
+--------------+-----------------------------------------------------------------------------------------------+
| clearPHP     | `no-useless-math <https://github.com/dseguy/clearPHP/tree/master/rules/no-useless-math.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                |
+--------------+-----------------------------------------------------------------------------------------------+


.. _must-return-methods:

Must Return Methods
###################


The following methods are expected to return a value that will be used later. Without return, they are useless.

Methods that must return are : `'__get() <http://php.net/manual/en/language.oop5.magic.php>`_, `'__isset() <http://php.net/manual/en/language.oop5.magic.php>`_, `'__sleep() <http://php.net/manual/en/language.oop5.magic.php>`_, `'__toString() <http://php.net/manual/en/language.oop5.magic.php>`_, `'__set_state() <http://php.net/manual/en/language.oop5.magic.php>`_, `'__invoke() <http://php.net/manual/en/language.oop5.magic.php>`_, `'__debugInfo() <http://php.net/manual/en/language.oop5.magic.php>`_.
Methods that may not return, but are often expected to : `'__call() <http://php.net/manual/en/language.oop5.magic.php>`_, `'__callStatic() <http://php.net/manual/en/language.oop5.magic.php>`_.


.. code-block:: php

   <?php
   
   class foo {
       public function '__isset($a) {
           // returning something useful
           return 'isset($this->$var[$a]);
       }
   
       public function '__get($a) {
           $this->$a++;
           // not returning... 
       }
   
       public function '__call($name, $args) {
           $this->$name(...$args);
           // not returning anything, but that's OK
       }
   
   }
   ?>

+--------------+----------------------+
| Command Line | Functions/MustReturn |
+--------------+----------------------+
| Analyzers    | :ref:`Analyze`       |
+--------------+----------------------+


.. _negative-power:

Negative Power
##############


The power operator `'** <http://php.net/manual/en/language.operators.arithmetic.php>`_ has higher precedence than the sign operators + and -.

This means that -2 `'** <http://php.net/manual/en/language.operators.arithmetic.php>`_ 2 == -4. It is in fact, -(2 `'** <http://php.net/manual/en/language.operators.arithmetic.php>`_ 2). 

When using negative power, it is clearer to add parenthesis or to use the `'pow() <http://www.php.net/pow>`_ function, which has no such ambiguity : 

.. code-block:: php

   <?php
   
   // -2 to the power of 2 (a square)
   pow(-2, 2) == 4;
   
   // minus 2 to the power of 2 (a negative square)
   -2 '** 2 == -(2 '** 2) == 4;
   
   ?>

+--------------+------------------------+
| Command Line | Structures/NegativePow |
+--------------+------------------------+
| Analyzers    | :ref:`Analyze`         |
+--------------+------------------------+


.. _nested-ifthen:

Nested Ifthen
#############


Three levels of ifthen is too much. The method should be split into smaller functions.

.. code-block:: php

   <?php
   
   function foo($a, $b) {
       if ($a == 1) {
           // Second level, possibly too much already
           if ($b == 2) {
               
           }
       }
   }
   
   function bar($a, $b, $c) {
       if ($a == 1) {
           // Second level. 
           if ($b == 2) {
               // Third level level. 
               if ($c == 3) {
                   // Too much
               }
           }
       }
   }
   
   ?>

+--------------+-------------------------+
| Command Line | Structures/NestedIfthen |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _nested-ternary:

Nested Ternary
##############


Ternary operators should not be nested too deep.

They are a convenient instruction to apply some condition, and avoid a if() structure. It works best when it is simple, like in a one liner. 

However, ternary operators tends to make the syntax very difficult to read when they are nested. It is then recommended to use an if() structure, and make the whole code readable.

.. code-block:: php

   <?php
   
   // Simple ternary expression
   echo ($a == 1 ? $b : $c) ;
   
   // Nested ternary expressions
   echo ($a === 1 ? $d === 2 ? $b : $d : $d === 3 ? $e : $c) ;
   echo ($a === 1 ? $d === 2 ? $f ===4 ? $g : $h : $d : $d === 3 ? $e : $i === 5 ? $j : $k) ;
   
   //Previous expressions, written as a if / Then expression
   if ($a === 1) {
       if ($d === 2) {
           echo $b;
       } else {
           echo $d;
       }
   } else {
       if ($d === 3) {
           echo $e;
       } else {
           echo $c;
       }
   }
   
   if ($a === 1) {
       if ($d === 2) {
           if ($f === 4) {
               echo $g;
           } else {
               echo $h;
           }
       } else {
           echo $d;
       }
   } else {
       if ($d === 3) {
           echo $e;
       } else {
           if ($i === 5) {
               echo $j;
           } else {
               echo $k;
           }
       }
   }
   
   ?>

+--------------+---------------------------------------------------------------------------------------------------+
| Command Line | Structures/NestedTernary                                                                          |
+--------------+---------------------------------------------------------------------------------------------------+
| clearPHP     | `no-nested-ternary <https://github.com/dseguy/clearPHP/tree/master/rules/no-nested-ternary.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                    |
+--------------+---------------------------------------------------------------------------------------------------+


.. _never-used-properties:

Never Used Properties
#####################


Properties that are never used. They are defined, but never actually used.

.. code-block:: php

   <?php
   
   class foo {
       public $usedProperty = 1;
   
       // Never used anywhere
       public $unusedProperty = 2;
       
       function bar() {
           // Used internally
           ++$this->usedProperty;
       }
   }
   
   class foo2  extends foo {
       function bar2() {
           // Used in child class
           ++$this->usedProperty;
       }
   }
   
   // Used externally
   ++$this->usedProperty;
   
   ?>

+--------------+---------------------------+
| Command Line | Classes/PropertyNeverUsed |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _new-constants-in-php-7.2:

New Constants In PHP 7.2
########################


The following constants are now native in PHP 7.2. It is advised to avoid using such names for constant before moving to this new version.

* PHP_OS_FAMILY
* PHP_FLOAT_DIG
* PHP_FLOAT_EPSILON
* PHP_FLOAT_MAX
* PHP_FLOAT_MIN
* SQLITE3_DETERMINISTIC
* CURLSSLOPT_NO_REVOKE
* CURLOPT_DEFAULT_PROTOCOL
* CURLOPT_STREAM_WEIGHT
* CURLMOPT_PUSHFUNCTION
* CURL_PUSH_OK
* CURL_PUSH_DENY
* CURL_HTTP_VERSION_2TLS
* CURLOPT_TFTP_NO_OPTIONS
* CURL_HTTP_VERSION_2_PRIOR_KNOWLEDGE
* CURLOPT_CONNECT_TO
* CURLOPT_TCP_FASTOPEN
* DNS_CAA

Note : PHP 7.2 is not out yet (2017-04-10). This list is currently temporary and may undergo changes until the final version is out.

+--------------+------------------------------------------------------+
| Command Line | Php/Php72NewConstants                                |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------+


.. _new-functions-in-php-5.4:

New Functions In PHP 5.4
########################


PHP introduced new functions in PHP 5.4. If you have already defined functions with such names, you will get a conflict when trying to upgrade. It is advised to change those functions' name.

+--------------+------------------------------------------------------+
| Command Line | Php/Php54NewFunctions                                |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP71` |
+--------------+------------------------------------------------------+


.. _new-functions-in-php-5.5:

New Functions In PHP 5.5
########################


PHP introduced new functions in PHP 5.5. If you have already defined functions with such names, you will get a conflict when trying to upgrade. It is advised to change those functions' name.

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/Php55NewFunctions                                                           |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP71` |
+--------------+---------------------------------------------------------------------------------+


.. _new-functions-in-php-5.6:

New Functions In PHP 5.6
########################


PHP introduced new functions in PHP 5.6. If you have already defined functions with such names, you will get a conflict when trying to upgrade. It is advised to change those functions' name.

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/Php56NewFunctions                                                           |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55` |
+--------------+---------------------------------------------------------------------------------+


.. _new-functions-in-php-7.0:

New Functions In PHP 7.0
########################


The following functions are now native functions in PHP 7.0. It is advised to change them before moving to this new version.

* get_resources
* gc_mem_caches
* preg_replace_callback_array
* posix_setrlimit
* random_bytes
* random_int
* intdiv
* error_clear_last

+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/Php70NewFunctions                                                                                                                 |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+


.. _new-functions-in-php-7.1:

New Functions In PHP 7.1
########################


The following functions are now native functions in PHP 7.1. It is advised to change them before moving to this new version.

* curl_share_strerror()
* curl_multi_errno()
* curl_share_errno()
* mb_ord()
* mb_chr()
* mb_scrub()
* is_iterable()

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/Php71NewFunctions                                                           |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------+


.. _new-functions-in-php-7.2:

New Functions In PHP 7.2
########################


The following functions are now native functions in PHP 7.2. It is advised to change them before moving to this new version.

* mb_ord()
* mb_chr()
* mb_scrub()
* stream_isatty()
* `'proc_nice() <http://www.php.net/proc_nice>`_ (Windows only)

+--------------+------------------------------------------------------+
| Command Line | Php/Php72NewFunctions                                |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------+


.. _new-functions-in-php-7.3:

New Functions In PHP 7.3
########################


This documentation is still empty.

The following functions are now native functions in PHP 7.3. It is advised to change them before moving to this new version.

*

+--------------+---------------------------+
| Command Line | Php/Php73NewFunctions     |
+--------------+---------------------------+
| Analyzers    | :ref:`CompatibilityPHP73` |
+--------------+---------------------------+


.. _no-boolean-as-default:

No Boolean As Default
#####################


Default values should always be set up with constants.

Class constants or constants improve readability when calling the methods.

.. code-block:: php

   <?php
   
   const CASE_INSENSITIVE = true;
   const CASE_SENSITIVE = false;
   
   function foo($case_insensitive = true) {
       // doSomething()
   }
   
   // Readable code 
   foo(CASE_INSENSITIVE);
   foo(CASE_SENSITIVE);
   
   
   // unreadable code  : is true case insensitive or case sensitive ? 
   foo(true);
   foo(false);
   
   ?>

+--------------+------------------------------+
| Command Line | Functions/NoBooleanAsDefault |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _no-choice:

No Choice
#########


A conditional structure is being used, but both alternatives are the same, leading to the illusion of choice. 

Either the condition is useless, and may be removed, or the alternatives needs to be distinguished.

.. code-block:: php

   <?php
   
   if ($condition == 2) {
       doSomething();
   } else {
       doSomething();
   }
   
   $condition == 2 ?     doSomething() :     doSomething();
   
   ?>

+--------------+---------------------+
| Command Line | Structures/NoChoice |
+--------------+---------------------+
| Analyzers    | :ref:`Analyze`      |
+--------------+---------------------+


.. _no-class-as-typehint:

No Class As Typehint
####################


Avoid using whole classes as typehint. Always use interfaces, so that you may use different classes, or versions of classes. 

.. code-block:: php

   <?php
   
   class X {
       function foo() {}
   }
   
   interface i {
       function foo();
   }
   
   // X is a class : any update in the code requires changing / subclassing X or the rest of the code.
   function bar(X $x) {
       $x->foo();
   }
   
   // I is an interface : X may implements this interface without refactoring and pass
   // later, newer versions of X may get another name, but still implement I, and still pass
   function bar2(I $x) {
       $x->foo();
   }
   
   ?>


See also `Type hinting for interfaces <http://phpenthusiast.com/object-oriented-php-tutorials/type-hinting-for-interfaces>`_.

+--------------+-----------------------------+
| Command Line | Functions/NoClassAsTypehint |
+--------------+-----------------------------+
| Analyzers    | :ref:`Analyze`              |
+--------------+-----------------------------+


.. _no-class-in-global:

No Class In Global
##################


Avoid defining structures in Global namespace. Always prefer using a namespace. This will come handy later, either when publishing the code, or when importing a library, or even if PHP reclaims that name. 

.. code-block:: php

   <?php
   
   // Code prepared for later
   namespace Foo {
       class Bar {}
   }
   
   // Code that may conflict with other names.
   namespace {
       class Bar {}
   }
   
   ?>

+--------------+---------------------+
| Command Line | Php/NoClassInGlobal |
+--------------+---------------------+
| Analyzers    | :ref:`Analyze`      |
+--------------+---------------------+


.. _no-count-with-0:

No Count With 0
###############


Comparing `'count() <http://www.php.net/count>`_ and strlen() to 0 is a waste of resources. There are three distinct situations situations.

When comparing `'count() <http://www.php.net/count>`_ with 0, with ===, ==, !==, !=, it is more efficient to use `'empty() <http://www.php.net/empty>`_. Empty() is a language constructs that checks if a value is present, while `'count() <http://www.php.net/count>`_ actually load the number of element.

.. code-block:: php

   <?php
   
   // Checking if an array is empty
   if (count($array) == 0) {
       // doSomething();
   }
   // This may be replaced with 
   if (empty($array)) {
       // doSomething();
   }
   
   ?>


When comparing `'count() <http://www.php.net/count>`_ strictly with 0 (>) it is more efficient to use !(`'empty()) <http://www.php.net/empty>`_

.. code-block:: php

   <?php
   
   // Checking if an array is empty
   if (count($array) > 0) {
       // doSomething();
   }
   // This may be replaced with 
   if (!empty($array)) {
       // doSomething();
   }
   
   Of course comparing 'count() with negative values, or with >= is useless.
   
   <?php
   
   // Checking if an array is empty
   if (count($array) < 0) {
       // This never happens
       // doSomething();
   }
   
   ?>


Comparing `'count() <http://www.php.net/count>`_ and strlen() with other values than 0 cannot be replaced with a comparison with `'empty() <http://www.php.net/empty>`_.

Note that this is a micro-optimisation : since PHP keeps track of the number of elements in arrays (or number of chars in strings), the total computing time of both operations is often lower than a ms. However, both functions tends to be heavily used, and may even be used inside loops.

+--------------+---------------------------+
| Command Line | Performances/NotCountNull |
+--------------+---------------------------+
| Analyzers    | :ref:`Performances`       |
+--------------+---------------------------+


.. _no-direct-call-to-magic-method:

No Direct Call To Magic Method
##############################


PHP magic methods, such as `'__get() <http://php.net/manual/en/language.oop5.magic.php>`_, `'__set() <http://php.net/manual/en/language.oop5.magic.php>`_, ... are supposed to be used in an object environnement, and not with direct call. 

For example, 

.. code-block:: php

   <?php
     print $x->'__get('a'); 
   
   //should be written 
     print $x->a;
   ?>


Accessing those methods in a static way is also discouraged.

+--------------+---------------------------------+
| Command Line | Classes/DirectCallToMagicMethod |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`                  |
+--------------+---------------------------------+


.. _no-direct-usage:

No Direct Usage
###############


The results of the following functions shouldn't be used directly, but checked first. 

For example, `'glob() <http://www.php.net/glob>`_ returns an array, unless some error happens, in which case it returns a boolean (false). In such case, however rare it is, plugging `'glob() <http://www.php.net/glob>`_ directly in a `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_ loops will yield errors.

.. code-block:: php

   <?php
       // Used without check : 
       foreach(glob('.') as $file) { /* do Something */ }.
       
       // Used without check : 
       $files = glob('.');
       if (!is_array($files)) {
           foreach($files as $file) { /* do Something */ }.
       }
   ?>

+--------------+--------------------------+
| Command Line | Structures/NoDirectUsage |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _no-echo-in-route-callable:

No Echo In Route Callable
#########################


Avoid using echo(), `'print() <http://www.php.net/print>`_ or any printable PHP within the route callable method. 

echo() works, it is prevents the code from setting any status code. This leads to confusion when the code return the content, but fail to set the right HTTP codes.

Slim 4.0 will require to only use the return method : the route callable is required to return a response. 

.. code-block:: php

   <?php
   $app = new Slim\App();
   
   // This works as expected, with or without status
   $app->get('/', function ($request, $response, $args) {
       return new MyResponseInterface ('content');
   });
   
   // This works, but only on surface
   $app->get('/', function ($request, $response, $args) {
       echo 'content';
   });
   
   ?>


See `PSR7 <http://www.php-fig.org/psr/psr-7/>`_ and `PSR 7 and Value Objects <https://www.slimframework.com/docs/concepts/value-objects.html>`_.

+--------------+----------------------------+
| Command Line | Slim/NoEchoInRouteCallable |
+--------------+----------------------------+
| Analyzers    | :ref:`Slim`                |
+--------------+----------------------------+


.. _no-empty-regex:

No Empty Regex
##############


PHP regex don't accept empty regex, nor regex with alphanumeric delimiter.

Most of those errors happen at execution time, when the regex is build dynamically, but still may end empty. At compile time, such error are made when the code is not tested before commit.

.. code-block:: php

   <?php
   
   // No empty regex
   preg_match('', $string, $r); 
   
   // Delimiter must be non-alphanumerical
   preg_replace('1abc1', $string, $r); 
   
   // Delimiter must be non-alphanumerical
   preg_replace('1'.$regex.'1', $string, $r); 
   
   ?>


See also `PCRE <http://php.net/pcre>`_ and `Delimiters <http://php.net/manual/en/regexp.reference.delimiters.php>`_.

+--------------+-------------------------+
| Command Line | Structures/NoEmptyRegex |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _no-global-modification:

No Global Modification
######################


Avoid modifying directly Wordpress global variables.

It is recommended to use the function API instead.

.. code-block:: php

   <?php
   
   my_hook() {
       // Avoid changing those variables, as Wordpress handles them
       $GLOBALS['is_safari'] = true;
   }
   
   ?>


See also `Global Variables <https://codex.wordpress.org/Global_Variables>`_

+--------------+--------------------------------+
| Command Line | Wordpress/NoGlobalModification |
+--------------+--------------------------------+
| Analyzers    | :ref:`Wordpress`               |
+--------------+--------------------------------+


.. _no-hardcoded-hash:

No Hardcoded Hash
#################


Hash should never be hardcoded. 

Hashes may be MD5, SHA1, SHA512, Bcrypt or any other. Such values must be easily changed, for security reasons, and the source code is not the safest place to hide it. 

.. code-block:: php

   <?php
   
       // Those strings may be sha512 hashes. 
       // it is recomemdned to check if they are static or should be put into configuration
       $init512 = array( // initial values for SHA512
           '6a09e667f3bcc908', 'bb67ae8584caa73b', '3c6ef372fe94f82b', 'a54ff53a5f1d36f1', 
       );
   
   ?>

+--------------+---------------------------------+
| Command Line | Structures/NoHardcodedHash      |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Security` |
+--------------+---------------------------------+


.. _no-hardcoded-ip:

No Hardcoded Ip
###############


Do not leave hard coded IP in your code.

It is recommended to move such configuration in external files or databases, for each update. 
This may also come handy when testing. 

.. code-block:: php

   <?php
   
   // This IPv4 is hardcoded. 
   $ip = '183.207.224.50';
   // This IPv6 is hardcoded. 
   $ip = '2001:0db8:85a3:0000:0000:8a2e:0370:7334';
   
   // This looks like an IP
   $thisIsNotAnIP = '213.187.99.50';
   $thisIsNotAnIP = '2133:1387:9393:5330';
   
   ?>


127.0.0.1, ::1 and ::0 are omitted, and not considered as a violation.

+--------------+---------------------------------+
| Command Line | Structures/NoHardcodedIp        |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Security` |
+--------------+---------------------------------+


.. _no-hardcoded-path:

No Hardcoded Path
#################


It is not recommended to have literals when accessing files. 

Either use `'__FILE__ <http://php.net/manual/en/language.constants.predefined.php>`_ and `'__DIR__ <http://php.net/manual/en/language.constants.predefined.php>`_ to make the path relative to the current file; use a DOC_ROOT as a configuration constant that will allow you to move your script later or rely on functions likes `'sys_get_temp_dir() <http://www.php.net/sys_get_temp_dir>`_, to reach special folders.

.. code-block:: php

   <?php
   
       // This depends on the current executed script
       file_get_contents('token.txt');
   
       // Exotic protocols are ignored
       file_get_contents('jackalope://file.txt');
   
       // Some protocols are ignored : http, https, ftp, ssh2, php (with memory)
       file_get_contents('http://www.php.net/');
       file_get_contents('php://memory/');
       
       // 'glob() with special chars * and ? are not reported
       glob('./*/foo/bar?.txt');
       // 'glob() without special chars * and ? are reported
       glob('/foo/bar/');
       
   ?>

+--------------+---------------------------------------------------------------------------------------------------+
| Command Line | Structures/NoHardcodedPath                                                                        |
+--------------+---------------------------------------------------------------------------------------------------+
| clearPHP     | `no-hardcoded-path <https://github.com/dseguy/clearPHP/tree/master/rules/no-hardcoded-path.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                    |
+--------------+---------------------------------------------------------------------------------------------------+


.. _no-hardcoded-port:

No Hardcoded Port
#################


When connecting to a remove serve, port is an important information. It is recommended to make this configurable (with constant or configuration), to as to be able to change this value without changing the code.

+--------------+---------------------------------+
| Command Line | Structures/NoHardcodedPort      |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Security` |
+--------------+---------------------------------+


.. _no-implied-if:

No Implied If
#############


It is possible to emulate a if/then structure by using the operators 'and' and 'or'. Since optimizations will be applied to them : 
when the left operand of 'and' is false, the right one is not executed, as its result is useless; 
when the left operand of 'or' is true, the right one is not executed, as its result is useless; 

However, such structures are confusing. It is easy to misread them as conditions, and ignore an important logic step. 

.. code-block:: php

   <?php
   
   // Either connect, or 'die
   mysql_connect('localhost', $user, $pass) or 'die();
   
   // Defines a constant if not found. 
   defined('SOME_CONSTANT') and define('SOME_CONSTANT', 1);
   
   ?>


It is recommended to use a real 'if then' structures, to make the condition readable.

+--------------+-------------------------------------------------------------------------------------------+
| Command Line | Structures/ImpliedIf                                                                      |
+--------------+-------------------------------------------------------------------------------------------+
| clearPHP     | `no-implied-if <https://github.com/dseguy/clearPHP/tree/master/rules/no-implied-if.md>`__ |
+--------------+-------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                            |
+--------------+-------------------------------------------------------------------------------------------+


.. _no-isset-with-empty:

No Isset With Empty
###################


Empty() actually does the job of Isset() too. 

From the manual : No warning is generated if the variable does not exist. That means `'empty() <http://www.php.net/empty>`_ is essentially the concise equivalent to !`'isset( <http://www.php.net/isset>`_$var) || $var == false.

.. code-block:: php

   <?php
   
   
   // Enough tests
   if (i!empty($a)) {
       doSomething();
   }
   
   // Too many tests
   if ('isset($a) && !empty($a)) {
       doSomething();
   }
   
   ?>

+--------------+-----------------------------+
| Command Line | Structures/NoIssetWithEmpty |
+--------------+-----------------------------+
| Analyzers    | :ref:`Analyze`              |
+--------------+-----------------------------+


.. _no-list-with-string:

No List With String
###################


list() can't be used anymore to access particular offset in a string. This should be done with substr() or $string[$offset] syntax.

.. code-block:: php

   <?php
   
   $x = 'abc';
   list($a, $b, $c) = $x;
   
   //list($a, $b, $c) = 'abc'; Never works
   
   print $c;
   // PHP 5.6- displays 'c'
   // PHP 7.0+ displays nothing
   
   ?>


See also `PHP 7.0 Backward incompatible changes <http://php.net/manual/en/migration70.incompatible.php>`_ : list() can no longer unpack string variables.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/NoListWithString                                                                                       |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _no-need-for-else:

No Need For Else
################


Else is not needed when the Then ends with a `'break <http://php.net/manual/en/control-structures.break.php>`_. A `'break <http://php.net/manual/en/control-structures.break.php>`_ may be the following keywords : `'break <http://php.net/manual/en/control-structures.break.php>`_, `'continue <http://php.net/manual/en/control-structures.continue.php>`_, return, goto. Any of these send the execution somewhere in the code. The else block is then executed as the main sequence, only if the condition fails.

.. code-block:: php

   <?php
   
   function foo() {
       // Else may be in the main sequence.
       if ($a1) {
           return $a1;
       } else {
           $a++;
       }
   
       // Same as above, but negate the condition : if (!$a2) { return $a2; }
       if ($a2) {
           $a++;
       } else {
           return $a2;
       }
   
       // This is OK
       if ($a3) {
           return;
       }
   
       // This has no 'break
       if ($a4) {
           $a++;
       } else {
           $b++;
       }
   
       // This has no else
       if ($a5) {
           $a++;
       }
   }
   ?>


See also `Object Calisthenics <http://williamdurand.fr/2013/06/03/object-calisthenics/>`_, rule number 2.

+--------------+--------------------------+
| Command Line | Structures/NoNeedForElse |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _no-parenthesis-for-language-construct:

No Parenthesis For Language Construct
#####################################


Some PHP language constructs, such are include, print, echo don't need parenthesis. They will handle parenthesis, but it is may lead to strange situations. 

It it better to avoid using parenthesis with echo, print, return, throw, include and require (and _once).

+--------------+-------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/NoParenthesisForLanguageConstruct                                                                                              |
+--------------+-------------------------------------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-parenthesis-for-language-construct <https://github.com/dseguy/clearPHP/tree/master/rules/no-parenthesis-for-language-construct.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                                                            |
+--------------+-------------------------------------------------------------------------------------------------------------------------------------------+


.. _no-plus-one:

No Plus One
###########


Incrementing a variable should be done with the ++ or -- operators. Any other way, may be avoided.

.. code-block:: php

   <?php
   
   // Best way to increment
   ++$x; --$y;
   
   // Second best way to increment, if the current value is needed :
   echo $x++, $y--;
   
   // Good but slow 
   $x += 1; 
   $x -= -1; 
   
   $y += -1;
   $y -= 1;
   
   // even slower
   $x = $x + 1; 
   $y = $y - 1; 
   
   ?>

+--------------+------------------------------------------------+
| Command Line | Structures/PlusEgalOne                         |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _no-public-access:

No Public Access
################


The properties below are declared with public access, but are never used publicly. They can be made protected or private.

.. code-block:: php

   <?php
   
   class foo {
       public $bar = 1;            // Public, and used in public space
       public $neverInPublic = 3;  // Public, but never used in outside the class
       
       function bar() {
           $neverInPublic++;
       }
   }
   
   $x = new foo();
   $x->bar = 3;
   $x->bar();
   
   ?>

+--------------+------------------------+
| Command Line | Classes/NoPublicAccess |
+--------------+------------------------+
| Analyzers    | :ref:`Analyze`         |
+--------------+------------------------+


.. _no-real-comparison:

No Real Comparison
##################


Avoid comparing decimal numbers with ==, ===, !==, !=. Real numbers have an error margin which is random, and makes it very difficult to match even if the compared value is a literal. 

PHP uses an internal representation in base 2 : any number difficult to represent with this base (like 0.1 or 0.7) will have a margin of error.

.. code-block:: php

   <?php
   
   $a = 1/7;
   $b = 2.0;
   
   // 7 * $a is a real, not an integer
   var_dump( 7 * $a === 1);
   
   // rounding error leads to wrong comparison
   var_dump( (0.1 + 0.7) * 10 == 8);
   // although
   var_dump( (0.1 + 0.7) * 10);
   // displays 8
   
   // precision formula to use with reals. Adapt 0.0001 to your precision needs
   var_dump( abs(((0.1 + 0.7) * 10) - 8) < 0.0001); 
   
   ?>


Use precision formulas with `'abs() <http://www.php.net/abs>`_ to approximate values with a given precision, or avoid reals altogether.

+--------------+-----------------------------------------------------------------------------------------------------+
| Command Line | Type/NoRealComparison                                                                               |
+--------------+-----------------------------------------------------------------------------------------------------+
| clearPHP     | `no-real-comparison <https://github.com/dseguy/clearPHP/tree/master/rules/no-real-comparison.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                      |
+--------------+-----------------------------------------------------------------------------------------------------+


.. _no-return-or-throw-in-finally:

No Return Or Throw In Finally
#############################


Avoid using return and throw in a finally block. Both command will interrupt the processing of the try catch block, and any exception that was emitted will not be processed. This leads to unprocessed exceptions, leaving the application in an unstable state.

Note that PHP prevents the usage of goto, `'break <http://php.net/manual/en/control-structures.break.php>`_ and `'continue <http://php.net/manual/en/control-structures.continue.php>`_ within the finally block at linting phase. This is categorized as a Security problem.

.. code-block:: php

   <?php
   function foo() {
           try {
               // Exception is thrown here 
               throw new \Exception();
           } catch (Exception $e) {
               // This is executed AFTER finally
               return 'Exception';
           } finally {
               // This is executed BEFORE catch
               return 'Finally';
           }
       }
   }
   
   // Displays 'Finally'. No exception
   echo foo();
   
   function bar() {
           try {
               // Exception is thrown here 
               throw new \Exception();
           } catch (Exception $e) {
               // Process the exception. 
               return 'Exception';
           } finally {
               // clean the current situation
               // Keep running the current function
           }
           return 'Finally';
       }
   }
   
   // Displays 'Exception', with processed Exception
   echo bar();
   
   ?>


See also `Return Inside Finally Block <https://www.owasp.org/index.php/Return_Inside_Finally_Block>`_.

+--------------+------------------------------+
| Command Line | Structures/NoReturnInFinally |
+--------------+------------------------------+
| Analyzers    | :ref:`Security`              |
+--------------+------------------------------+


.. _no-return-used:

No Return Used
##############


The return value of the following functions are never used. The return argument may be dropped from the code, as it is dead code.

This analysis supports functions and static methods, when a definition may be found. It doesn't support method calls.

.. code-block:: php

   <?php
   
   function foo($a = 1;) { return 1; }
   foo();
   foo();
   foo();
   foo();
   foo();
   foo();
   
   // This function doesn't return anything. 
   function foo2() { }
   
   // The following function are used in an expression, thus the return is important
   function foo3() {  return 1;}
   function foo4() {  return 1;}
   function foo5() {  return 1;}
   
   foo3() + 1; 
   $a = foo4();
   foo(foo5());
   
   ?>

+--------------+------------------------+
| Command Line | Functions/NoReturnUsed |
+--------------+------------------------+
| Analyzers    | :ref:`Analyze`         |
+--------------+------------------------+


.. _no-self-referencing-constant:

No Self Referencing Constant
############################


It is not possible to use 'self' when defining a constant in a class. It will yield a fatal error at runtime. 

.. code-block:: php

   <?php
       class a { 
           const C1 = 1; 
           const C2 = self::C1; 
           const C3 = a::C3; 
       }
   ?>


The code needs to reference the full class's name to do so, without using the current class's name. 

.. code-block:: php

   <?php
       class a { 
           const C1 = 1; 
           const C2 = a::C1; 
       }
   ?>

+--------------+-----------------------------------+
| Command Line | Classes/NoSelfReferencingConstant |
+--------------+-----------------------------------+
| Analyzers    | :ref:`Analyze`                    |
+--------------+-----------------------------------+


.. _no-string-with-append:

No String With Append
#####################


PHP 7 doesn't allow the usage of [] with strings. [] is an array-only oeprator.

.. code-block:: php

   <?php
   
   $string = 'abc';
   
   // Not possible in PHP 7
   $string[] = 'd';
   
   ?>


This was possible in PHP 5.*, but is now forbidden in PHP 7.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/NoStringWithAppend                                                                                     |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _no-substr()-one:

No Substr() One
###############


Use array notation $string[$position] to reach a single byte in a string.

There are two ways to access a byte in a string : substr() and $v[$pos];

The second one is more readable. It may be up to four times faster, though it is a micro-optimization. 
It is recommended to use it. 

PHP 7.1 also introduces the support of negative offsets as string index : negative offset are also reported here.

.. code-block:: php

   <?php
   
   $string = ab人cde;
   
   echo substr($string, $pos, 1);
   echo $string[$pos];
   echo mb_substr($string, $pos, 1);
   
   // $pos = 1
   // bbb
   // $pos = 2
   // ??人
   
   ?>


Beware that substr() and $v[$pos] are similar, while `'mb_substr() <http://www.php.net/mb_substr>`_ is not. The first functions works on bytes, while the latter works on characters.

+--------------+----------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/NoSubstrOne                                                                                               |
+--------------+----------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Performances`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+----------------------------------------------------------------------------------------------------------------------+


.. _no-array\_merge()-in-loops:

No array_merge() In Loops
#########################


`'array_merge() <http://www.php.net/array_merge>`_ is memory intensive : every call will duplicate the arguments in memory, before merging them. 

Since arrays may be quite big, it is recommended to avoid using `'array_merge() <http://www.php.net/array_merge>`_ in a loop. Instead, one should use `'array_merge() <http://www.php.net/array_merge>`_ with as many arguments as possible, making the merge a on time call.

.. code-block:: php

   <?php
   
   // Creating a large multidimensional array
   $source = ['a' => ['a', 'b', /*...*/],
              'b' => ['b', 'c', 'd', /*...*/],
              /*...*/
              ];
   
   // Slow way
   $b = array();
   foreach($source as $key => $values) {
       $b = array_merge($b, $values);
   }
   
   // Faster way
   $b = array();
   foreach($source as $key => $values) {
       //Collect in an array
       $b[] = $values;
   }
   // One call to array_merge
   $b = call_user_func_array('array_merge', $b);
   // or with variadic
   $b = call_user_func('array_merge', ..$b);
   
   // Fastest way (with above example, without checking nor data pulling)
   $b = call_user_func_array('array_merge', array_values($source))
   // or
   $b = call_user_func('array_merge', ...array_values($source))
   
   ?>


Note that `'array_merge_recursive() <http://www.php.net/array_merge_recursive>`_ and `'file_put_contents() <http://www.php.net/file_put_contents>`_ are also affected and reported.

+--------------+-------------------------------------------------------------------------------------------------------------+
| Command Line | Performances/ArrayMergeInLoops                                                                              |
+--------------+-------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-array_merge-in-loop <https://github.com/dseguy/clearPHP/tree/master/rules/no-array_merge-in-loop.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Performances`                                                                         |
+--------------+-------------------------------------------------------------------------------------------------------------+


.. _non-ascii-variables:

Non Ascii Variables
###################


PHP supports variables with certain characters. The variable name must only include letters, figures, underscores and ASCII characters from 128 to 255. 

In practice, letters outside the scope of a-zA-Z0-9 are rare, and require more care when editing the code or passing it from OS to OS. 

.. code-block:: php

   <?php
   
   class 人 {
       // An actual working class in PHP.
       public function '__construct() {
           echo '__CLASS__;
       }
   }
   
   $people = new 人();
   
   ?>


See also `Variables <http://php.net/manual/en/language.variables.basics.php>`_.

+--------------+----------------------------+
| Command Line | Variables/VariableNonascii |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _non-static-methods-called-in-a-static:

Non Static Methods Called In A Static
#####################################


Static methods have to be declared as such (using the static keyword). Then, 
one may call them without instantiating the object.

However, PHP doesn't check that a method is static or not : at any point, you may call one
method statically : 

.. code-block:: php

   <?php
       class x {
           static public function sm( ) { echo '__METHOD__.\n; }
           public public sm( ) { echo '__METHOD__.\n; }
       } 
       
       x::sm( ); // echo x::sm 
   ?>


It is a bad idea to call non-static method statically. Such method may make use of special
variable $this, which will be undefined. PHP will not check those calls at compile time,
nor at running time. 

It is recommended to update this situation : make the method actually static, or use it only 
in object context.

Note that this analysis reports all static method call made on a non-static method,
even within the same class or class hierarchy. PHP silently accepts static call to any
in-family method.

.. code-block:: php

   <?php
       class x {
           public function foo( ) { self::bar() }
           public function bar( ) { echo '__METHOD__.\n; }
       } 
   ?>

+--------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Classes/NonStaticMethodsCalledStatic                                                                                                                  |
+--------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _non-constant-index-in-array:

Non-constant Index In Array
###########################


Undefined constants revert as strings in Arrays. They are also called barewords.

In '$array[index]', PHP cannot find index as a constant, but, as a default behavior, turns it into the string 'index'. 

This default behavior raise concerns when a corresponding constant is defined, either using `'define() <http://www.php.net/define>`_ or the const keyword (outside a class). The definition of the index constant will modify the behavior of the index, as it will now use the constant definition, and not the 'index' string. 

.. code-block:: php

   <?php
   
   // assign 1 to the element index in $array
   // index will fallback to string
   $array[index] = 1; 
   //PHP Notice:  Use of undefined constant index - assumed 'index'
   
   echo $array[index];      // display 1 and the above error
   echo $array[index];    // display 1
   echo $array[index];  // Syntax error
   
   
   define('index', 2);
    
    // now 1 to the element 2 in $array
    $array[index] = 1;
   
   ?>


It is recommended to make index a real string (with ' or "), or to define the corresponding constant to avoid any future surprise.

Note that PHP 7.2 removes the support for this feature : `PHP RFC: Deprecate and Remove Bareword (Unquoted) Strings <https://wiki.php.net/rfc/deprecate-bareword-strings>`_.

+--------------+-------------------------+
| Command Line | Arrays/NonConstantArray |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _non-lowercase-keywords:

Non-lowercase Keywords
######################


Usual convention is to write PHP keywords (like as, foreach, switch, case, `'break <http://php.net/manual/en/control-structures.break.php>`_, etc.) all in lowercase. 

.. code-block:: php

   <?php
   
   // usual PHP convention
   foreach($array as $element) {
       echo $element;
   }
   
   // unusual PHP conventions
   Foreach($array AS $element) {
       eCHo $element;
   }
   
   ?>


PHP do understand them in lowercase, UPPERCASE or WilDCase, so there is nothing compulsory here. Although, it will look strange to many.

+--------------+------------------------------------------------+
| Command Line | Php/UpperCaseKeyword                           |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _nonce-creation:

Nonce Creation
##############


Mark the creation of nonce by Wordpress. Nonce may be created with the Wordpress functions wp_nonce_field(), wp_nonce_url() and wp_nonce_create().

.. code-block:: php

   <?php
   
   // Create an nonce for a link.
   $nonce = wp_create_nonce( 'my-nonce' );
   
   echo '<a href="myplugin.php?do_something=some_action&_wpnonce='.$nonce.'">Do some action</a>';
   
   ?>


See also `Wordpress Nonce <https://codex.wordpress.org/WordPress_Nonces>`_.

+--------------+-------------------------+
| Command Line | Wordpress/NonceCreation |
+--------------+-------------------------+
| Analyzers    | :ref:`Wordpress`        |
+--------------+-------------------------+


.. _not-definitions-only:

Not Definitions Only
####################


Files should only include definitions (class, functions, traits, interfaces, constants), or global instructions, but not both. 

.. code-block:: php

   <?php
   // This whole script is a file
   
   // It contains definitions and global code
   class foo {
       static public $foo = null;
   }
   //This can be a singleton creation
   foo::$foo = new foo();
   
   trait t {}
   
   class bar {}
   
   ?>


Within this context, globals, use, and namespaces instructions are not considered a warning.

+--------------+--------------------------+
| Command Line | Files/NotDefinitionsOnly |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _not-not:

Not Not
#######


Double not makes a boolean, not a true.

This is a wrongly done casting to boolean. PHP supports (boolean) to do the same, faster and cleaner.

.. code-block:: php

   <?php
       // Wrong type casting
       $b = !!$x; 
   
       // Explicit code
       $b = (boolean) $x; 
   ?>

+--------------+-----------------------------------------------------------------------------------------------+
| Command Line | Structures/NotNot                                                                             |
+--------------+-----------------------------------------------------------------------------------------------+
| clearPHP     | `no-implied-cast <https://github.com/dseguy/clearPHP/tree/master/rules/no-implied-cast.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                |
+--------------+-----------------------------------------------------------------------------------------------+


.. _null-on-new:

Null On New
###########


Until PHP 7.0, some classes instantiation could yield null, instead of throwing an exception. 

After issuing a 'new' with those classes, it was important to check if the returned object were null or not. No exception were thrown.

.. code-block:: php

   <?php
   
   // Example extracted from the wiki below
   $mf = new MessageFormatter('en_US', '{this was made intentionally incorrect}');
   if ($mf === null) {
       echo 'Surprise!';
   }
   
   ?>


This inconsistency has been cleaned in PHP 7 : see See `Internal Constructor Behavior <https://wiki.php.net/rfc/internal_constructor_behaviour>`_

See also `PHP RFC: Constructor behaviour of internal classes <https://wiki.php.net/rfc/internal_constructor_behaviour>`_.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Classes/NullOnNew                                                                                          |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _objects-don't-need-references:

Objects Don't Need References
#############################


There is no need to create references for objects, as those are always passed by reference when used as arguments.

+--------------+-----------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/ObjectReferences                                                                                     |
+--------------+-----------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-references-on-objects <https://github.com/dseguy/clearPHP/tree/master/rules/no-references-on-objects.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                                  |
+--------------+-----------------------------------------------------------------------------------------------------------------+


.. _old-style-constructor:

Old Style Constructor
#####################


A long time ago, PHP classes used to have the method bearing the same name as the class acts as the constructor.

.. code-block:: php

   <?php
   
   namespace {
       // Global namespace is important
       class foo {
           function foo() {
               // This acts as the old-style constructor, and is reported by PHP
           }
       }
   
       class bar {
           function '__construct() { }
           function bar() {
               // This doesn't act as constructor, as bar has a '__construct() method
           }
       }
   }
   
   namespace Foo\Bar{
       class foo {
           function foo() {
               // This doesn't act as constructor, as bar is not in the global namespace
           }
       }
   }
   
   ?>


This is no more the case in PHP 5, which relies on `'__construct() <http://php.net/manual/en/language.oop5.decon.php>`_ to do so. Having this old style constructor may bring in confusion, unless you are also supporting old time PHP 4.

Note that classes with methods bearing the class name, but inside a namespace are not following this convention, as this is not breaking backward compatibility. Those are excluded from the analyze.

+--------------+---------------------------------------------------------------------------------------------------------+
| Command Line | Classes/OldStyleConstructor                                                                             |
+--------------+---------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-php4-class-syntax <https://github.com/dseguy/clearPHP/tree/master/rules/no-php4-class-syntax.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                          |
+--------------+---------------------------------------------------------------------------------------------------------+


.. _old-style-\_\_autoload():

Old Style __autoload()
######################


Avoid __autoload(). Only use spl_register_autoload().

__autoload() will be deprecated in PHP 7.2 and possibly removed in later version.

__autoload() may only be declared once, and cannot be modified later. This creates potential conflicts between libraries that try to set up their own autoloading schema. 

On the other hand, spl_register_autoload() allows registering and de-registering multiple autoloading functions or methods. 

.. code-block:: php

   <?php
   
   // Modern autoloading.
   function myAutoload($class){}
   spl_register_autoload('myAutoload');
   
   // Old style autoloading.
   function __autoload($class){}
   
   ?>


Do not use the old __autoload() function, but rather the new spl_register_autoload() function. 

See also `Autoloading Classe <http://php.net/manual/en/language.oop5.autoload.php>`_.

+--------------+-----------------------------------------------------------------------------------------------------+
| Command Line | Php/oldAutoloadUsage                                                                                |
+--------------+-----------------------------------------------------------------------------------------------------+
| clearPHP     | `use-smart-autoload <https://github.com/dseguy/clearPHP/tree/master/rules/use-smart-autoload.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                      |
+--------------+-----------------------------------------------------------------------------------------------------+


.. _one-letter-functions:

One Letter Functions
####################


One letter functions seems to be really short for a meaningful name. This may happens for very high usage functions, so as to keep code short, but such functions should be rare.

.. code-block:: php

   <?php
   
   // One letter functions are rarely meaningful
   function f($a, $b) {
       return $a + $b;
   }
   
   ?>

+--------------+------------------------------+
| Command Line | Functions/OneLetterFunctions |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _one-variable-string:

One Variable String
###################


These strings only contains one variable or property or array. 

.. code-block:: php

   <?php
   
   $a = 0;
   $b = $a; // This is a one-variable string
   
   // Better way to write the above
   $b = (string) $a;
   
   // Alternatives : 
   $b2 = $a[1]; // This is a one-variable string
   $b3 = $a->b; // This is a one-variable string
   $c = d;
   $d = D;
   $b4 = "{$$c}";
   $b5 = "{$a->foo()}";
   
   ?>


If the goal is to convert it to a string, use the type casting (string) operator : it is then clearer to understand the conversion. It is also marginally faster, though very little.

+--------------+-------------------------+
| Command Line | Type/OneVariableStrings |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _only-variable-passed-by-reference:

Only Variable Passed By Reference
#################################


When an argument is expected by reference, it is compulsory to provide a container. A container may be a variable, an array, a property or a static property. 

This may be linted by PHP, when the function definition is in the same file as the function usage. This is silently linted if definition and usage are separated, if the call is dynamical or made as a method.

.. code-block:: php

   <?php
   
   function foo(&$bar) { /'**/ }
   
   foo(strtolower($string));
   
   ?>


This analysis currently covers functioncalls and static methodcalls, but omits methodcalls.

+--------------+-----------------------------------------+
| Command Line | Functions/OnlyVariablePassedByReference |
+--------------+-----------------------------------------+
| Analyzers    | :ref:`Analyze`                          |
+--------------+-----------------------------------------+


.. _only-variable-returned-by-reference:

Only Variable Returned By Reference
###################################


Function can't return literals by reference.

When a function returns a reference, it is only possible to return variables, properties or static properties. 

Anything else, like literals or static expressions, yield a warning at execution time.

.. code-block:: php

   <?php
   
   // Can't return a literal number
   function &foo() {
       return 3 + 'rand();
   }
   
   // bar must return values that are stored in a 
   function &bar() {
       $a = 3 + 'rand();
       return $a;
   }
   
   ?>

+--------------+--------------------------------------------+
| Command Line | Structures/OnlyVariableReturnedByReference |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`Analyze`                             |
+--------------+--------------------------------------------+


.. _or-die:

Or Die
######


Classic old style failed error management. 

.. code-block:: php

   <?php
   
   // In case the connexion fails, this kills the current script
   mysql_connect('localhost', $user, $pass) or 'die();
   
   ?>


Interrupting a script will leave the application with a blank page, will make your life miserable for testing. Just don't do that.

+--------------+-------------------------------------------------------------------------------------------+
| Command Line | Structures/OrDie                                                                          |
+--------------+-------------------------------------------------------------------------------------------+
| clearPHP     | `no-implied-if <https://github.com/dseguy/clearPHP/tree/master/rules/no-implied-if.md>`__ |
+--------------+-------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                            |
+--------------+-------------------------------------------------------------------------------------------+


.. _order-of-declaration:

Order Of Declaration
####################


The order used to declare members and methods has a great impact on readability and maintenance. However, practices varies greatly. As usual, being consistent is the most important and useful.

The suggested order is the following : traits, constants, properties, methods. 
Optional characteristics, like final, static... are not specified. Special methods names are not specified. 

.. code-block:: php

   <?php
   
   class x {
       use traits;
       
       const CONSTANTS = 1;
       const CONSTANTS2 = 1;
       const CONSTANTS3 = 1;
       
       private $property = 2;
       private $property2 = 2;
       private $property3 = 2;
       
       public function foo() {}
       public function foo2() {}
       public function foo3() {}
       public function foo4() {}
   }
   
   ?>

+--------------+------------------------------------------------+
| Command Line | Classes/OrderOfDeclaration                     |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _overwriting-variable:

Overwriting Variable
####################


Replacing the content of a variable by something different is prone to errors. For example, it is not obvious if the $text variable is plain text or HTML text. 

.. code-block:: php

   <?php
   
   // Confusing
   $text = htmlentities($text);
   
   // Better
   $textHTML = htmlentities($text);
   
   ?>


Besides, it is possible that the source is needed later, for extra processing. 

Note that accumulators, like += .=  or [] etc., that are meant to collect lots of values with consistent type are OK.

+--------------+-----------------------+
| Command Line | Variables/Overwriting |
+--------------+-----------------------+
| Analyzers    | :ref:`Analyze`        |
+--------------+-----------------------+


.. _overwritten-exceptions:

Overwritten Exceptions
######################


In catch blocks, it is good practice not to overwrite the incoming exception, as information about the exception will be lost.

+--------------+-------------------------------+
| Command Line | Exceptions/OverwriteException |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _overwritten-literals:

Overwritten Literals
####################


The same variable is assigned a literal twice. It is possible that one of the assignation is too much.

This analysis doesn't take into account the distance between two assignations : it may report false positives when the variable is actually used for several purposes, and, as such, assigned twice with different values.

.. code-block:: php

   <?php
   
   function foo() {
       // Two assignations in a short sequence : one is too many.
       $a = 1;
       $a = 2;
       
       for($i = 0; $i < 10; $i++) {
           $a += $i;
       }
       $b = $a;
       
       // New assignation. $a is now used as an array. 
       $a = array(0);
   }
   
   ?>

+--------------+-------------------------------+
| Command Line | Variables/OverwrittenLiterals |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _php-7.0-new-classes:

PHP 7.0 New Classes
###################


Those classes are now declared natively in PHP 7.0 and should not be declared in custom code.

+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/Php70NewClasses                                                                                                                   |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+


.. _php-7.0-new-interfaces:

PHP 7.0 New Interfaces
######################


The following interfaces are introduced in PHP 7.0. They shouldn't be defined in custom code.

+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/Php70NewInterfaces                                                                                                                |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+


.. _php-7.0-removed-directives:

PHP 7.0 Removed Directives
##########################


List of directives that are removed in PHP 7.0.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/Php70RemovedDirective                                                                                  |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _php-7.1-microseconds:

PHP 7.1 Microseconds
####################


PHP 7.1 supports microseconds in DateTime class and date_create() function. 

In previous PHP versions, those dates only used seconds, leading to lazy comparisons : 

.. code-block:: php

   <?php
   
   $now = date_create();
   usleep(10);              // wait for 0.001 ms
   var_dump($now == date_create());
   
   ?>


This code displays true in PHP 7.0 and older, (unless the code was run too close from the next second). In PHP 7.1, this is always false.

This is also true with Datetime : 

.. code-block:: php

   <?php
   
   $now = new DateTime();
   usleep(10);              // wait for 0.001 ms
   var_dump((new DateTime())->format('u') == $now->format('u'));
   
   ?>


This evolution impacts mostly exact comparisons (== and ===). Non-equality (!= and !==) will probably be always true, and should be reviewed.

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/Php71microseconds                                                           |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------+


.. _php-7.1-removed-directives:

PHP 7.1 Removed Directives
##########################


List of directives that are removed in PHP 7.1.

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/Php71RemovedDirective                                                       |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------+


.. _php-7.2-deprecations:

PHP 7.2 Deprecations
####################


PHP 7.2 deprecates several features of the language. 

* `'parse_str() <http://www.php.net/parse_str>`_ with no second argument
* `'assert() <http://www.php.net/assert>`_ on strings
* Usage of gmp_random(), `'create_function() <http://www.php.net/create_function>`_, `'each() <http://www.php.net/each>`_
* Usage of (unset)
* Usage of $php_errormsg
* directive mbstring.func_overload (not supported yet)

Deprecated functions and extensions are reported in a separate analysis.

+--------------+------------------------------------------------------+
| Command Line | Php/Php72Deprecation                                 |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------+


.. _php-7.2-removed-functions:

PHP 7.2 Removed Functions
#########################


The following PHP native functions were removed in PHP 7.2.

* png2wbmp
* jpeg2wbmp

+--------------+------------------------------------------------------+
| Command Line | Php/Php72RemovedFunctions                            |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------+


.. _php-70-removed-functions:

PHP 70 Removed Functions
########################


The following PHP native functions were removed in PHP 7.0.

* ereg
* ereg_replace
* eregi
* eregi_replace
* split
* spliti
* sql_regcase
* magic_quotes_runtime
* set_magic_quotes_runtime
* call_user_method
* call_user_method_array
* set_socket_blocking
* mcrypt_ecb
* mcrypt_cbc
* mcrypt_cfb
* mcrypt_ofb
* datefmt_set_timezone_id
* imagepsbbox
* imagepsencodefont
* imagepsextendfont
* imagepsfreefont
* imagepsloadfont
* imagepsslantfont
* imagepstext

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/Php70RemovedFunctions                                                                                  |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _php-keywords-as-names:

PHP Keywords As Names
#####################


PHP has a set of reserved keywords. It is recommended not to use those keywords for names structures. 

PHP does check that a number of structures, such as classes, methods, interfaces... can't be named or called using one of the keywords. However, in a few other situations, no check are enforced. Using keywords in such situation is confusing.

+--------------+-------------------------------------------------------------------------------------------------+
| Command Line | Php/ReservedNames                                                                               |
+--------------+-------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+-------------------------------------------------------------------------------------------------+


.. _php5-indirect-variable-expression:

PHP5 Indirect Variable Expression
#################################


Indirect variable expressions changes between PHP 5 an 7.

The following structures are evaluated differently in PHP 5 and 7. It is recommended to review them or switch to a less ambiguous syntax.

.. code-block:: php

   <?php
   
   // PHP 7 
   $foo = 'bar';
   $bar['bar']['baz'] = 'foobarbarbaz';
   echo $$foo['bar']['baz'];
   echo ($$foo)['bar']['baz'];
   
   // PHP 5
   $foo['bar']['baz'] = 'bar';
   $bar = 'foobarbazbar';
   echo $$foo['bar']['baz'];
   echo ${$foo['bar']['baz']};
   
   ?>


See `Backward incompatible changes PHP 7.0 <http://php.net/manual/en/migration70.incompatible.php>`_

+---------------------+-----------------------+-----------------------+
| Expression          | PHP 5 interpretation  | PHP 7 interpretation  |
+---------------------+-----------------------+-----------------------+
|$$foo['bar']['baz']  |${$foo['bar']['baz']}  |($$foo)['bar']['baz']  |
|$foo->$bar['baz']    |$foo->{$bar['baz']}    |($foo->$bar)['baz']    |
|$foo->$bar['baz']()  |$foo->{$bar['baz']}()  |($foo->$bar)['baz']()  |
|Foo::$bar['baz']()   |Foo::{$bar['baz']}()   |(Foo::$bar)['baz']()   |
+---------------------+-----------------------+-----------------------+

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Variables/Php5IndirectExpression                                                                           |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _php7-dirname:

PHP7 Dirname
############


With PHP 7, dirname has a second argument that represents the number of parent folder to follow. This prevent us from using nested `'dirname() <http://www.php.net/dirname>`_ calls to reach an grand-parent direct.

.. code-block:: php

   <?php
   $path = '/a/b/c/d/e/f';
   
   // PHP 7 syntax
   $threeFoldersUp = dirname($path, 3);
   
   // PHP 5 syntax
   $threeFoldersUp = dirname(dirname(dirname($path)));
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/PHP7Dirname                                                                                     |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _parent,-static-or-self-outside-class:

Parent, Static Or Self Outside Class
####################################


Parent, static and self keywords must be used within a class or a trait. They make no sens outside a class or trait scope, as self and static refers to the current class and parent refers to one of parent above.

Static may be used in a function or a closure, but not globally.

+--------------+-------------------------+
| Command Line | Classes/PssWithoutClass |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _parenthesis-as-parameter:

Parenthesis As Parameter
########################


Using parenthesis around parameters used to silent some internal check. This is not the case anymore in PHP 7, and should be fixed by removing the parenthesis and making the value a real reference.

.. code-block:: php

   <?php
   
   // PHP 7 sees through parenthesis
   $d = foo(1, 2, $c);
   
   // Avoid parenthesis in arguments
   $d = foo(1, 2, ($c));
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/ParenthesisAsParameter                                                                                 |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _performances/noglob:

Performances/NoGlob
###################


`'glob() <http://www.php.net/glob>`_ and `'scandir() <http://www.php.net/scandir>`_ sorts results by default. If you don't need that sorting, save some time by requesting NOSORT with those functions.

Besides, whenever possible, use `'scandir() <http://www.php.net/scandir>`_ instead of `'glob() <http://www.php.net/glob>`_. 

.. code-block:: php

   <?php
   
   // Scandir without sorting is the fastest. 
   scandir('docs/', SCANDIR_SORT_NONE);
   
   // Scandir sorts files by default. Same as above, but with sorting
   scandir('docs/');
   
   // glob sorts files by default. Same as below, but no sorting
   glob('docs/*', GLOB_NOSORT);
   
   // glob sorts files by default. This is the slowest version
   glob('docs/*');
   
   ?>


Using `'opendir() <http://www.php.net/opendir>`_ and a while loop may be even faster. 

This analysis skips `'scandir() <http://www.php.net/scandir>`_ and `'glob() <http://www.php.net/glob>`_ if they are explicitely configured with flags (aka, sorting is explicitely needed).

Glob() accepts wildchar, that may not easily replaced with `'scandir() <http://www.php.net/scandir>`_ or `'opendir() <http://www.php.net/opendir>`_.

See `Putting glob to the test <https://www.phparch.com/2010/04/putting-glob-to-the-test/>`_.

+--------------+---------------------+
| Command Line | Performances/NoGlob |
+--------------+---------------------+
| Analyzers    | :ref:`Performances` |
+--------------+---------------------+


.. _performances/timevsstrtotime:

Performances/timeVsstrtotime
############################


time() is actually faster than strtotime('now').

.. code-block:: php

   <?php
   
   // Faster version
   $a = time();
   
   // Slower version
   $b = strtotime('now');
   
   ?>


This is a micro-optimisation. Gain is real, but small unless the function is used many times.

+--------------+------------------------------+
| Command Line | Performances/timeVsstrtotime |
+--------------+------------------------------+
| Analyzers    | :ref:`Performances`          |
+--------------+------------------------------+


.. _php-7-indirect-expression:

Php 7 Indirect Expression
#########################


Those are variable indirect expressions that are interpreted differently between PHP 5 and PHP 7. You should check them so they don't behave strangely.

+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Variables/Php7IndirectExpression                                                                                                      |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP70` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------+


.. _php-71-new-classes:

Php 71 New Classes
##################


New classes, introduced in PHP 7.1. If classes where created with the same name, in current code, they have to be moved in a namespace, or removed from code to migrate safely to PHP 7.1.

The new class is : ReflectionClassConstant. The other class is 'Void' : this is forbidden as a classname, as Void is used for return type hint.

.. code-block:: php

   <?php
   
   class ReflectionClassConstant {
       // Move to a namespace, do not leave in global
       // or, remove this class
   }
   
   ?>

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/Php71NewClasses                                                                                                                                                                         |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _php7-relaxed-keyword:

Php7 Relaxed Keyword
####################


Most of the traditionnal PHP keywords may be used inside classes, trait or interfaces.

.. code-block:: php

   <?php
   
   // Compatible with PHP 7.0 + 
   class foo {
       // as is a PHP 5 keyword
       public function as() {
       
       }
   }
   
   ?>


This was not the case in PHP 5, and will yield parse errors.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/Php7RelaxedKeyword                                                                                     |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _phpinfo:

Phpinfo
#######


`'phpinfo() <http://www.php.net/phpinfo>`_ is a great function to learn about the current configuration of the server.

.. code-block:: php

   <?php
   
   if (DEBUG) {
       'phpinfo();
   }
   
   ?>


If left in the production code, it may lead to a critical leak, as any attacker gaining access to this data will know a lot about the server configuration.
It is advised to never leave that kind of instruction in a production code.

+--------------+-------------------------+
| Command Line | Structures/PhpinfoUsage |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _pre-increment:

Pre-increment
#############


When possible, use the pre-increment operator (++$i or --$i) instead of the post-increment operator ($i++ or $i--).

The latter needs an extra memory allocation that costs about 10% of performances. 

.. code-block:: php

   <?php
   
   // ++$i should be preferred over $i++, as current value is not important
   for($i = 0; $i <10; ++$i) {
       // do Something
   }
   
   // ++$b and $b++ have different impact here, since $a will collect $b + 1 or $b, respectively.
   $a = $b++;
   
   ?>

+--------------+-------------------------------------+
| Command Line | Performances/PrePostIncrement       |
+--------------+-------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Performances` |
+--------------+-------------------------------------+


.. _preprocess-arrays:

Preprocess Arrays
#################


Using long list of assignations for initializing arrays is significantly slower than the declaring them as an array. 

.. code-block:: php

   <?php
   
   // Slow way
   $a = []; // also with $a = array();
   $a[1] = 2;
   $a[2] = 3;
   $a[3] = 5;
   $a[4] = 7;
   $a[5] = 11;
   
   // Faster way
   $a = [1 => 2, 
         2 => 3,
         3 => 5,
         4 => 7,
         5 => 11];
   
   // Even faster way if indexing is implicit
   $a = [2, 3, 5, 7, 11];
   
   ?>


If the array has to be completed rather than created, it is also faster to use += when there are more than ten elements to add.

.. code-block:: php

   <?php
   
   // Slow way
   $a = []; // also with $a = array();
   $a[1] = 2;
   $a[2] = 3;
   $a[3] = 5;
   // some expressions to get $seven and $eleven
   $a[4] = $seven;
   $a[5] = $eleven;
   
   // Faster way
   $a = [1 => 2, 
         2 => 3,
         3 => 5];
   // some expressions to get $seven and $eleven
   $a += [4 => $seven, 
          5 => $eleven];
   
   // Even faster way if indexing is implicit
   $a = [2, 3, 5];
   // some expressions to get $seven and $eleven
   $a += [$seven, $eleven];
   
   ?>

+--------------+-------------------------+
| Command Line | Arrays/ShouldPreprocess |
+--------------+-------------------------+
| Analyzers    | none                    |
+--------------+-------------------------+


.. _preprocessable:

Preprocessable
##############


The following expression are made of literals or already known values : they may be fully calculated before running PHP.

.. code-block:: php

   <?php
   
   // Building an array from a string
   $name = 'PHP'.' '.'7.2';
   
   // Building an array from a string
   $list = explode(',', 'a,b,c,d,e,f');
   
   // Calculating a power
   $kbytes = $bytes / pow(2, 10);
   
   // This will never change
   $name = ucfirst(strtolower('PARIS'));
   
   ?>


By doing so, this will reduce the amount of work of PHP.

+--------------+--------------------------------+
| Command Line | Structures/ShouldPreprocess    |
+--------------+--------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Analyze` |
+--------------+--------------------------------+


.. _print-and-die:

Print And Die
#############


Die() also prints. 

When stopping a script with `'die() <http://www.php.net/die>`_, it is possible to provide a message as first argument, that will be displayed at execution. There is no need to make a specific call to print or echo.

.. code-block:: php

   <?php
   
   //  'die may do both print and 'die.
   echo 'Error message';
   'die();
   
   //  'exit may do both print and 'die.
   print 'Error message';
   'exit;
   
   //  'exit cannot print integers only : they will be used as status report to the system.
   print 'Error message';
   'exit 1;
   
   ?>

+--------------+------------------------+
| Command Line | Structures/PrintAndDie |
+--------------+------------------------+
| Analyzers    | :ref:`Analyze`         |
+--------------+------------------------+


.. _property-could-be-private:

Property Could Be Private
#########################


The following properties are never used outside their class of definition or their children (for the protected). 
Given the analyzed code, they could be set as private. 

Note that dynamic properties (such as $x->$y) are not taken into account.

+--------------+------------------------+
| Command Line | Classes/CouldBePrivate |
+--------------+------------------------+
| Analyzers    | :ref:`Analyze`         |
+--------------+------------------------+


.. _property-used-below:

Property Used Below
###################


Mark properties that are used in children classes.

.. code-block:: php

   <?php
   
   class foo {
       // This property is used in children
       protected protectedProperty = 1;
       
       // This property is not used in children
       protected localProtectedProperty = 1;
   
       private function foobar() {
           // protectedProperty is used here, but defined in parent
           $this->localProtectedProperty = 3;
       }
   }
   
   class foofoo extends foo {
       private function bar() {
           // protectedProperty is used here, but defined in parent
           $this->protectedProperty = 3;
       }
   }
   
   ?>


This doesn't mark the current class, nor the (grand-)parent ones.

+--------------+---------------------------+
| Command Line | Classes/PropertyUsedBelow |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _property-used-in-one-method-only:

Property Used In One Method Only
################################


Properties should be used in several methods. When a property is used in only one method, this should have be of another shape. 

Properties used in one method only may be used several times, and read only. This may be a class constant. Such properties are meant to be overwritten by an extending class, and that's possible with class constants.

Properties that read and written may be converted into a variable, static to the method. This way, they are kept close to the method, and do not pollute the object's properties.

.. code-block:: php

   <?php
   
   class foo {
       private $once = 1;
       const ONCE = 1;
       private $counter = 0;
       
       function bar() {
           // $this->once is never used anywhere else. 
           someFunction($this->once);
           someFunction(self::ONCE);   // Make clear that it is a 
       }
   
       function bar2() {
           static $localCounter = 0;
           $this->counter++;
           
           // $this->once is only used here, for distinguising calls to someFunction2
           if ($this->counter > 10) { // $this->counter is used only in bar2, but it may be used several times
               return false;
           }
           someFunction2($this->counter);
   
           // $localCounter keeps track for all the calls
           if ($localCounter > 10) { 
               return false;
           }
           someFunction2($localCounter);
       }
   }
   
   ?>


Note : properties used only once are not returned by this analysis. They are omitted, and are available in the analysis `Used Once Property`_.

+--------------+-------------------------------------+
| Command Line | Classes/PropertyUsedInOneMethodOnly |
+--------------+-------------------------------------+
| Analyzers    | :ref:`Analyze`                      |
+--------------+-------------------------------------+


.. _property/variable-confusion:

Property/Variable Confusion
###########################


Within a class, there is both a property and some variables bearing the same name. 

.. code-block:: php

   <?php
   class Object {
       private $x;
       
       function SetData( ) {
           $this->x = $x + 2;
       }
   }
   ?>


the property and the variable may easily be confused one for another and lead to a bug. 

Sometimes, when the property is going to be replaced by the incoming argument, or data based on that argument, this naming schema is made on purpose, indicating that the current argument will eventually end up in the property. When the argument has the same name as the property, no warning is reported.

+--------------+--------------------------------------+
| Command Line | Structures/PropertyVariableConfusion |
+--------------+--------------------------------------+
| Analyzers    | :ref:`Analyze`                       |
+--------------+--------------------------------------+


.. _queries-in-loops:

Queries In Loops
################


Avoid querying databases in a loop. 

Querying an external database in a loop usually leads to performances problems. This is also called the 'n + 1 problem'. 

This problem applies also to prepared statement : when such statement are called in a loop, they are slower than one-time large queries.

It is recommended to reduce the number of queries by making one query, and dispatching the results afterwards. This is true with SQL databases, graph queries, LDAP queries, etc. 

.. code-block:: php

   <?php
   
   // Typical N = 1 problem : there will be as many queries as there are elements in $array
   $ids = array(1,2,3,5,6,10);
   
   $db = new SQLite3('mysqlitedb.db');
   
   // all the IDS are merged into the query at once
   $results = $db->query('SELECT bar FROM foo WHERE id  in ('.implode(',', $id).')');
   while ($row = $results->fetchArray()) {
       var_dump($row);
   }
   
   
   // Typical N = 1 problem : there will be as many queries as there are elements in $array
   $ids = array(1,2,3,5,6,10);
   
   $db = new SQLite3('mysqlitedb.db');
   
   foreach($ids as $id) {
       $results = $db->query('SELECT bar FROM foo WHERE id = '.$id);
       while ($row = $results->fetchArray()) {
           var_dump($row);
       }
   }
   
   ?>


This optimisation is not always possible : for example, some SQL queries may not be prepared, like 'DROP TABLE', or 'DESC'. 'UPDATE' commands often update one row at a time, and grouping such queries may be counter-productive or unsafe.

+--------------+--------------------------+
| Command Line | Structures/QueriesInLoop |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _random-without-try:

Random Without Try
##################


random_int() and random_bytes() require a try..catch enclosure.

random_int() and random_bytes() emit Exceptions if they meet a problem. This way, failure can't be mistaken with returning an empty value, which leads to lower security. 

.. code-block:: php

   <?php
   
   try {
       $salt = random_bytes($length);
   } catch (TypeError $e) {
       // Error while reading the provided parameter
   } catch (Exception $e) {
       // Insufficient randome data generated
   } catch (Error $e) {
       // Error with the provided parameter : <= 0
   }
   
   ?>

+--------------+-----------------------------+
| Command Line | Structures/RandomWithoutTry |
+--------------+-----------------------------+
| Analyzers    | :ref:`Security`             |
+--------------+-----------------------------+


.. _randomly-sorted-arrays:

Randomly Sorted Arrays
######################


Those literals arrays are written in several places, but in various orders. 

This may reduce the reading and proofing of the arrays, and induce confusion.

Unless order is important, it is recommended to always use the same order when defining literal arrays.

.. code-block:: php

   <?php
   
   // an array
   $set = [1,3,5,9,10];
   
   function foo() {
       // an array, with the same values but different order, in a different context
       $list = [1,3,5,10,9,];
   }
   
   // an array, with the same order than the initial one
   $inits = [1,3,5,9,10];
   
   ?>

+--------------+-------------------------------+
| Command Line | Arrays/RandomlySortedLiterals |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _redeclared-php-functions:

Redeclared PHP Functions
########################


Function that bear the same name as a PHP function, and that are declared. 

This is possible when managing some backward compatibility, like emulating an old function, or preparing for newer PHP version, like emulating new upcoming function.

.. code-block:: php

   <?php
   
   if (version_compare(PHP_VERSION, 7.0) > 0) {
       function split($separator, $string) {
           return explode($separator, $string);
       }
   }
   
   print_r( split(' ', '2 3'));
   
   ?>

+--------------+---------------------------------+
| Command Line | Functions/RedeclaredPhpFunction |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`                  |
+--------------+---------------------------------+


.. _redefined-class-constants:

Redefined Class Constants
#########################


Redefined class constants.

Class constants may be redefined, though it is prone to errors when using them, as it is now crucial to use the right class name to access the right value.

.. code-block:: php

   <?php
   
   class a {
       const A = 1;
   }
   
   class b extends a {
       const A = 2;
   }
   
   class c extends c { }
   
   echo a::A, ' ', b::A, ' ', c::A;
   // 1 2 2
   
   ?>


It is recommended to use distinct names.

+--------------+----------------------------+
| Command Line | Classes/RedefinedConstants |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _redefined-default:

Redefined Default
#################


Classes allows properties to be set with a default value. When those properties get, unconditionally, another value at constructor time, then one of the default value are useless. One of those definition should go : it is better to define properties outside the constructor.

.. code-block:: php

   <?php
   
   class foo {
       public $redefined = 1;
   
       public function '__construct( ) {
           $this->redefined = 2;
       }
   }
   
   ?>

+--------------+--------------------------+
| Command Line | Classes/RedefinedDefault |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _register-globals:

Register Globals
################


register_globals was a PHP directive that dumped all incoming variables from GET, POST, COOKIE and FILES as global variables in the called scripts.
This lead to security failures, as the variables were often used but not filtered. 

Though it is less often found in more recent code, register_globals is sometimes needed in legacy code, that haven't made the move to eradicate this style of coding.
Backward compatible pieces of code that mimic the register_globals features usually create even greater security risks by being run after scripts startup. At that point, some important variables are already set, and may be overwritten by the incoming call, creating confusion in the script.

Mimicking register_globals is achieved with variables variables, `'extract() <http://www.php.net/extract>`_, `'parse_str() <http://www.php.net/parse_str>`_ and `'import_request_variables() <http://www.php.net/import_request_variables>`_ (Up to PHP 5.4). 

.. code-block:: php

   <?php
   
   // Security warning ! This overwrites existing variables. 
   extract($_POST);
   
   // Security warning ! This overwrites existing variables. 
   foreach($_REQUEST as $var => $value) {
       $$var = $value;
   }
   
   ?>

+--------------+--------------------------+
| Command Line | Security/RegisterGlobals |
+--------------+--------------------------+
| Analyzers    | :ref:`Security`          |
+--------------+--------------------------+


.. _relay-function:

Relay Function
##############


Relay function only hand workload to another one. 

Relay functions (or methods) are delegating the actual work to another function or method. They do not have any impact on the results, besides exposing another name for the same feature.

.. code-block:: php

   <?php
   
   function myStrtolower($string) {
       return \strtolower($string);
   }
   
   ?>


Relay functions are typical of transition API, where an old API have to be preserved until it is fully migrated. Then, they may be removed, so as to reduce confusion, and unclutter the API.

+--------------+-------------------------+
| Command Line | Functions/RelayFunction |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _repeated-regex:

Repeated Regex
##############


Repeated regex should be centralized. 

When a regex is repeatedly used in the code, it is getting harder to update. 

.. code-block:: php

   <?php
   
   // Regex used several times, at least twice.
   preg_match('/^abc_|^square$/i', $_GET['x']);
   
   //.......
   
   preg_match('/^abc_|^square$/i', $row['name']);
   
   // This regex is dynamically built, so it is not reported.
   preg_match('/^circle|^'.$x.'$/i', $string);
   
   // This regex is used once, so it is not reported.
   preg_match('/^circle|^square$/i', $string);
   
   ?>


Regex that are repeated at least once (aka, used twice or more) are reported. Regex that are dynamically build are not reported.

+--------------+--------------------------+
| Command Line | Structures/RepeatedRegex |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _repeated-print():

Repeated print()
################


Always merge several print or echo in one call.

It is recommended to use echo with multiple arguments, or a concatenation with print, instead of multiple calls to print echo, when outputting several blob of text.

.. code-block:: php

   <?php
   
   //Write : 
     echo 'a', $b, 'c';
     print 'a' . $b . 'c';
   
   //Don't write :  
     print 'a';
     print $b;
     print 'c';
   ?>

+--------------+---------------------------------------------------------------------------------------------------+
| Command Line | Structures/RepeatedPrint                                                                          |
+--------------+---------------------------------------------------------------------------------------------------+
| clearPHP     | `no-repeated-print <https://github.com/dseguy/clearPHP/tree/master/rules/no-repeated-print.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                    |
+--------------+---------------------------------------------------------------------------------------------------+


.. _reserved-keywords-in-php-7:

Reserved Keywords In PHP 7
##########################


Php reserved names for class/trait/interface. They won't be available anymore in user space starting with PHP 7.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/ReservedKeywords7                                                                                      |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _results-may-be-missing:

Results May Be Missing
######################


preg_match() may return empty values, if the search fails. It is important to check for the existence of results before assigning them to another variable, or using it.

.. code-block:: php

   <?php
       preg_match('/PHP ([0-9\.]+) /', $res, $r);
       $s = $r[1];
       // $s may end up null if preg_match fails.
   ?>

+--------------+-------------------------------+
| Command Line | Structures/ResultMayBeMissing |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _rethrown-exceptions:

Rethrown Exceptions
###################


Throwing a caught exception is usually useless and dead code.

When exception are caught, they should be processed or transformed, but not rethrown.

Those issues often happen when a catch structure was positioned for debug purposes, but lost its usage later. 

.. code-block:: php

   <?php
   
   try {
       doSomething();
   } catch (Exception $e) {
       throw $e;
   }
   
   ?>

+--------------+------------------------------+
| Command Line | Exceptions/Rethrown          |
+--------------+------------------------------+
| Analyzers    | :ref:`Dead code <dead-code>` |
+--------------+------------------------------+


.. _return-true-false:

Return True False
#################


These conditional expressions return true/false, depending on the condition. This may be simplified by dropping the control structure alltogether.

.. code-block:: php

   <?php
   
   if (version_compare($a, $b) >= 0) {
       return true;
   } else {
       return false;
   }
   
   ?>


This may be simplified with : 

.. code-block:: php

   <?php
   
   return version_compare($a, $b) >= 0;
   
   ?>


This may be applied to assignations and ternary operators too.

.. code-block:: php

   <?php
   
   if (version_compare($a, $b) >= 0) {
       $a = true;
   } else {
       $a = false;
   }
   
   $a = version_compare($a, $b) >= 0 ? false : true;
   
   ?>

+--------------+----------------------------+
| Command Line | Structures/ReturnTrueFalse |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _return-with-parenthesis:

Return With Parenthesis
#######################


PHP tolerates parenthesis for the argument of a return statement, but it is recommended not to use them.

+--------------+------------------------------------------------+
| Command Line | Php/ReturnWithParenthesis                      |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _safe-curloptions:

Safe CurlOptions
################


It is advised to always use CURLOPT_SSL_VERIFYPEER and CURLOPT_SSL_VERIFYHOST when requesting a SSL connexion. 

With those tests (by default), the certificate is verified, and if it isn't valided, the connexion fails : this is a safe behavior.

.. code-block:: php

   <?php
   $ch = curl_init();
   
   curl_setopt($ch, CURLOPT_URL, https://www.php.net/);
   
   // To be safe, always set this to true
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
   
   curl_exec($ch);
   curl_close($ch);
   ?>

+--------------+----------------------+
| Command Line | Security/CurlOptions |
+--------------+----------------------+
| Analyzers    | :ref:`Security`      |
+--------------+----------------------+


.. _same-conditions:

Same Conditions
###############


Several If then else structures are chained, and some conditions are identical. The latter will be ignored.

.. code-block:: php

   <?php
   
   if ($a == 1) { doSomething(); }
   elseif ($b == 1) { doSomething(); }
   elseif ($c == 1) { doSomething(); }
   elseif ($a == 1) { doSomething(); }
   else {}
   
   // Also works on if then else if chains
   if ($a == 1) { doSomething(); }
   else if ($b == 1) { doSomething(); }
   else if ($c == 1) { doSomething(); }
   else if ($a == 1) { doSomething(); }
   else {}
   
   ?>

+--------------+---------------------------+
| Command Line | Structures/SameConditions |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _scalar-typehint-usage:

Scalar Typehint Usage
#####################


Spot usage of scalar type hint : int, float, boolean and string.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/ScalarTypehintUsage                                                                                    |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _sequences-in-for:

Sequences In For
################


For() instructions allows several instructions in each of its parameters. Then, the instruction separator is comma ',', not semi-colon, which is used for separating the 3 arguments.

.. code-block:: php

   <?php
      for ($a = 0, $b = 0; $a < 10, $b < 20; $a++, $b += 3) {
       // For loop
      }
   ?>


This loop will simultaneously increment $a and $b. It will stop only when the last of the central sequence reach a value of false : here, when $b reach 20 and $a will be 6. 

This structure is often unknown, and makes the for instruction quite difficult to read. It is also easy to oversee the multiples instructions, and omit one of them.
It is recommended not to use it.

+--------------+--------------------------+
| Command Line | Structures/SequenceInFor |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _set-cookie-safe-arguments:

Set Cookie Safe Arguments
#########################


The last five arguments of `'setcookie() <http://www.php.net/setcookie>`_ and `'setrawcookie() <http://www.php.net/setrawcookie>`_ are for security. Use them anytime you can.::

   
       setcookie ( string $name [, string $value =  [, int $expire = 0 [, string $path =  [, string $domain =  [, bool $secure = false [, bool $httponly = false ]]]]]] )
   


The $expire argument sets the date of expiration of the cookie. It is recommended to make it as low as possible, to reduce its chances to be captured. Sometimes, low expiration date may be several days (for preferences), and other times, low expiration date means a few minutes. 

The $path argument limits the transmission of the cookie to URL whose path matches the one mentionned here. By default, it is '/', which means the whole server. If a cookie usage is limited to a part of the application, use it here.

The $domain argument limits the transmission of the cookie to URL whose domain matches the one mentionned here. By default, it is '', which means any server on the internet. At worse, you may use 'mydomain.com' to cover your whole domain, or better, refine it with the actual subdomain of usage.

The $secure argument limits the transmission of the cookie over HTTP (by default) or HTTPS. The second is better, as the transmission of the cookie is crypted. In case HTTPS is still at the planned stage, use '$_SERVER[HTTPS]'. This environnement variable is false on HTTP, and true on HTTPS.

The $httponly argument limits the access of the cookie to Javascript. It is only transmitted to the browser, and retransmitted. This helps reducing XSS and CSRF attacks, though it is disputed. 

.. code-block:: php

   <?php
   
   //admin cookie, available only on https://admin.my-domain.com/system/, for the next minute, and not readable by javascript
   setcookie(admin, $login, time()+60, /system/, admin.my-domain.com, $_SERVER['HTTPS'], 1);
   
   //login cookie, available until the browser is closed, over http or https
   setcookie(login, $login);
   
   //removing the login cookie : Those situations are omitted by the analysis
   setcookie(login, '');
   
   ?>


See also `'setcookie() <http://www.php.net/setcookie>`_ on the manual for more information.

+--------------+------------------------+
| Command Line | Security/SetCookieArgs |
+--------------+------------------------+
| Analyzers    | :ref:`Security`        |
+--------------+------------------------+


.. _setlocale()-uses-constants:

Setlocale() Uses Constants
##########################


setlocal() don't use strings.

The first argument of `'setlocale() <http://www.php.net/setlocale>`_ must be one of the valid constants, LC_ALL, LC_COLLATE, LC_CTYPE, LC_MONETARY, LC_NUMERIC, LC_TIME, LC_MESSAGES.

.. code-block:: php

   <?php
   
   // Use constantes for setlocale first argument
   setlocale(LC_ALL, 'nl_NL');
   setlocale(\LC_ALL, 'nl_NL');
   
   // Don't use string for setlocale first argument
   setlocale('LC_ALL', 'nl_NL');
   setlocale('LC_'.'ALL', 'nl_NL');
   
   ?>


The PHP 5 usage of strings (same name as above, enclosed in ' or ") is not legit anymore in PHP 7 and later.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/SetlocaleNeedsConstants                                                                         |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _several-instructions-on-the-same-line:

Several Instructions On The Same Line
#####################################


Usually, instructions do not share their line : one instruction, one line. This is good for readability, and help at understanding the code. This is especially important when fast-reading the code to find some special situation, where such double-meaning line way have an impact.

+--------------+-----------------------------------+
| Command Line | Structures/OneLineTwoInstructions |
+--------------+-----------------------------------+
| Analyzers    | :ref:`Analyze`                    |
+--------------+-----------------------------------+


.. _short-open-tags:

Short Open Tags
###############


Usage of short open tags is discouraged. The following files were found to be impacted by the short open tag directive at compilation time. They must be reviewed to ensure no &lt;? tags are found in the code.

+--------------+--------------------------+
| Command Line | Php/ShortOpenTagRequired |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _short-syntax-for-arrays:

Short Syntax For Arrays
#######################


Arrays written with the new PHP 5.4 short syntax. 

PHP 5.4 introduced the new short syntax, with square brackets. The previous syntax, based on the array() keyword is still available.

.. code-block:: php

   <?php
   
   // All PHP versions array
   $a = array(1, 2, 3);
   
   // PHP 5.4+ arrays
   $a = [1, 2, 3];
   
   ?>


See also `Arrays <http://php.net/manual/en/language.types.array.php>`_.

+--------------+---------------------------+
| Command Line | Arrays/ArrayNSUsage       |
+--------------+---------------------------+
| Analyzers    | :ref:`CompatibilityPHP53` |
+--------------+---------------------------+


.. _should-be-single-quote:

Should Be Single Quote
######################


Use single quote for simple strings.

Static content inside a string, that has no single quotes nor escape sequence (such as \n or \t), should be using single quote delimiter, instead of double quote. 

.. code-block:: php

   <?php
   
   $a = abc;
   
   // This one is using a special sequence
   $b = cde\n;
   
   // This one is using two special sequences
   $b = \x03\u{1F418};
   
   ?>


If you have too many of them, don't loose your time switching them all. If you have a few of them, it may be good for consistence.

+--------------+-----------------------------------------------------------------------------------------------+
| Command Line | Type/ShouldBeSingleQuote                                                                      |
+--------------+-----------------------------------------------------------------------------------------------+
| clearPHP     | `no-double-quote <https://github.com/dseguy/clearPHP/tree/master/rules/no-double-quote.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>`                                                |
+--------------+-----------------------------------------------------------------------------------------------+


.. _should-chain-exception:

Should Chain Exception
######################


Chain exception to provide more context.

When catching an exception and rethrowing another one, it is recommended to chain the exception : this means providing the original exception, so that the final recipiend has a chance to track the origin of the problem. This doesn't change the thrown message, but provides more information.

Note : Chaining requires PHP > 5.3.0.

.. code-block:: php

   <?php
       try {
           throw new Exception('Exception 1', 1);
       } catch (\Exception $e) {
           throw new Exception('Exception 2', 2, $e); 
           // Chaining here. 
   
       }
   ?>

+--------------+---------------------------------+
| Command Line | Structures/ShouldChainException |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`                  |
+--------------+---------------------------------+


.. _should-make-alias:

Should Make Alias
#################


Long names should be aliased.

Aliased names are easy to read at the beginning of the script; they may be changed at one point, and update the whole code at the same time. 
Finally, short names makes the rest of the code readable. 

.. code-block:: php

   <?php
   
   namespace x\y\z;
   
   use a\b\c\d\e\f\g as Object;
   
   // long name, difficult to read, prone to change.
   new a\b\c\d\e\f\g();
   
   // long name, difficult to read, prone to silent dead code if namespace change.
   if ($o 'instanceof a\b\c\d\e\f\g) {
       
   }
   
   // short names Easy to update all at once.
   new Object();
   if ($o 'instanceof Object) {
       
   }
   
   ?>

+--------------+--------------------------------------+
| Command Line | Namespaces/ShouldMakeAlias           |
+--------------+--------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`ZendFramework` |
+--------------+--------------------------------------+


.. _should-make-ternary:

Should Make Ternary
###################


Ternary operators are the best when assigning values to a variable.

This way, they are less verbose, compatible with assignation and easier to read.

.. code-block:: php

   <?php
       // verbose if then structure
       if ($a == 3) {
           $b = 2;
       } else {
           $b = 3;
       }
   
       // compact ternary call
       $b = ($a == 3) ? 2 : 3;
   
       // verbose if then structure
       // Works with short assignations and simple expressions
       if ($a != 3) {
           $b += 2 - $a * 4;
       } else {
           $b += 3;
       }
   
       // compact ternary call
       $b += ($a != 3) ? 2 - $a * 4 : 3;
   
   ?>

+--------------+------------------------------+
| Command Line | Structures/ShouldMakeTernary |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _should-regenerate-session-id:

Should Regenerate Session Id
############################


No mention of Zend\Session::regenerateId() method found. 

When using Zend\Session, or PHP session, a session ID is assigned to the user. It is a random number, used to connect the user and its data on the server. Actually, anyone with the session ID may have access to the data. This is why those session ID are so long and complex.

A good approach to protect the session ID is to reduce its lifespan : the shorter the time of use, the better. While changing the session ID at every hit on the page may no be possible, a more reasonable approach is to change the session id when an important action is about to take place. What important means is left to the application to decide.

Based on this philopsophy, a code source that uses Zend\Session but never uses Zend\Session::regenerateId() has to be updated.

.. code-block:: php

   <?php
   
       //Getting the session manager from the application
      $session = $e->getApplication()
                   ->getServiceManager()
                   ->get('Zend\Session\SessionManager');
   
   ?>


See `Zend Session <https://docs.zendframework.com/zend-session/manager/>`_, 
`\Zend\Session\SessionManager <https://framework.zend.com/apidoc/2.4/classes/Zend.Session.SessionManager.html#method_regenerateId>`_

+--------------+---------------------------------+
| Command Line | ZendF/ShouldRegenerateSessionId |
+--------------+---------------------------------+
| Analyzers    | :ref:`ZendFramework`            |
+--------------+---------------------------------+


.. _should-typecast:

Should Typecast
###############


When typecasting, it is better to use the casting operator, such as (int) or (bool).

Functions such as `'intval() <http://www.php.net/intval>`_ or `'settype() <http://www.php.net/settype>`_ are always slower.

.. code-block:: php

   <?php
   
   $int = intval($_GET['x']);
   
   // Quicker version
   $int = (int) $_GET['x'];
   
   ?>


This is a micro-optimisation, although such conversion may be use multiple time, leading to a larger performance increase.

+--------------+---------------------+
| Command Line | Type/ShouldTypecast |
+--------------+---------------------+
| Analyzers    | :ref:`Analyze`      |
+--------------+---------------------+


.. _should-use-coalesce:

Should Use Coalesce
###################


PHP 7 introduced the ?? operator, that replaces longer structures to set default values when a variable is not set.

.. code-block:: php

   <?php
   
   // Fetches the request parameter user and results in 'nobody' if it doesn't exist
   $username = $_GET['user'] ?? 'nobody';
   // equivalent to: $username = 'isset($_GET['user']) ? $_GET['user'] : 'nobody';
    
   // Calls a hypothetical model-getting function, and uses the provided default if it fails
   $model = Model::get($id) ?? $default_model;
   // equivalent to: if (($model = Model::get($id)) === NULL) { $model = $default_model; }
   
   ?>


Sample extracted from PHP docs `Isset Ternary <https://wiki.php.net/rfc/isset_ternary>`_

+--------------+-----------------------+
| Command Line | Php/ShouldUseCoalesce |
+--------------+-----------------------+
| Analyzers    | :ref:`Analyze`        |
+--------------+-----------------------+


.. _should-use-constants:

Should Use Constants
####################


The following functions have related constants that should be used as arguments, instead of scalar literals, such as integers or strings.

For example, $lines = file('file.txt', 2); is less readable than $lines = file('file.txt', FILE_IGNORE_NEW_LINES)

+--------------+------------------------------+
| Command Line | Functions/ShouldUseConstants |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _should-use-function-use:

Should Use Function Use
#######################


Functioncalls that fall back to global scope should be using 'use function' or be fully namespaced. 

PHP searches for functions in the local namespaces, and in case it fails, makes the same search in the global scope. Anytime a native function is referenced this way, the search (and fail) happens. This slows down the scripts.

The speed bump range from 2 to 8 %, depending on the availability of functions in the local scope. The overall bump is about 1 µs per functioncall, which makes it a micro optimisation until a lot of function calls are made.


Based on one of `Marco Pivetta tweet <https://twitter.com/Ocramius/status/811504929357660160>`_ and this `blog post <http://veewee.github.io/blog/optimizing-php-performance-by-fq-function-calls/>`_

.. code-block:: php

   <?php
   
   namespace X {
       use function strtolower as strtolower_aliased;
       
       // PHP searches for strtolower in X, fails, then falls back to global scope, succeeds.
       $a = strtolower($b);
   
       // PHP searches for strtolower in global scope, succeeds.
       $a = \strtolower($b);
   
       // PHP searches for strtolower_aliased in global scope, succeeds.
       $a = \strtolower_aliased($b);
   }
   
   ?>

+--------------+-----------------------+
| Command Line | Php/ShouldUseFunction |
+--------------+-----------------------+
| Analyzers    | :ref:`Performances`   |
+--------------+-----------------------+


.. _should-use-local-class:

Should Use Local Class
######################


Methods in a class should use the class, or be functions.

Methods should use $this with another method or a property, or call parent::. Static methods should call another static method, or a static property. 
Methods which are overwritten by a child class are omitted : the parent class act as a default value for the children class, and this is correct.

.. code-block:: php

   <?php
   
   class foo {
       public function '__construct() {
           // This method should do something locally, or be removed.
       }
   }
   
   class bar extends foo {
       private $a = 1;
       
       public function '__construct() {
           // Calling parent:: is sufficient
           parent::'__construct();
       }
   
       public function barbar() {
           // This is acting on the local object
           $this->a++;
       }
   
       public function barfoo($b) {
           // This has no action on the local object. It could be a function or a closure where needed
           return 3 + $b;
       }
   }
   
   ?>


Note that a method using a class constant is not considered as using the local class, for this analyzer.

+--------------+-----------------------------------------------------------------------------------------+
| Command Line | Classes/ShouldUseThis                                                                   |
+--------------+-----------------------------------------------------------------------------------------+
| clearPHP     | `not-a-method <https://github.com/dseguy/clearPHP/tree/master/rules/not-a-method.md>`__ |
+--------------+-----------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                          |
+--------------+-----------------------------------------------------------------------------------------+


.. _should-use-prepared-statement:

Should Use Prepared Statement
#############################


Modern databases provides support for prepared statement : it separates the query from the processed data and highten significantly the security. 

Building queries with concatenations is not recommended, though not always avoidable. When possible, use prepared statements.

+--------------+-------------------------------------+
| Command Line | Security/ShouldUsePreparedStatement |
+--------------+-------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Security`     |
+--------------+-------------------------------------+


.. _should-use-setcookie():

Should Use SetCookie()
######################


Use `'setcookie() <http://www.php.net/setcookie>`_ or `'setrawcookie() <http://www.php.net/setrawcookie>`_. Avoid using `'header() <http://www.php.net/header>`_ to do so, as the PHP native functions are more convenient and easier to spot during a refactoring.

`'setcookie() <http://www.php.net/setcookie>`_ applies some encoding internally, for the value of the cookie and the date of expiration. Rarely, this encoding has to be skipped : then, use setrawencoding().

Both functions help by giving a checklist of important attributes to be used with the cookie. 

.. code-block:: php

   <?php
   
   // same as below
   setcookie(myCookie, 'chocolate', time()+3600, /, , true, true);
   
   // same as above. Slots for path and domain are omitted, but should be used whenever possible
   header('Set-Cookie: myCookie=chocolate; Expires='.date('r', (time()+3600)).'; Secure; HttpOnly');
   
   ?>


See also : `Set-Cookie <https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie>`_.

+--------------+------------------+
| Command Line | Php/UseSetCookie |
+--------------+------------------+
| Analyzers    | :ref:`Analyze`   |
+--------------+------------------+


.. _should-use-array\_column():

Should Use array_column()
#########################


Should use `'array_column() <http://www.php.net/array_column>`_.

`'array_column() <http://www.php.net/array_column>`_ is a native PHP function, that extract a property or a index from a array of object, or a multidimensional array. This prevents the usage of foreach to collect those values.

.. code-block:: php

   <?php
   
   $a = array(array('b' => 1), 
              array('b' => 2, 'c' => 3), 
              array(          'c' => 4)); // b doesn't always exists
   
   $bColumn = array_column($a, 'b');
   
   // Slow and cumbersome code
   $bColumn = array();
   foreach($a as $k => $v) {
       if ('isset($v['b'])) {
           $bColumn[] = $v['b'];
       }
   }
   
   ?>


`'array_column() <http://www.php.net/array_column>`_ is faster than `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_ (with or without the `'isset() <http://www.php.net/isset>`_ test) with 3 elements or more, and it is significantly faster beyond 5 elements. Memory consumption is the same.

See also `[blog] `'array_column() <http://www.php.net/array_column>`_ <https://benramsey.com/projects/array-column/>`_.

+--------------+-------------------------------------+
| Command Line | Php/ShouldUseArrayColumn            |
+--------------+-------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Performances` |
+--------------+-------------------------------------+


.. _should-use-session\_regenerateid():

Should Use session_regenerateid()
#################################


session_regenerateid() should be used when sessions are used.

When using sessions, a session ID is assigned to the user. It is a random number, used to connect the user and its data on the server. Actually, anyone with the session ID may have access to the data. This is why those session ID are so long and complex.

A good approach to protect the session ID is to reduce its lifespan : the shorter the time of use, the better. While changing the session ID at every hit on the page may no be possible, a more reasonable approach is to change the session id when an important action is about to take place. What important means is left to the application to decide.

Based on this philopsophy, a code source that uses Zend\Session but never uses Zend\Session::regenerateId() has to be updated.

.. code-block:: php

   <?php
   
       session_start();
       
       $id = (int) $_SESSION['id'];
       // no usage of session_regenerateid() anywhere triggers the analysis
       
       // basic regeneration every 20 hits on the page. 
       if (++$_SESSION['count'] > 20) {
           session_regenerateid();
       }
   
   ?>


See `session_regenerateid() <http://php.net/session_regenerate_id>`_ and `PHP Security Guide: Sessions <http://phpsec.org/projects/guide/4.html>`_.

+--------------+---------------------------------------+
| Command Line | Security/ShouldUseSessionRegenerateId |
+--------------+---------------------------------------+
| Analyzers    | :ref:`Security`                       |
+--------------+---------------------------------------+


.. _silently-cast-integer:

Silently Cast Integer
#####################


Those are integer literals that are cast to a float when running PHP. They are simply too big for the current PHP version, and PHP resorts to cast them into a float, which has a much larger capacity but a lower precision.

Compare your literals to PHP_MAX_INT (typically 9223372036854775807) and PHP_MIN_INT (typically -9223372036854775808).
This applies to binary (0b10101...), octals (0123123...) and hexadecimals (0xfffff...) too. 

.. code-block:: php

   <?php
   
   echo 0b1010101101010110101011010101011010101011010101011010101011010111;
   //6173123008118052203
   echo 0b10101011010101101010110101010110101010110101010110101010110101111;
   //1.2346246016236E+19
   
   echo 0123123123123123123123;
   //1498121094048818771
   echo 01231231231231231231231;
   //1.1984968752391E+19
   
   echo 0x12309812311230;
   //5119979279159856
   echo 0x12309812311230fed;
   //2.0971435127439E+19
   
   echo 9223372036854775807; //PHP_MAX_INT
   //9223372036854775807
   echo 9223372036854775808;
   9.2233720368548E+18
   
   ?>

+--------------+--------------------------+
| Command Line | Type/SilentlyCastInteger |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _simple-global-variable:

Simple Global Variable
######################


The global keyword should only be used with simple variables. Since PHP 7, it cannot be used with complex or dynamic structures.

.. code-block:: php

   <?php
   
   // Forbidden in PHP 7
   global $normalGlobal;
   
   // Forbidden in PHP 7
   global $$variable->global ;
   
   // Tolerated in PHP 7
   global ${$variable->global};
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/GlobalWithoutSimpleVariable                                                                            |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _simplify-regex:

Simplify Regex
##############


PRCE regex are a powerful way to search inside strings, but they also come at the price of performance. When the query is simple enough, try using `'strpos() <http://www.php.net/strpos>`_ or `'stripos() <http://www.php.net/stripos>`_ instead.

.. code-block:: php

   <?php
   
   // simple preg calls
   if (preg_match('/a/', $string))  {}
   if (preg_match('/b/i', $string)) {} // case insensitive
   
   // light replacements
   if( strpos('a', $string)) {}
   if( stripos('b', $string)) {}       // case insensitive
   
   ?>

+--------------+-----------------------+
| Command Line | Structures/SimplePreg |
+--------------+-----------------------+
| Analyzers    | :ref:`Performances`   |
+--------------+-----------------------+


.. _slimphp-1.0.0-undefined-classes:

SlimPHP 1.0.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 1.0.0 of SlimPHP.

SlimPHP 1.0.0 has 22 classes, no traits and no interfaces;

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp10 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-1.1.0-undefined-classes:

SlimPHP 1.1.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 1.1.0 of SlimPHP.

SlimPHP 1.1.0 has 33 classes, no traits and no interfaces;

11 new classes. 

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp11 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-1.2.0-undefined-classes:

SlimPHP 1.2.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 1.2.0 of SlimPHP.

SlimPHP 1.2.0 has 35 classes, no traits and no interfaces;

14 new classes. 12 removed classes. 

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp12 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-1.3.0-undefined-classes:

SlimPHP 1.3.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 1.3.0 of SlimPHP.

SlimPHP 1.3.0 has 33 classes, no traits and no interfaces;

4 new classes. 6 removed classes. 

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp13 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-1.5.0-undefined-classes:

SlimPHP 1.5.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 1.5.0 of SlimPHP.

SlimPHP 1.5.0 has 33 classes, no traits and no interfaces;

1 new class. 1 removed class.

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp15 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-1.6.0-undefined-classes:

SlimPHP 1.6.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 1.6.0 of SlimPHP.

SlimPHP 1.6.0 has 45 classes, no traits and no interfaces;

25 new classes. 13 removed classes. 

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp16 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-2.0.0-undefined-classes:

SlimPHP 2.0.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 2.0.0 of SlimPHP.

SlimPHP 2.0.0 has 44 classes, no traits and no interfaces;

21 new classes. 22 removed classes. 

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp20 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-2.1.0-undefined-classes:

SlimPHP 2.1.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 2.1.0 of SlimPHP.

SlimPHP 2.1.0 has 44 classes, no traits and no interfaces;

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp21 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-2.2.0-undefined-classes:

SlimPHP 2.2.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 2.2.0 of SlimPHP.

SlimPHP 2.2.0 has 45 classes, no traits and no interfaces;

2 new classes. 1 removed class. 
See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp22 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-2.3.0-undefined-classes:

SlimPHP 2.3.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 2.3.0 of SlimPHP.

SlimPHP 2.3.0 has 48 classes, no traits and no interfaces;

5 new classes. 2 removed classes. 

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp23 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-2.4.0-undefined-classes:

SlimPHP 2.4.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 2.4.0 of SlimPHP.

SlimPHP 2.4.0 has 48 classes, no traits and no interfaces;

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp24 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-2.5.0-undefined-classes:

SlimPHP 2.5.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 2.5.0 of SlimPHP.

SlimPHP 2.5.0 has 50 classes, no traits and no interfaces;

2 new classes.  

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp25 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-2.6.0-undefined-classes:

SlimPHP 2.6.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 2.6.0 of SlimPHP.

SlimPHP 2.6.0 has 50 classes, no traits and no interfaces;

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp26 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-3.0.0-undefined-classes:

SlimPHP 3.0.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 3.0.0 of SlimPHP.

SlimPHP 3.0.0 has 55 classes, 2 traits and 9 interfaces;

49 new classes, 9 new interfaces, 2 new traits. 44 removed classes.

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp30 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-3.1.0-undefined-classes:

SlimPHP 3.1.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 3.1.0 of SlimPHP.

SlimPHP 3.1.0 has 55 classes, 2 traits and 9 interfaces;

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp31 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-3.2.0-undefined-classes:

SlimPHP 3.2.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 3.2.0 of SlimPHP.

SlimPHP 3.2.0 has 59 classes, 2 traits and 9 interfaces;

4 new classes.  

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp32 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-3.3.0-undefined-classes:

SlimPHP 3.3.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 3.3.0 of SlimPHP.

SlimPHP 3.3.0 has 60 classes, 2 traits and 9 interfaces;

1 new classe.

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp33 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-3.4.0-undefined-classes:

SlimPHP 3.4.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 3.4.0 of SlimPHP.

SlimPHP 3.4.0 has 64 classes, 2 traits and 9 interfaces;

4 new classes.

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp34 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-3.5.0-undefined-classes:

SlimPHP 3.5.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 3.5.0 of SlimPHP.

SlimPHP 3.5.0 has 67 classes, 2 traits and 9 interfaces;

3 new classes. 

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp35 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-3.6.0-undefined-classes:

SlimPHP 3.6.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 3.6.0 of SlimPHP.

SlimPHP 3.6.0 has 67 classes, 2 traits and 9 interfaces;

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp36 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-3.7.0-undefined-classes:

SlimPHP 3.7.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 3.7.0 of SlimPHP.

SlimPHP 3.7.0 has 67 classes, 2 traits and 9 interfaces;

See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp37 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slimphp-3.8.0-undefined-classes:

SlimPHP 3.8.0 Undefined Classes
###############################


SlimPHP classes, interfaces and traits that are not defined in version 3.8.0 of SlimPHP.

SlimPHP 3.8.0 has 68 classes, 2 traits and 9 interfaces;

1 new classe.
 
See also : `SlimPHP <https://www.slimframework.com/>`_ and `SlimPHP/slim <https://github.com/slimphp/Slim>`_.

+--------------+----------------+
| Command Line | Slim/Slimphp38 |
+--------------+----------------+
| Analyzers    | :ref:`Slim`    |
+--------------+----------------+


.. _slow-functions:

Slow Functions
##############


Avoid using those slow native PHP functions, and replace them with alternatives.

.. code-block:: php

   <?php
   
   $array = source();
   
   // Slow extraction of distinct values
   $array = array_unique($array);
   
   // Much faster extraction of distinct values
   $array = array_keys(array_count_values($array));
   
   ?>

+--------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------+
| Slow Function                                                |  Faster                                                                                                                  | 
+--------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------+
| `'array_diff() <http://www.php.net/array_diff>`_             |  `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_                                                 | 
| `'array_intersect() <http://www.php.net/array_intersect>`_   |  `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_                                                 | 
| `'array_key_exists() <http://www.php.net/array_key_exists>`_ |  `'isset() <http://www.php.net/isset>`_                                                                                  | 
| `'array_map() <http://www.php.net/array_map>`_               |  `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_                                                 | 
| `'array_search() <http://www.php.net/array_search>`_         |  `'array_flip() <http://www.php.net/array_flip>`_ and `'isset() <http://www.php.net/isset>`_                             | 
| `'array_udiff() <http://www.php.net/array_udiff>`_           |  Use another way                                                                                                         | 
| `'array_uintersect() <http://www.php.net/array_uintersect>`_ |  Use another way                                                                                                         | 
| `'array_unique() <http://www.php.net/array_unique>`_         |  `'array_keys() <http://www.php.net/array_keys>`_ and `'array_count_values() <http://www.php.net/array_count_values>`_   | 
| `'array_unshift() <http://www.php.net/array_unshift>`_       |  Use another way                                                                                                         | 
| `'array_walk() <http://www.php.net/array_walk>`_             |  `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_                                                 | 
| `'in_array() <http://www.php.net/in_array>`_                 |  `'isset() <http://www.php.net/isset>`_                                                                                  | 
| `'preg_replace() <http://www.php.net/preg_replace>`_         |  `'strpos() <http://www.php.net/strpos>`_                                                                                | 
| `'strstr() <http://www.php.net/strstr>`_                     |  `'strpos() <http://www.php.net/strpos>`_                                                                                | 
| `'uasort() <http://www.php.net/uasort>`_                     |  Use another way                                                                                                         | 
| `'uksort() <http://www.php.net/uksort>`_                     |  Use another way                                                                                                         | 
| `'usort() <http://www.php.net/usort>`_                       |  Use another way                                                                                                         | 
+--------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------+

+--------------+---------------------------------------------------------------------------------------------------------------------+
| Command Line | Performances/SlowFunctions                                                                                          |
+--------------+---------------------------------------------------------------------------------------------------------------------+
| clearPHP     | `avoid-those-slow-functions <https://github.com/dseguy/clearPHP/tree/master/rules/avoid-those-slow-functions.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Performances`                                                                                                 |
+--------------+---------------------------------------------------------------------------------------------------------------------+


.. _static-loop:

Static Loop
###########


Static loop may be preprocessed.

It looks like the following loops are static : the same code is executed each time, without taking into account loop variables.

.. code-block:: php

   <?php
   
   // Static loop
   $total = 0;
   for($i = 0; $i < 10; $i++) {
       $total += $i;
   }
   
   // Non-Static loop (the loop depends on the size of the array)
   $n = count($array);
   for($i = 0; $i < $n; $i++) {
       $total += $i;
   }
   
   ?>


It is possible to create loops that don't use any blind variables, though this is fairly rare.

+--------------+-----------------------+
| Command Line | Structures/StaticLoop |
+--------------+-----------------------+
| Analyzers    | :ref:`Analyze`        |
+--------------+-----------------------+


.. _static-methods-called-from-object:

Static Methods Called From Object
#################################


Static methods may be called without instantiating an object. As such, they never interact with the special variable '$this', as they do not depend on object existence. 

Besides this, static methods are normal methods that may be called directly from object context, to perform some utility task. 

To maintain code readability, it is recommended to call static method in a static way, rather than within object context.

.. code-block:: php

   <?php
       class x {
           static function y( ) {}
       }
       
       $z = new x( );
       
       $z->y( ); // Readability : no one knows it is a static call
       x::y( );  // Readability : here we know
   ?>

+--------------+---------------------------------------+
| Command Line | Classes/StaticMethodsCalledFromObject |
+--------------+---------------------------------------+
| Analyzers    | :ref:`Analyze`                        |
+--------------+---------------------------------------+


.. _static-methods-can't-contain-$this:

Static Methods Can't Contain $this
##################################


Static methods are also called 'class methods' : they may be called even if the class has no instantiated object. Thus, the local variable $this won't exist, PHP will set it to NULL as usual. 

.. code-block:: php

   <?php
   
   class foo {
       // Static method may access other static methods, or property, or none. 
       static function staticBar() {
           // This is not possible in a static method
           return self::otherStaticBar() . static::$staticProperty;
       }
   
       static function bar() {
           // This is not possible in a static method
           return $this->property;
       }
   
   }
   
   ?>


Either, this is not a static method (simply remove the static keyword), or replace all $this mention by static properties Class::$property.

+--------------+---------------------------------------------------------------------------------------------+
| Command Line | Classes/StaticContainsThis                                                                  |
+--------------+---------------------------------------------------------------------------------------------+
| clearPHP     | `no-static-this <https://github.com/dseguy/clearPHP/tree/master/rules/no-static-this.md>`__ |
+--------------+---------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                              |
+--------------+---------------------------------------------------------------------------------------------+


.. _strange-name-for-constants:

Strange Name For Constants
##########################


Those constants looks like a typo from other names.

.. code-block:: php

   <?php
   
   // This code looks OK : DIRECTORY_SEPARATOR is a native PHP constant
   $path = $path . DIRECTORY_SEPARATOR . $file;
   
   // Strange name DIRECOTRY_SEPARATOR
   $path = $path . DIRECOTRY_SEPARATOR . $file;
   
   ?>

+--------------+-----------------------+
| Command Line | Constants/StrangeName |
+--------------+-----------------------+
| Analyzers    | none                  |
+--------------+-----------------------+


.. _strange-name-for-variables:

Strange Name For Variables
##########################


Those variables looks like a typo from other names.

.. code-block:: php

   <?php
   
   class foo {
       function bar() {
           // Strange name $tihs
           return $tihs;
       }
   }
   
   ?>

+--------------+--------------------------------------------------+
| Command Line | Variables/StrangeName                            |
+--------------+--------------------------------------------------+
| Analyzers    | :ref:`Wordpress`, :ref:`Analyze`, :ref:`Analyze` |
+--------------+--------------------------------------------------+


.. _strange-names-for-methods:

Strange Names For Methods
#########################


Those methods should have another name.

Ever wondered why the '__constructor' is never called? Or the '__consturct' ? 

Those errors most often originate from typos, or quick fixes that 'don't require testing'. Some other times, they were badly chosen, or ran into PHP's own reservations. 

.. code-block:: php

   <?php
   
   class foo {
       // The real constructor
       function '__construct() {}
   
       // The fake constructor
       function __constructor() {}
       
       // The 'typo'ed' constructor
       function __consturct() {}
       
       // This doesn't clone
       function clone() {}
   }
   
   ?>

+--------------+---------------------+
| Command Line | Classes/StrangeName |
+--------------+---------------------+
| Analyzers    | none                |
+--------------+---------------------+


.. _strict-comparison-with-booleans:

Strict Comparison With Booleans
###############################


Booleans may be easily mistaken with other values, especially when the function may return integer or boolean as a normal course of action. 

It is encouraged to use strict comparison === or !== when booleans are involved in a comparison.

+--------------+------------------------------------+
| Command Line | Structures/BooleanStrictComparison |
+--------------+------------------------------------+
| Analyzers    | :ref:`Analyze`                     |
+--------------+------------------------------------+


.. _string-may-hold-a-variable:

String May Hold A Variable
##########################


Those strings looks like holding a variable. 

Single quotes and Nowdoc syntax may include $ signs that are treated as literals, and not replaced with a variable value. 

However, there are some potential variables in those strings, making it possible for an error : the variable was forgotten and will be published as such. It is worth checking the content and make sure those strings are not variables.

.. code-block:: php

   <?php
   
   $a = 2;
   
   // Explicit variable, but literal effect is needed
   echo '$a is '.$a;
   
   // One of the variable has been forgotten
   echo '$a is $a';
   
   // $CAD is not a variable, rather a currency unit
   $total = 12;
   echo $total.' $CAD';
   
   // $CAD is not a variable, rather a currency unit
   $total = 12;
   
   // Here, $total has been forgotten
   echo <<<'TEXT'
   $total $CAD
   TEXT;
   
   ?>

+--------------+--------------------------+
| Command Line | Type/StringHoldAVariable |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _strings-with-strange-space:

Strings With Strange Space
##########################


An invisible space may be mistaken for a normal space. 

However, PHP does straight comparisons, and may fail at recognizing. This analysis reports when it finds such strange spaces inside strings.

PHP doesn't mistake space and tables for whitespace when tokenizing the code.

This analysis doesn't report Unicode Codepoint Notation : those are clearly visible in the code.

.. code-block:: php

   <?php
   
   // PHP 7 notation, 
   $a = \u{3000};
   $b = ;
   
   // Displays false
   var_dump($a === $b);
   
   ?>


See also `Unicode spaces <https://www.cs.tut.fi/~jkorpela/chars/spaces.html>`_, and `disallow irregular whitespace (no-irregular-whitespace) <http://eslint.org/docs/rules/no-irregular-whitespace>`_.

+--------------+-----------------------------+
| Command Line | Type/StringWithStrangeSpace |
+--------------+-----------------------------+
| Analyzers    | :ref:`Analyze`              |
+--------------+-----------------------------+


.. _strpos-comparison:

Strpos Comparison
#################


`'strpos() <http://www.php.net/strpos>`_, and several PHP native functions, returns a string position, starting at 0, or false, in case of failure. 

.. code-block:: php

   <?php
   
   // This is the best comparison
   if (strpos($string, 'a') === false) { }
   
   // This is OK, as 2 won't be mistaken with false
   if (strpos($string, 'a') == 2) { }
   
   // strpos is one of the 26 functions that may behave this way
   if (preg_match($regex, $string)) { } 
   
   // This works like above, catching the value for later reuse
   if ($a = strpos($string, 'a')) { }
   
   // This misses the case where 'a' is the first char of the string
   if (strpos($string, 'a')) { }
   
   // This misses the case where 'a' is the first char of the string, just like above
   if (strpos($string, 'a') == 0) { }
   
   ?>


It is recommended to check the reslt of strpos with === or !==, so as to avoid confusing 0 and false. 

This analyzer list all the `'strpos() <http://www.php.net/strpos>`_-like functions that are directly compared with == or !=. preg_match(), when its first argument is a literal, is omitted : this function only returns NULL in case of regex error.

+--------------+-----------------------------------------------------------------------------------------------------+
| Command Line | Structures/StrposCompare                                                                            |
+--------------+-----------------------------------------------------------------------------------------------------+
| clearPHP     | `strict-comparisons <https://github.com/dseguy/clearPHP/tree/master/rules/strict-comparisons.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                      |
+--------------+-----------------------------------------------------------------------------------------------------+


.. _structures/noreferenceonleft:

Structures/NoReferenceOnLeft
############################


Do not use references as the right element in an assignation. 

.. code-block:: php

   <?php
   
   $b = 2;
   $c = 3;
   
   $a = &$b + $c;
   // $a === 2 === $b;
   
   $a = $b + $c;
   // $a === 5
   
   ?>


This is the case for most situations : addition, multiplication, bitshift, logical, power, concatenation.
Note that PHP won't compile the code if the operator is a short operator (+=, .=, etc.), nor if the & is on the right side of the operator.

+--------------+------------------------------+
| Command Line | Structures/NoReferenceOnLeft |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _suspicious-comparison:

Suspicious Comparison
#####################


The comparison seems to be misplaced.

A comparison happens in the the last argument, while the actual function expect another type : this may be the case of a badly placed parenthesis.

.. code-block:: php

   <?php
   
   // trim expect a string, a boolean is given.
   if (trim($str === '')){
   
   }
   
   // Just move the first closing parenthesis to give back its actual meaning
   if (trim($str === '')){
   
   }
   
   ?>


Original idea by Vladimir Reznichenko.

+--------------+---------------------------------+
| Command Line | Structures/SuspiciousComparison |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`                  |
+--------------+---------------------------------+


.. _switch-to-switch:

Switch To Switch
################


The following structures are based on if / elseif / else. Since they have more than three conditions (not withstanding the final else), it is recommended to use the switch structure, so as to make this more readable.

On the other hand, `'switch() <http://php.net/manual/en/control-structures.switch.php>`_ structures will less than 3 elements should be expressed as a if / else structure.

Note that if condition that uses strict typing (=== or !==) can't be converted to `'switch() <http://php.net/manual/en/control-structures.switch.php>`_ as the latter only performs == or != comparisons.

.. code-block:: php

   <?php
   
   if ($a == 1) {
   
   } elseif ($a == 2) {
   
   } elseif ($a == 3) {
   
   } elseif ($a == 4) {
   
   } else {
   
   }
   
   // Better way to write long if/else lists
   switch ($a) {
       case 1 : 
           doSomething(1);
           'break 1;
       
       case 2 : 
           doSomething(2);
           'break 1;
   
       case 3 : 
           doSomething(3);
           'break 1;
   
       case 4 : 
           doSomething(4);
           'break 1;
       
       default :
           doSomething();
           'break 1;
   }
   
   ?>

+--------------+---------------------------+
| Command Line | Structures/SwitchToSwitch |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _switch-with-too-many-default:

Switch With Too Many Default
############################


Switch statements should only hold one default, not more. Check the code and remove the extra default.  

PHP 7.0 won't compile a script that allows for several default cases. 

Multiple default happens often with large `'switch() <http://php.net/manual/en/control-structures.switch.php>`_.

.. code-block:: php

   <?php
   
   switch($a) {
       case 1 : 
           'break;
       default : 
           'break;
       case 2 : 
           'break;
       default :  // This default is never reached
           'break;
   }
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/SwitchWithMultipleDefault                                                                       |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _switch-without-default:

Switch Without Default
######################


Always use a default statement in `'switch() <http://php.net/manual/en/control-structures.switch.php>`_.

Switch statements hold a number of 'case' that cover all known situations, and a 'default' one which is executed when all other options are exhausted. 

.. code-block:: php

   <?php
   
   // Missing default
   switch($format) {
       case 'gif' : 
           processGif();
           'break 1;
       
       case 'jpeg' : 
           processJpeg();
           'break 1;
           
       case 'bmp' :
           throw new UnsupportedFormat($format);
   }
   // In case $format is not known, then switch is ignored and no processing happens, leading to preparation errors
   
   
   // switch with default
   switch($format) {
       case 'text' : 
           processText();
           'break 1;
       
       case 'jpeg' : 
           processJpeg();
           'break 1;
           
       case 'rtf' :
           throw new UnsupportedFormat($format);
           
       default :
           throw new UnknownFileFormat($format);
   }
   // In case $format is not known, an exception is thrown for processing 
   
   ?>


Most of the time, `'switch() <http://php.net/manual/en/control-structures.switch.php>`_ do need a default case, so as to catch the odd situation where the 'value is not what it was expected'. This is a good place to catch unexpected values, to set a default behavior.

+--------------+-------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/SwitchWithoutDefault                                                                                   |
+--------------+-------------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-switch-without-default <https://github.com/dseguy/clearPHP/tree/master/rules/no-switch-without-default.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                                    |
+--------------+-------------------------------------------------------------------------------------------------------------------+


.. _ternary-in-concat:

Ternary In Concat
#################


Ternary operator has higher priority than dot '.' for concatenation. This means that : 

.. code-block:: php

   <?php
     print 'B'.$b.'C'. $b > 1 ? 'D' : 'E';
   ?>


prints actually 'E', instead of the awaited 'B0CE'.

To be safe, always add parenthesis when using ternary operator with concatenation.

+--------------+----------------------------+
| Command Line | Structures/TernaryInConcat |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _throw-functioncall:

Throw Functioncall
##################


The throw keyword is excepted to use an exception. Calling a function to prepare that exception before throwing it is possible, but forgetting the new keyword is also possible. 

.. code-block:: php

   <?php
   
   // Forgotten new
   throw \RuntimeException('error!');
   
   // Code is OK, function returns an exception
   throw getException(ERROR_TYPE, 'error!');
   
   function getException(ERROR_TYPE, $message) {
       return new \RuntimeException($messsage);
   }
   
   ?>


When the new keyword is forgotten, then the class construtor is used as a functionname, and now exception is emited, but an 'Undefined function' fatal error is emited.

+--------------+------------------------------+
| Command Line | Exceptions/ThrowFunctioncall |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _throw-in-destruct:

Throw In Destruct
#################


According to the manual, 'Attempting to throw an exception from a destructor (called in the time of script termination) causes a fatal error.'

The destructor may be called during the lifespan of the script, but it is not certain. If the exception is thrown later, the script may end up with a fatal error. 
Thus, it is recommended to avoid throwing exceptions within the `'__destruct <http://php.net/manual/en/language.oop5.decon.php>`_ method of a class.

.. code-block:: php

   <?php
   
   // No exception thrown
   class Bar { 
       function '__construct() {
           throw new Exception(''__construct');
       }
   
       function '__destruct() {
           $this->cleanObject();
       }
   }
   
   // Potential crash
   class Foo { 
       function '__destruct() {
           throw new Exception(''__destruct');
       }
   }
   
   ?>

+--------------+-------------------------+
| Command Line | Classes/ThrowInDestruct |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _thrown-exceptions:

Thrown Exceptions
#################


All Zend Framework thrown exceptions. 

.. code-block:: php

   <?php
   
   //All directly thrown exceptions are reported
   throw new \RuntimeException('Error while processing');
   
   // Zend exceptions are also reported, thrown or not
   $w = new \Zend\Filter\Exception\ExtensionNotLoadedException();
   throw $w;
   
   ?>

+--------------+------------------------+
| Command Line | ZendF/ThrownExceptions |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _throws-an-assignement:

Throws An Assignement
#####################


It is possible to throw an exception, and, in the same time, assign this exception to a variable.

.. code-block:: php

   <?php
   
       // $e is useful, though not by much
       $e = new() Exception();
       throw $e;
   
       // $e is useless
       throw $e = new() Exception();
   
   ?>


However, $e will never be used, as the exception is thrown, and any following code is not executed. 

The assignement should be removed.

+--------------+----------------------------+
| Command Line | Structures/ThrowsAndAssign |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _timestamp-difference:

Timestamp Difference
####################


time() and `'microtime() <http://www.php.net/microtime>`_ shouldn't be used to calculate duration or with durations. 

time() and `'microtime() <http://www.php.net/microtime>`_ are subject to variations, depending on system clock variations, such as daylight saving time difference (every spring and fall, one hour variation), or leap seconds, happening on June, 30th or december 31th, as announcec by IERS.

.. code-block:: php

   <?php
   
   // Calculating tomorow, same hour, the wrong way
   // tomorrow is not always in 86400s, especially in countries with daylight saving 
   $tomorrow = time()  + 86400; 
   
   // Good way to calculate tomorrow
   $datetime = new DateTime('tomorrow');
   
   ?>


When the difference may be rounded to a larger time unit (rounding the difference to days, or several hours), the variation may be ignored safely.

When the difference is very small, it requires a better way to mesure time difference, such as ticks, ext/hrtime, or including a check on the actual time zone (`'ini_get() <http://www.php.net/ini_get>`_ with 'date.timezone').

+--------------+--------------------------------+
| Command Line | Structures/TimestampDifference |
+--------------+--------------------------------+
| Analyzers    | :ref:`Analyze`                 |
+--------------+--------------------------------+


.. _too-many-finds:

Too Many Finds
##############


Too many methods called 'find*' in this class. It is may be time to consider the `Specification pattern <https://en.wikipedia.org/wiki/Specification_pattern>`_.

.. code-block:: php

   <?php
   
   // quite a fishy interface
   interface UserInterface {
       public function findByEmail($email);
       public function findByUsername($username);
       public function findByFirstName($firstname);
       public function findByLastName($lastname);
       public function findByName($name);
       public function findById($id);
   
       public function insert($user);
       public function update($user);
   }
   
   ?>


See also `On Taming Repository Classes in Doctrine <https://beberlei.de/2013/03/04/doctrine_repositories.html>`_ , 
`On Taming Repository Classes in Doctrine… Among other things. <http://blog.kevingomez.fr/2015/02/07/on-taming-repository-classes-in-doctrine-among-other-things/>`_,
`specifications <https://slides.pixelart.at/2017-02-04/fosdem/specifications/#/>`_.

+--------------+----------------------+
| Command Line | Classes/TooManyFinds |
+--------------+----------------------+
| Analyzers    | :ref:`Analyze`       |
+--------------+----------------------+


.. _too-many-injections:

Too Many Injections
###################


When a class is constructed with more than four dependencies, it should be split into smaller classes.

.. code-block:: php

   <?php
   
   // This class relies on 5 other instances. 
   // It is probably doing too much.
   class Foo {
       public function '__construct(
               A $a, 
               B $b, 
               C $c,
               D $d
               E $e ) {
           $this->a = $a;
           $this->b = $b;
           $this->d = $d;
           $this->d = $d;
           $this->e = $e;
       }
   }
   
   ?>


See also `Dependency Injection Smells <http://seregazhuk.github.io/2017/05/04/di-smells/>`_.

+--------------+---------------------------+
| Command Line | Classes/TooManyInjections |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _too-many-local-variables:

Too Many Local Variables
########################


Too many local variables were found in the methods. When over 15 variables are found in such a method, a violation is reported.

Local variables exclude globals (imported with global) and arguments. 

When too many variables are used in a function, it is a code smells. The function is trying to do too much and needs extra space for juggling.
Beyond 15 variables, it becomes difficult to keep track of their name and usage, leading to confusion, overwritting or hijacking. 

.. code-block:: php

   <?php
   
   // This function is OK : 3 vars are arguments, 3 others are globals.
   function a20a3g3($a1, $a2, $a3) {
       global $a4, $a5, $a6;
       
       $a1  = 1;
       $a2  = 2;
       $a3  = 3 ;
       $a4  = 4 ;
       $a5  = 5 ;
       $a6  = 6 ;
       $a7  = 7 ;
       $a8  = 8 ;
       $a9  = 9 ;
       $a10 = 10;
       $a11  = 11;
       $a12  = 12;
       $a13  = 13 ;
       $a14  = 14 ;
       $a15  = 15 ;
       $a16  = 16 ;
       $a17  = 17 ;
       $a18  = 18 ;
       $a19  = 19 ;
       $a20 = 20;
   
   }
   
   // This function has too many variables
   function a20() {
       
       $a1  = 1;
       $a2  = 2;
       $a3  = 3 ;
       $a4  = 4 ;
       $a5  = 5 ;
       $a6  = 6 ;
       $a7  = 7 ;
       $a8  = 8 ;
       $a9  = 9 ;
       $a10 = 10;
       $a11  = 11;
       $a12  = 12;
       $a13  = 13 ;
       $a14  = 14 ;
       $a15  = 15 ;
       $a16  = 16 ;
       $a17  = 17 ;
       $a18  = 18 ;
       $a19  = 19 ;
       $a20 = 20;
   
   }
   
   ?>

+--------------+---------------------------------+
| Command Line | Functions/TooManyLocalVariables |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`                  |
+--------------+---------------------------------+


.. _uncaught-exceptions:

Uncaught Exceptions
###################


The following exceptions are thrown in the code, but are never caught. 

Either they will lead to a fatal error, or they have to be caught by a larger application.

+--------------+-------------------------------+
| Command Line | Exceptions/UncaughtExceptions |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _unchecked-resources:

Unchecked Resources
###################


Resources are created, but never checked before being used. This is not safe.

Always check that resources are correctly created before using them

.. code-block:: php

   <?php
   
   // always check that the resource is created correctly
   $fp = fopen($d,'r');
   if ($fp === false) {
       throw new Exception('File not found');
   } 
   $firstLine = fread($fp);
   
   // This directory is not checked : the path may not exist and return false
   $uncheckedDir = opendir($pathToDir);
   while(readdir($uncheckedDir)) {
       // do something()
   }
   
   // This file is not checked : the path may not exist or be unreadable and return false
   $fp = fopen($pathToFile);
   while($line = freads($fp)) {
       $text .= $line;
   }
   
   // quick unsafe one-liner : using bzclose on an unchecked resource
   bzclose(bzopen('file'));
   
   ?>

+--------------+-------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/UncheckedResources                                                                               |
+--------------+-------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-unchecked-resources <https://github.com/dseguy/clearPHP/tree/master/rules/no-unchecked-resources.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                              |
+--------------+-------------------------------------------------------------------------------------------------------------+


.. _undefined-caught-exceptions:

Undefined Caught Exceptions
###########################


Those are exceptions that are caught in the code, but are not defined in the application. 

They may be externally defined, such as in core PHP, extensions or libraries. Make sure those exceptions are usefull to your application : otherwise, they are dead code.

.. code-block:: php

   <?php
   
   try {
       library_function($some, $args);
       
   } catch (LibraryException $e) {
       // This exception is not defined, and probably belongs to Library
       print Library failed\n;
   
   } catch (OtherLibraryException $e) {
       // This exception is not defined, and probably do not belongs to this code
       print Library failed\n;
   
   } catch (\Exception $e) {
       // This exception is a PHP standard exception
       print Something went wrong, but not at Libary level\n;
   }
   
   ?>

+--------------+-------------------------------+
| Command Line | Exceptions/CaughtButNotThrown |
+--------------+-------------------------------+
| Analyzers    | :ref:`Dead code <dead-code>`  |
+--------------+-------------------------------+


.. _undefined-class-2.0:

Undefined Class 2.0
###################


Mark classes, interfaces and traits when they are not available in Zend Framework 2.0.

.. code-block:: php

   <?php
   
   // 2.0 only class
   $a = new Zend\Authentication\Adapter\Digest();
   
   // Not a 2.0 class (2.1+)
   $b = $d 'instanceof Zend\Authentication\Adapter\Callback;
   
   ?>


See `Zend Framework 2.0 <https://framework.zend.com/manual/2.0/en/index.html>`_.

+--------------+------------------------+
| Command Line | ZendF/UndefinedClass20 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _undefined-class-2.1:

Undefined Class 2.1
###################


Mark classes, interfaces and traits when they are not available in Zend Framework 2.0.

.. code-block:: php

   <?php
   
   // 2.0 only class
   $a = new Zend\Authentication\Adapter\Digest();
   
   // Not a 2.0 class (2.1+)
   $b = $d 'instanceof Zend\Authentication\Adapter\Callback;
   
   ?>


See `Zend Framework 2.1 <https://framework.zend.com/manual/2.1/en/index.html>`_.

+--------------+------------------------+
| Command Line | ZendF/UndefinedClass21 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _undefined-class-2.2:

Undefined Class 2.2
###################


Mark classes, interfaces and traits when they are not available in Zend Framework 2.2.

.. code-block:: php

   <?php
   
   // 2.2 class (may be other versions)
   $a = new Zend\Authentication\Adapter\DbTable\AbstractAdapter();
   
   // Not a 2.2 class (2.2+)
   $b = $d 'instanceof Zend\Authentication\Adapter\Callback;
   
   ?>


See `Zend Framework 2.2 <https://framework.zend.com/manual/2.2/en/index.html>`_.

+--------------+------------------------+
| Command Line | ZendF/UndefinedClass22 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _undefined-class-2.3:

Undefined Class 2.3
###################


Mark classes, interfaces and traits when they are not available in Zend Framework 2.3.

.. code-block:: php

   <?php
   
   // 2.3 class
   $a = new Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter();
   
   // Not a 2.3 class
   $b = $d 'instanceof Zend\Cache\Module;
   
   ?>


See `Zend Framework 2.3 <https://framework.zend.com/manual/2.3/en/index.html>`_.

+--------------+------------------------+
| Command Line | ZendF/UndefinedClass23 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _undefined-class-2.4:

Undefined Class 2.4
###################


Mark classes, interfaces and traits when they are not available in Zend Framework 2.4.

.. code-block:: php

   <?php
   // 2.4 class
   $a = new Zend\Authentication\Adapter\DbTable\AbstractAdapter();
   
   // Not a 2.4 class
   $b = $d 'instanceof Zend\Cache\Service\StorageAdapterPluginManagerFactory;
   
   ?>


See `Zend Framework 2.4 <https://framework.zend.com/manual/2.4/en/index.html>`_.

+--------------+------------------------+
| Command Line | ZendF/UndefinedClass24 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _undefined-class-2.5:

Undefined Class 2.5
###################


Mark classes, interfaces and traits when they are not available in Zend Framework 2.5.

.. code-block:: php

   <?php
   // 2.5 class
   $a = new Zend\Authentication\Adapter\DbTable\AbstractAdapter();
   
   // Not a 2.5 class
   $b = $d 'instanceof Zend\Cache\Service\PatternPluginManagerFactory;
   
   ?>

+--------------+------------------------+
| Command Line | ZendF/UndefinedClass25 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _undefined-class-3.0:

Undefined Class 3.0
###################


Mark classes, interfaces and traits when they are not available in Zend Framework 2.5.

.. code-block:: php

   <?php
   // 3.0 class
   $a = new Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter();
   
   // Not a 3.0 class
   $b = $d 'instanceof Zend\EventManager\GlobalEventManager;
   
   ?>

+--------------+------------------------+
| Command Line | ZendF/UndefinedClass30 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _undefined-class-constants:

Undefined Class Constants
#########################


Class constants that are used, but never defined. This should yield a fatal error upon execution, but no feedback at compile level.

.. code-block:: php

   <?php
   
   class foo {
       const A = 1;
       define('B', 2);
   }
   
   // here, C is not defined in the code and is reported
   echo foo::A.foo::B.foo::C;
   
   ?>

+--------------+--------------------------------+
| Command Line | Classes/UndefinedConstants     |
+--------------+--------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Analyze` |
+--------------+--------------------------------+


.. _undefined-classes:

Undefined Classes
#################


Those classes are used in the code, but there are no definition for them.

This may happens under normal conditions, if the application makes use of an unsupported extension, that defines extra classes; 
or if some external libraries, such as PEAR, are not provided during the analysis.

.. code-block:: php

   <?php
   
   // FPDF is a classic PDF class, that is usually omitted by Exakat. 
   $o = new FPDF();
   
   // Exakat reports undefined classes in 'instanceof
   // PHP ignores them
   if ($o 'instanceof SomeClass) {
       // doSomething();
   }
   
   // Classes may be used in typehint too
   function foo(TypeHintClass $x) {
       // doSomething();
   }
   
   ?>

+--------------+--------------------------+
| Command Line | Classes/UndefinedClasses |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _undefined-constants:

Undefined Constants
###################


Constants definition can't be located.

Those constants are not defined in the code, and will raise errors, or use the fallback mechanism of being treated like a string. 

.. code-block:: php

   <?php
   
   const A = 1;
   define('B', 2);
   
   // here, C is not defined in the code and is reported
   echo A.B.C;
   
   ?>


It is recommended to define them all, or to avoid using them.

+--------------+------------------------------+
| Command Line | Constants/UndefinedConstants |
+--------------+------------------------------+
| Analyzers    | none                         |
+--------------+------------------------------+


.. _undefined-functions:

Undefined Functions
###################


Those functions are not defined in the code. This means that the functions are probably defined in a missing library, or in an extension. If not, this will yield a Fatal error at execution.

.. code-block:: php

   <?php
   
   // Undefined function 
   foo($a);
   
   // valid function, as it belongs to the ext/yaml extension
   $parsed = yaml_parse($yaml);
   
   // This function is not defined in the a\b\c namespace, nor in the global namespace
   a\b\c\foo(); 
   
   ?>

+--------------+------------------------------+
| Command Line | Functions/UndefinedFunctions |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _undefined-interfaces:

Undefined Interfaces
####################


Typehint or `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ that are relying on undefined interfaces (or classes) : they will always return false. Any condition based upon them are dead code.

.. code-block:: php

   <?php
   
   class var implements undefinedInterface {
       // If undefinedInterface is undefined, this code lints but doesn't run
   }
   
   if ($o 'instanceof undefinedInterface) {
       // This is silent dead code
   }
   
   function foo(undefinedInterface $a) {
       // This is dead code
       // it will probably be discovered at execution
   }
   
   ?>

+--------------+--------------------------------+
| Command Line | Interfaces/UndefinedInterfaces |
+--------------+--------------------------------+
| Analyzers    | :ref:`Analyze`                 |
+--------------+--------------------------------+


.. _undefined-parent:

Undefined Parent
################


List of properties and methods that are accessed using 'parent' keyword but are not defined in the parent class. 

This will be compilable but will yield a fatal error during execution.

Note that if the parent is defined (extends someClass) but someClass is not available in the tested code (it may be in composer,
another dependency, or just not there) it will not be reported.

+--------------+---------------------------+
| Command Line | Classes/UndefinedParentMP |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _undefined-properties:

Undefined Properties
####################


List of properties that are not explicitely defined in the class, its parents or traits.

+--------------+---------------------------------------------------------------------------------------------------------------+
| Command Line | Classes/UndefinedProperty                                                                                     |
+--------------+---------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-undefined-properties <https://github.com/dseguy/clearPHP/tree/master/rules/no-undefined-properties.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                                |
+--------------+---------------------------------------------------------------------------------------------------------------+


.. _undefined-trait:

Undefined Trait
###############


Those traits are undefined. 

When the using class or trait is instantiated, PHP emits a a fatal error.

.. code-block:: php

   <?php
   
   use Composer/Component/someTrait as externalTrait;
   
   trait t {
       function foo() {}
   }
   
   // This class uses trait that are all known
   class hasOnlyDefinedTrait {
       use t, externalTrait;
   }
   
   // This class uses trait that are unknown
   class hasUndefinedTrait {
       use unknownTrait, t, externalTrait;
   }
   ?>

+--------------+-----------------------+
| Command Line | Traits/UndefinedTrait |
+--------------+-----------------------+
| Analyzers    | :ref:`Analyze`        |
+--------------+-----------------------+


.. _undefined-zend-1.10:

Undefined Zend 1.10
###################


List of undefined classes or interfaces in Zend 1.10.

See `Zend Framework 1.10 <https://framework.zend.com/manual/1.10/en/manual.html>`_.

+--------------+-------------------------+
| Command Line | ZendF/UndefinedClass110 |
+--------------+-------------------------+
| Analyzers    | :ref:`ZendFramework`    |
+--------------+-------------------------+


.. _undefined-zend-1.11:

Undefined Zend 1.11
###################


List of undefined classes or interfaces in Zend 1.11

See `Zend Framework 1.11 <https://framework.zend.com/manual/1.11/en/manual.html>`_.

+--------------+-------------------------+
| Command Line | ZendF/UndefinedClass111 |
+--------------+-------------------------+
| Analyzers    | :ref:`ZendFramework`    |
+--------------+-------------------------+


.. _undefined-zend-1.12:

Undefined Zend 1.12
###################


List of undefined classes or interfaces in Zend 1.12.

See `Zend Framework 1.12 <https://framework.zend.com/manual/1.12/en/manual.html>`_.

+--------------+-------------------------+
| Command Line | ZendF/UndefinedClass112 |
+--------------+-------------------------+
| Analyzers    | :ref:`ZendFramework`    |
+--------------+-------------------------+


.. _undefined-zend-1.8:

Undefined Zend 1.8
##################


List of undefined classes or interfaces in Zend 1.8.

See `Zend Framework 1.8 <https://framework.zend.com/manual/1.8/en/index.html>`_.

+--------------+------------------------+
| Command Line | ZendF/UndefinedClass18 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _undefined-zend-1.9:

Undefined Zend 1.9
##################


List of undefined classes or interfaces in Zend 1.9.

See `Zend Framework 1.9 <https://framework.zend.com/manual/1.9/en/index.html>`_.

+--------------+------------------------+
| Command Line | ZendF/UndefinedClass19 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _undefined-static\:\:-or-self\:\::

Undefined static:: Or self::
############################


List of all undefined static and self properties and methods.

+--------------+---------------------------+
| Command Line | Classes/UndefinedStaticMP |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _unescaped-variables-in-templates:

Unescaped Variables In Templates
################################


Whenever variables are emitted, they are reported as long as they are not escaped. 

While this is quite a strict rule, it is good to know when variables are not protected at echo time. 

.. code-block:: php

   <?php
       echo $unescapedVariable;
       
       echo esc_html($escapedVariable);
   
   ?>

+--------------+------------------------------+
| Command Line | Wordpress/UnescapedVariables |
+--------------+------------------------------+
| Analyzers    | :ref:`Wordpress`             |
+--------------+------------------------------+


.. _unicode-escape-partial:

Unicode Escape Partial
######################


PHP 7 introduces a new escape sequence for strings : \u{hex}. It is backward incompatible with previous PHP versions for two reasons : 

PHP 7 will recognize en replace those sequences, while PHP 5 keep them intact.
PHP 7 will halt on partial Unicode Sequences, as it tries to understand them, but may fail. 

.. code-block:: php

   <?php
   
   echo \u{1F418}\n; 
   // PHP 5 displays the same string
   // PHP 7 displays : an elephant
   
   echo \u{NOT A UNICODE CODEPOINT}\n; 
   // PHP 5 displays the same string
   // PHP 7 emits a fatal error
   
   ?>


Is is recommended to check all those strings, and make sure they will behave correctly in PHP 7.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/UnicodeEscapePartial                                                                                   |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _unicode-escape-syntax:

Unicode Escape Syntax
#####################


Usage of the Unicode Escape syntax, with the \u{xxxxx} format, available since PHP 7.0.

.. code-block:: php

   <?php
   
   // Produce an elephant icon in PHP 7.0+
   echo \u{1F418};
   
   // Produce the raw sequence in PHP 5.0
   echo \u{1F418};
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/UnicodeEscapeSyntax                                                                                    |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _unitialized-properties:

Unitialized Properties
######################


Properties that are not initialized in the constructor, nor at definition. 

.. code-block:: php

   <?php
   
   class X {
       private $i1 = 1, $i2;
       protected $u1, $u2;
       
       function '__construct() {
           $this->i2 = 1 + $this->u2;
       }
       
       function m() {
           echo $this->i1, $this->i2, $this->u1, $this->u2;
       }
   }
   ?>


With the above class, when m() is accessed right after instantiation, there will be a missing property. 
Using default values at property definition, or setting default values in the constructor ensures that the created object is consistent.

+--------------+-------------------------------+
| Command Line | Classes/UnitializedProperties |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _unknown-directive-name:

Unknown Directive Name
######################


Unknown directives names used in the code. 

The following list has directive mentionned in the code, that are not known from PHP or any extension. If this is due to a mistake, the directive must be fixed to be actually useful.

.. code-block:: php

   <?php
   
   // non-existing directive
   $reporting_error = ini_get('reporting_error');
   $error_reporting = ini_get('error_reproting'); // Note the inversion
   if (ini_set('dump_globals')) {
       // doSomething()
   }
   
   // Correct directives
   $error_reporting = ini_get('reporting_error');
   if (ini_set('xdebug.dump_globals')) {
       // doSomething()
   }
   
   ?>

+--------------+-------------------+
| Command Line | Php/DirectiveName |
+--------------+-------------------+
| Analyzers    | :ref:`Analyze`    |
+--------------+-------------------+


.. _unkown-regex-options:

Unkown Regex Options
####################


PHP's regex support the following list of options : eimsuxADJSUX. They are detailled in the manual : [http://php.net/manual/en/reference.pcre.pattern.modifiers.php](http://php.net/manual/en/reference.pcre.pattern.modifiers.php). 

All other options are not supported, may be ignored or raise an error.

.. code-block:: php

   <?php
   
   // all options are available
   if (preg_match('/\d+/isA', $string, $results)) { }
   
   // p and h are not regex options, p is double
   if (preg_match('/\d+/php', $string, $results)) { }
   
   ?>

+--------------+------------------------------+
| Command Line | Structures/UnknownPregOption |
+--------------+------------------------------+
| Analyzers    | :ref:`Analyze`               |
+--------------+------------------------------+


.. _unpreprocessed-values:

Unpreprocessed Values
#####################


Preprocessing values is the preparation of values before PHP executes the code. 

There is no macro language in PHP, that prepares the code before compilation, bringing some confort and short syntax. Most of the time, one uses PHP itself to preprocess data. 

For example : 

.. code-block:: php

   <?php
       $days_en = 'monday,tuesday,wednesday,thursday,friday,saturday,sunday';
       $days_zh = '星期－,星期二,星期三,星期四,星期五,星期六,星期日';
   
       $days = explode(',', $lang === 'en' ? $days_en : $days_zh); 
   ?>


could be written 

.. code-block:: php

   <?php
       if ($lang === 'en') {
           $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
       } else {
           $days = ['星期－', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日'];
       }
   ?>


and avoid preprocessing the string into an array first. 

Preprocessing could be done anytime the script includes all the needed values to process the expression.

+--------------+---------------------------------------------------------------------------------------------------+
| Command Line | Structures/Unpreprocessed                                                                         |
+--------------+---------------------------------------------------------------------------------------------------+
| clearPHP     | `always-preprocess <https://github.com/dseguy/clearPHP/tree/master/rules/always-preprocess.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                    |
+--------------+---------------------------------------------------------------------------------------------------+


.. _unreachable-code:

Unreachable Code
################


Code may be unreachable, because other instructions prevent its reaching. 
For example, it be located after throw, return, `'exit() <http://www.php.net/exit>`_, `'die() <http://www.php.net/die>`_, goto, `'break <http://php.net/manual/en/control-structures.break.php>`_ or `'continue <http://php.net/manual/en/control-structures.continue.php>`_ : this way, it cannot be reached, as the previous instruction will divert the engine to another part of the code. 

.. code-block:: php

   <?php
   
   function foo() {
       $a++;
       return $a;
       $b++;      // $b++ can't be reached;
   }
   
   function bar() {
       if ($a) {
           return $a;
       } else {
           return $b;
       }
       $b++;      // $b++ can't be reached;
   }
   
   foreach($a as $b) {
       $c += $b;
       if ($c > 10) {
           'continue 1;
       } else {
           $c--;
           'continue;
       }
       $d += $e;   // this can't be reached
   }
   
   $a = 1;
   goto B;
   class foo {}    // Definitions are accessible, but not functioncalls
   B: 
   echo $a;
   
   
   ?>


This is dead code, that may be removed.

+--------------+-----------------------------------------------------------------------------------------+
| Command Line | Structures/UnreachableCode                                                              |
+--------------+-----------------------------------------------------------------------------------------+
| clearPHP     | `no-dead-code <https://github.com/dseguy/clearPHP/tree/master/rules/no-dead-code.md>`__ |
+--------------+-----------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>`                                            |
+--------------+-----------------------------------------------------------------------------------------+


.. _unresolved-catch:

Unresolved Catch
################


Catch clauses do not check for Exception existence. 

Catch clauses check that the emitted expression is of the requested Class, but if that class doesn't exist in the code, the catch clause is always false. This is dead code.

.. code-block:: php

   <?php
   
   try {
       // doSomething()
   } catch {TypoedExxeption $e) { // Do not exist Exception
       // Fix this exception
   } catch {Stdclass $e) {        // Exists, but is not an exception
       // Fix this exception
   } catch {Exception $e) {        // Actual and effective catch
       // Fix this exception
   }
   ?>

+--------------+-------------------------------------------------------------------------------------------------------+
| Command Line | Classes/UnresolvedCatch                                                                               |
+--------------+-------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-unresolved-catch <https://github.com/dseguy/clearPHP/tree/master/rules/no-unresolved-catch.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Dead code <dead-code>`                                                                          |
+--------------+-------------------------------------------------------------------------------------------------------+


.. _unresolved-classes:

Unresolved Classes
##################


The following classes are instantiated in the code, but their definition couldn't be found. 

Check for namespaces and aliases and make sure they are correctly configured.

.. code-block:: php

   <?php
   
   class Foo extends Bar {
       private function foobar() {
           // here, parent is not resolved, as Bar is not defined in the code.
           return parent::$prop;
       }
   }
   
   ?>

+--------------+---------------------------+
| Command Line | Classes/UnresolvedClasses |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _unresolved-instanceof:

Unresolved Instanceof
#####################


`'instanceof <http://php.net/manual/en/language.operators.type.php>`_ doesn't check if compared class exists. 

It checks if an variable is of a specific class. However, if the referenced class doesn't exist, because of a bug, a missed inclusion or a typo, the operator always fails, without a warning. 

.. code-block:: php

   <?php
   
   namespace X {
       class C {}
       
       // This is OK, as C is defined in X
       if ($o 'instanceof C) { }
   
       // This is not OK, as C is not defined in global
       // 'instanceof respects namespaces and use expressions
       if ($o 'instanceof \C) { }
   
       // This is not OK, as undefinedClass
       if ($o 'instanceof undefinedClass) { }
   
       // This is not OK, as $class is now a full namespace. It actually refers to \c, which doesn't exist
       $class = 'C';
       if ($o 'instanceof $class) { }
   }
   ?>


Make sure the following classes are well defined.

+--------------+-----------------------------------------------------------------------------------------------------------------+
| Command Line | Classes/UnresolvedInstanceof                                                                                    |
+--------------+-----------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-unresolved-instanceof <https://github.com/dseguy/clearPHP/tree/master/rules/no-unresolved-instanceof.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>`                                                                    |
+--------------+-----------------------------------------------------------------------------------------------------------------+


.. _unresolved-use:

Unresolved Use
##############


The following use instructions cannot be resolved to a class or a namespace. They should be dropped or fixed.

+--------------+---------------------------------------------------------------------------------------------------+
| Command Line | Namespaces/UnresolvedUse                                                                          |
+--------------+---------------------------------------------------------------------------------------------------+
| clearPHP     | `no-unresolved-use <https://github.com/dseguy/clearPHP/tree/master/rules/no-unresolved-use.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                    |
+--------------+---------------------------------------------------------------------------------------------------+


.. _unserialize-second-arg:

Unserialize Second Arg
######################


Since PHP 7, `'unserialize() <http://www.php.net/unserialize>`_ function has a second argument that limits the classes that may be unserialized. In case of a breach, this is limiting the classes accessible from `'unserialize() <http://www.php.net/unserialize>`_. 

On way to exploit unserialize, is to make PHP unserialized the data to an available class, may be one that may be auto-loaded.

.. code-block:: php

   <?php
   
   // expected Database object
   $var = unserialize('O:7:dbClass:0:{}');
   
   // unexpected load of debugClass object
   $var = unserialize('O:10:debugClass:0:{}');
   
   // Using the unserialized object
   $var->connect();
   
   ?>

+--------------+-------------------------------+
| Command Line | Security/UnserializeSecondArg |
+--------------+-------------------------------+
| Analyzers    | :ref:`Security`               |
+--------------+-------------------------------+


.. _unset-in-foreach:

Unset In Foreach
################


Unset applied to the variables of a foreach loop are useless, as they are copies and not the actual value. Even if the value is a reference, unsetting it will not have effect on the original array : the only effect may be on values inside an array, or on properties inside an object.

.. code-block:: php

   <?php
   
   // When unset is useless
   $array = [1, 2, 3];
   foreach($array as $a) {
       unset($a);
   }
   
   print_r($array); // still [1, 2, 3]
   
   foreach($array as $b => &$a) {
       unset($a);
   }
   
   print_r($array); // still [1, 2, 3]
   
   // When unset is useful
   $array = [ [ 'c' => 1] ]; // Array in array
   foreach($array as &$a) {
       unset(&$a['c']);
   }
   
   print_r($array); // now [ ['c' => null] ]
   
   ?>

+--------------+----------------------------------------------+
| Command Line | Structures/UnsetInForeach                    |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Dead code <dead-code>`, :ref:`Analyze` |
+--------------+----------------------------------------------+


.. _unthrown-exception:

Unthrown Exception
##################


These are exceptions that are defined in the code but never thrown.

+--------------+-------------------------------------------------------------------------------------------------------------+
| Command Line | Exceptions/Unthrown                                                                                         |
+--------------+-------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-unthrown-exceptions <https://github.com/dseguy/clearPHP/tree/master/rules/no-unthrown-exceptions.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>`                                                                |
+--------------+-------------------------------------------------------------------------------------------------------------+


.. _unused-arguments:

Unused Arguments
################


Those arguments are not used in the method or function. 

Unused arguments should be removed in functions : they are just dead code.

Unused argument may have to stay in methods, as the signature is actually defined in the parent class. 

.. code-block:: php

   <?php
   
   // $unused is in the signature, but not used. 
   function foo($unused, $b, $c) {
       return $b + $c;
   }
   ?>

+--------------+---------------------------+
| Command Line | Functions/UnusedArguments |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _unused-classes:

Unused Classes
##############


The following classes are never explicitely used in the code.

Note that this may be valid in case the current code is a library or framework, since it defines classes that are used by other (unprovided) codes.
Also, this analyzer may find classes that are, in fact, dynamically loaded.

+--------------+----------------------------------------------+
| Command Line | Classes/UnusedClass                          |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>` |
+--------------+----------------------------------------------+


.. _unused-constants:

Unused Constants
################


Those constants are defined in the code but never used. Defining unused constants will slow down the application, has they are executed and stored in PHP hashtables. 

It is recommended to comment them out, and only define them when it is necessary.

+--------------+----------------------------------------------+
| Command Line | Constants/UnusedConstants                    |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>` |
+--------------+----------------------------------------------+


.. _unused-functions:

Unused Functions
################


The functions below are unused. They look like deadcode.

+--------------+----------------------------------------------+
| Command Line | Functions/UnusedFunctions                    |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>` |
+--------------+----------------------------------------------+


.. _unused-global:

Unused Global
#############


List of global keyword, used in various functions but not actually used in the code. for example : 

.. code-block:: php

   <?php
       function foo() {
           global bar;
           
           return 1;
       }
   ?>

+--------------+-------------------------+
| Command Line | Structures/UnusedGlobal |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _unused-interfaces:

Unused Interfaces
#################


Some interfaces are defined but not used. 

They should be removed, as they are probably dead code.

.. code-block:: php

   <?php
   
   interface used {}
   interface unused {}
   
   // Used by implementation
   class c implements used {}
   
   // Used by extension
   interface j implements used {}
   
   $x = new c;
   
   // Used in a 'instanceof
   var_dump($x 'instanceof used); 
   
   // Used in a typehint
   function foo(Used $x) {}
   
   ?>


See also `Used Interfaces`_.

+--------------+----------------------------------------------+
| Command Line | Interfaces/UnusedInterfaces                  |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>` |
+--------------+----------------------------------------------+


.. _unused-label:

Unused Label
############


Some labels have been defined in the code, but they are not used. They may be removed as they are dead code.

.. code-block:: php

   <?php
   
   $a = 0;
   A: 
   
       ++$a;
       
       // A loop. A: is used
       if ($a < 10) { goto A; }
   
   // B is never called explicitely. This is useless.
   B: 
   
   ?>


There is no analysis for undefined goto call, as PHP checks that goto has a destination label at compile time : 

See also `Goto <http://php.net/manual/en/control-structures.goto.php>`_.

+--------------+----------------------------------------------+
| Command Line | Structures/UnusedLabel                       |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Dead code <dead-code>`, :ref:`Analyze` |
+--------------+----------------------------------------------+


.. _unused-methods:

Unused Methods
##############


The following methods are never called as methods. They are probably dead code.

+--------------+----------------------------------------------+
| Command Line | Classes/UnusedMethods                        |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>` |
+--------------+----------------------------------------------+


.. _unused-private-properties:

Unused Private Properties
#########################


List of all static properties that are not used. They look like dead code.

.. code-block:: php

   <?php
   
   class foo {
       // This is a used property (see bar method)
       private $used = 1;
   
       // This is an unused property
       private $unused = 2;
       
       function bar($a) {
           $this->used += $a;
           
           return $this->used;
       }
   }
   
   ?>

+--------------+----------------------------------------------+
| Command Line | Classes/UnusedPrivateProperty                |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>` |
+--------------+----------------------------------------------+


.. _unused-protected-methods:

Unused Protected Methods
########################


The following methods are protected, and may be used in the current class or any of its children. 

.. code-block:: php

   <?php
   
   class foo {
       // This method is not used
       protected function unusedBar() {}
       protected function usedInFoo() {}
       protected function usedInFooFoo() {}
       
       public function bar2() {
           // some code
           $this->usedInFoo();
       }
   }
   
   class foofoo extends foo {
       protected function bar() {}
       
       public function bar2() {
           // some code
           $this->usedInFooFoo();
       }
   }
   
   class someOtherClass {
       protected function bar() {
           // This is not related to foo.
           $this->unusedbar();
       }
   }
   
   ?>


No usage of those methods were found. This analysis is impacted by dynamic method calls.

+--------------+--------------------------------+
| Command Line | Classes/UnusedProtectedMethods |
+--------------+--------------------------------+
| Analyzers    | :ref:`Dead code <dead-code>`   |
+--------------+--------------------------------+


.. _unused-returned-value:

Unused Returned Value
#####################


The function called returns a value, which is ignored. 

Usually, this is a sign of dead code, or a missed check on the results of the functioncall. At times, it may be a valid call if the function has voluntarily no return value. 

It is recommended to add a check on the return value, or remove the call. 

.. code-block:: php

   <?php
   
   // simplest form
   function foo() {
       return 1;
   }
   
   foo();
   
   // In case of multiple return, any one that returns something means that return value is meaningful
   function bar() {
       if (rand(0, 1)) {
           return 1;
       } else {
           return ;
       }
   }
   
   bar();
   
   ?>


Note that this analysis ignores functions that return void (same meaning that PHP 7.1 : return ; or no return in the function body).

+--------------+----------------------------------------------+
| Command Line | Functions/UnusedReturnedValue                |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>` |
+--------------+----------------------------------------------+


.. _unused-static-methods:

Unused Static Methods
#####################


List of all static methods that are not used. This looks like dead code.

+--------------+----------------------------------------------+
| Command Line | Classes/UnusedPrivateMethod                  |
+--------------+----------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>` |
+--------------+----------------------------------------------+


.. _unused-traits:

Unused Traits
#############


Those traits are not used in a class or another trait. They may be dead code.

.. code-block:: php

   <?php
   
   // unused trait
   trait unusedTrait { /'**/ }
   
   // used trait
   trait tUsedInTrait { /'**/ }
   
   trait tUsedInClass { 
       use tUsedInTrait;
       /'**/ 
       }
   
   class foo {
       use tUsedInClass;
   }
   ?>

+--------------+--------------------+
| Command Line | Traits/UnusedTrait |
+--------------+--------------------+
| Analyzers    | :ref:`Analyze`     |
+--------------+--------------------+


.. _unused-use:

Unused Use
##########


Unused use statements. They may be removed, as they clutter the code and slows PHP by forcing it to search in this list for nothing.

.. code-block:: php

   <?php
   
   use A as B; // Used in a new call.
   use Unused; // Never used. May be removed
   
   $a = new B();
   
   ?>

+--------------+---------------------------------------------------------------------------------------------+
| Command Line | Namespaces/UnusedUse                                                                        |
+--------------+---------------------------------------------------------------------------------------------+
| clearPHP     | `no-useless-use <https://github.com/dseguy/clearPHP/tree/master/rules/no-useless-use.md>`__ |
+--------------+---------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Dead code <dead-code>`                                                |
+--------------+---------------------------------------------------------------------------------------------+


.. _unusual-case-for-php-functions:

Unusual Case For PHP Functions
##############################


Usually, PHP functions are written all in lower case.

+--------------+------------------------------------------------+
| Command Line | Php/UpperCaseFunction                          |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _unverified-nonce:

Unverified Nonce
################


Those nonces are never checked.

Nonces were created in the code with  wp_nonce_field(), wp_nonce_url() and wp_nonce_create() functions, but they are not verified with wp_verify_nonce() nor check_ajax_referer()

.. code-block:: php

   <?php
   
   $nonce = wp_create_nonce( 'my-nonce' );
   
   if ( ! wp_verify_nonce( $nonce, 'my-other-nonce' ) ) { } else { }
   
   ?>

+--------------+---------------------------+
| Command Line | Wordpress/UnverifiedNonce |
+--------------+---------------------------+
| Analyzers    | :ref:`Wordpress`          |
+--------------+---------------------------+


.. _use-$wpdb-api:

Use $wpdb Api
#############


It is recommended to use the Wordpress Database API, instead of using query. 
This is especially true for UPDATE, REPLACE, INSERT and DELETE queries.

.. code-block:: php

   <?php
   
   // Generic query
   $wpdb->query('DELETE FROM ' . $table . ' WHERE id=' . $id . ' LIMIT 1');
   
   // Wordpress query
   $wpdb->delete( $table, array( 'id' => $id ), array('id' => '%d')); 
   
   ?>


See `Class Reference/wpdb <https://codex.wordpress.org/Class_Reference/wpdb>`_

+--------------+----------------------+
| Command Line | Wordpress/UseWpdbApi |
+--------------+----------------------+
| Analyzers    | :ref:`Wordpress`     |
+--------------+----------------------+


.. _use-===-null:

Use === null
############


It is faster to use === null instead of `'is_null() <http://www.php.net/is_null>`_.

.. code-block:: php

   <?php
   
   // Operator === is fast
   if ($a === null) {
   
   }
   
   // Function call is slow 
   if (is_null($a)) {
   
   }
   
   
   ?>

+--------------+---------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/IsnullVsEqualNull                                                                                               |
+--------------+---------------------------------------------------------------------------------------------------------------------+
| clearPHP     | `avoid-those-slow-functions <https://github.com/dseguy/clearPHP/tree/master/rules/avoid-those-slow-functions.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                                      |
+--------------+---------------------------------------------------------------------------------------------------------------------+


.. _use-class-operator:

Use Class Operator
##################


Use ::class to hardcode class names, instead of strings.

This is actually faster than strings, which are parsed at executio time, while ::class is compiled, making it faster to execute. 

It is also capable to handle aliases, making the code easier to maintain. 

.. code-block:: php

   <?php
   
   namespace foo\bar;
   
   use foo\bar\X as B;
   
   class X {}
   
   $className = '\foo\bar\X';
   
   $className = foo\bar\X::class;
   
   $className = B\X;
   
   $object = new $className;
   
   ?>


This is not possible when building the name of the class with concatenation.

This is a micro-optimization.

+--------------+-------------------------------------+
| Command Line | Classes/UseClassOperator            |
+--------------+-------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Performances` |
+--------------+-------------------------------------+


.. _use-const-and-functions:

Use Const And Functions
#######################


Since PHP 5.6 it is possible to import specific functions or constants from other namespaces.

+--------------+---------------------------------------------------------------------------------+
| Command Line | Namespaces/UseFunctionsConstants                                                |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55` |
+--------------+---------------------------------------------------------------------------------+


.. _use-constant-as-arguments:

Use Constant As Arguments
#########################


Some methods and functions are defined to be used with constants as arguments. Those constants are made to be meaningful and readable, keeping the code maintenable. It is recommended to use such constants as soon as they are documented.

+--------------+----------------------------------+
| Command Line | Functions/UseConstantAsArguments |
+--------------+----------------------------------+
| Analyzers    | :ref:`Analyze`                   |
+--------------+----------------------------------+


.. _use-instanceof:

Use Instanceof
##############


The `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ operator is a faster alternative to `'is_object() <http://www.php.net/is_object>`_. 

`'instanceof <http://php.net/manual/en/language.operators.type.php>`_ checks for an variable to be of a class or its parents or the interfaces it implements. 
Once `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ has been used, the actual attributes available (properties, constants, methods) are known, unlike with `'is_object() <http://www.php.net/is_object>`_.

Last, `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ may be upgraded to Typehint, by moving it to the method signature. 

.. code-block:: php

   <?php
   
   class Foo {
   
       // Don't use is_object
       public function bar($o) {
           if (!is_object($o)) { return false; } // Classic argument check
           return $o->method();
       }
   
       // use 'instanceof
       public function bar($o) {
           if ($o 'instanceof myClass) {  // Now, we know which methods are available
               return $o->method();
           }
           
           return false; } // Default behavior
       }
   
       // use of typehinting
       // in case $o is not of the right type, exception is raised automatically
       public function bar(myClass $o) {
           return $o->method();
       }
   }
   
   ?>


`'instanceof <http://php.net/manual/en/language.operators.type.php>`_ and `'is_object() <http://www.php.net/is_object>`_ may not be always interchangeable. Consider using `'isset <http://www.php.net/isset>`_ on a known property for a simple check on object. You may also consider `'is_string() <http://www.php.net/is_string>`_, `'is_integer() <http://www.php.net/is_integer>`_ or `'is_scalar() <http://www.php.net/is_scalar>`_, in particular instead of !`'is_object() <http://www.php.net/is_object>`_.

The `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ operator is also faster than the `'is_object() <http://www.php.net/is_object>`_ functioncall.

+--------------+--------------------------------+
| Command Line | Classes/UseInstanceof          |
+--------------+--------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Analyze` |
+--------------+--------------------------------+


.. _use-lower-case-for-parent,-static-and-self:

Use Lower Case For Parent, Static And Self
##########################################


Until PHP 5.5, the special Parent, Static and Self keywords needed to be lowercase to be useable. Otherwise, they would yield a 'PHP Fatal error:  Class 'PARENT' not found'.

parent, static and self are traditionally written in lowercase only. Mixed case and Upper case are both valid, though.

.. code-block:: php

   <?php
   
   class foo {
       const aConstante = 233;
       
       function method() {
           // Wrong case, error with PHP 5.4.* and older
           echo SELF::aConstante;
           
           // Always right. 
           echo self::aConstante;
       }
   }
   
   ?>


Until PHP 5.5, non-lowercase version of those keywords are generating a bug.

+--------------+------------------------------------------------------+
| Command Line | Php/CaseForPSS                                       |
+--------------+------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP53` |
+--------------+------------------------------------------------------+


.. _use-nullable-type:

Use Nullable Type
#################


The code uses nullable type, available since PHP 7.1.

.. code-block:: php

   <?php
   
   function foo(?string $a = abc) : ?string {
       return $a.b;
   }
   ?>

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/UseNullableType                                                             |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------+


.. _use-object-api:

Use Object Api
##############


When PHP offers the alternative between procedural and OOP api for the same features, it is recommended to use the OOP API. 

Often, this least to more compact code, as methods are shorter, and there is no need to bring the resource around. Lots of new extensions are directly written in OOP form too.

OOP / procedural alternatives are available for `mysqli <http://php.net/manual/en/book.mysqli.php>`_, `tidy <http://php.net/manual/en/book.tidy.php>`_, `cairo <http://php.net/manual/en/book.cairo.php>`_, 'finfo <http://php.net/manual/en/book.fileinfo.php>`_, and some others.

.. code-block:: php

   <?php
   /// OOP version
   $mysqli = new mysqli(localhost, my_user, my_password, world);
   
   /* check connection */
   if ($mysqli->connect_errno) {
       printf(Connect failed: %s\n, $mysqli->connect_error);
       'exit();
   }
   
   /* Create table doesn't return a resultset */
   if ($mysqli->query(CREATE TEMPORARY TABLE myCity LIKE City) === TRUE) {
       printf(Table myCity successfully created.\n);
   }
   
   /* Select queries return a resultset */
   if ($result = $mysqli->query(SELECT Name FROM City LIMIT 10)) {
       printf(Select returned %d rows.\n, $result->num_rows);
   
       /* free result set */
       $result->close();
   }
   ?>


.. code-block:: php

   <?php
   /// Procedural version
   $link = mysqli_connect(localhost, my_user, my_password, world);
   
   /* check connection */
   if (mysqli_connect_errno()) {
       printf(Connect failed: %s\n, mysqli_connect_error());
       'exit();
   }
   
   /* Create table doesn't return a resultset */
   if (mysqli_query($link, CREATE TEMPORARY TABLE myCity LIKE City) === TRUE) {
       printf(Table myCity successfully created.\n);
   }
   
   ?>

+--------------+---------------------------------------------------------------------------------------------+
| Command Line | Php/UseObjectApi                                                                            |
+--------------+---------------------------------------------------------------------------------------------+
| clearPHP     | `use-object-api <https://github.com/dseguy/clearPHP/tree/master/rules/use-object-api.md>`__ |
+--------------+---------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                              |
+--------------+---------------------------------------------------------------------------------------------+


.. _use-pathinfo:

Use Pathinfo
############


Use `'pathinfo() <http://www.php.net/pathinfo>`_ function instead of string manipulations.

`'pathinfo() <http://www.php.net/pathinfo>`_ is more efficient and readable and string functions.

.. code-block:: php

   <?php
   
   $filename = '/path/to/file.php';
   
   // With 'pathinfo();
   $details = pathinfo($filename);
   print $details['extension'];  // also capture php
   
   // With string functions (other solutions possible)
   $ext = substr($filename, - strpos(strreverse($filename), '.')); // Capture php
   
   ?>


When the path contains UTF-8 characters, `'pathinfo() <http://www.php.net/pathinfo>`_ may strip them. There, string functions are necessary.

+--------------+-----------------+
| Command Line | Php/UsePathinfo |
+--------------+-----------------+
| Analyzers    | :ref:`Analyze`  |
+--------------+-----------------+


.. _use-positive-condition:

Use Positive Condition
######################


Whenever possible, use a positive condition. 

Positive conditions are easier to understand, and lead to less understanding problems.
Negative conditions are not reported when else is not present. 

.. code-block:: php

   <?php
   
   // This is a positive condition
   if ($a == 'b') {
       doSomething();
   } else {
       doSomethingElse();
   }
   
   if (!empty($a)) {
       doSomething();
   } else {
       doSomethingElse();
   }
   
   // This is a negative condition
   if ($a == 'b') {
       doSomethingElse();
   } else {
       doSomething();
   }
   
   // No need to force $a == 'b' with empty else
   if ($a != 'b') {
       doSomethingElse();
   } 
   
   
   ?>

+--------------+---------------------------------+
| Command Line | Structures/UsePositiveCondition |
+--------------+---------------------------------+
| Analyzers    | :ref:`Analyze`                  |
+--------------+---------------------------------+


.. _use-slim:

Use Slim
########


This code uses the slim framework.

Some classes, traits or interfaces where detected in the code. 

.. code-block:: php

   <?php
   // Slim routing style
      $app = new \Slim\App();
      $app->get('/books/{id}', function ($request, $response, $args) {
          // Show book identified by $args['id']
      });
   ?>


See also `Slim <https://www.slimframework.com/>`_.

+--------------+--------------+
| Command Line | Slim/UseSlim |
+--------------+--------------+
| Analyzers    | :ref:`Slim`  |
+--------------+--------------+


.. _use-system-tmp:

Use System Tmp
##############


It is recommended to avoid hardcoding the tmp file. It is better to rely on the system's tmp folder, which is accessible with `'sys_get_temp_dir() <http://www.php.net/sys_get_temp_dir>`_.

.. code-block:: php

   <?php
   
   // Where the tmp is : 
   file_put_contents('sys_get_temp_dir().'/tempFile.txt', $content);
   
   
   // Avoid hard-coding tmp folder : 
   // On Linux-like systems
   file_put_contents('/tmp/tempFile.txt', $content);
   
   // On Windows systems
   file_put_contents('C:\WINDOWS\TEMP\tempFile.txt', $content);
   
   ?>

+--------------+-------------------------+
| Command Line | Structures/UseSystemTmp |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _use-with-fully-qualified-name:

Use With Fully Qualified Name
#############################


Use statement doesn't require a fully qualified name.

PHP manual recommends not to use fully qualified name (starting with \) when using the 'use' statement : they are "the leading backslash is unnecessary and not recommended, as import names must be fully qualified, and are not processed relative to the current namespace".

.. code-block:: php

   <?php
   
   // Recommended way to write a use statement.
   use  A\B\C\D as E;
   
   // No need to use the initial \
   use \A\B\C\D as F;
   
   ?>

+--------------+----------------------------------------------------------------+
| Command Line | Namespaces/UseWithFullyQualifiedNS                             |
+--------------+----------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Coding Conventions <coding-conventions>` |
+--------------+----------------------------------------------------------------+


.. _use-wordpress-functions:

Use Wordpress Functions
#######################


Always use Wordpress functions instead of native PHP ones.

Wordpress provides a lot of functions, that replace PHP natives one. It is recommended to used them.

Here is a table of conversion : 

.. Table is ugly, because PHP function will turn into a link. 

+----------------------------------------------+---------------------+
| PHP                                          |  Wordpress          | 
+----------------------------------------------+---------------------+
| `'mail() <http://www.php.net/mail>`_         |  wp_mail()          | 
| `'header() <http://www.php.net/header>`_     |  wp_redirect()      | 
| `'header() <http://www.php.net/header>`_     |  wp_safe_redirect() | 
| `'exit() <http://www.php.net/exit>`_         |  wp_die()           | 
| `'die() <http://www.php.net/die>`_           |  wp_die()           | 
| `'rand() <http://www.php.net/rand>`_         |  wp_rand()          | 
| `'mt_rand() <http://www.php.net/mt_rand>`_   |  wp_rand()          | 
+----------------------------------------------+---------------------+

.. code-block:: php

   <?php
   
   // use Wordpress Mail
   wp_mail('to@exakat.io', 'Mail subject', 'Mail message');
   
   // do not use PHP mail
   mail('to@exakat.io', 'Mail subject', 'Mail message');
   
   ?>


See `Wordpress Functions <https://codex.wordpress.org/Function_Reference>`_.

+--------------+--------------------------+
| Command Line | Wordpress/UseWpFunctions |
+--------------+--------------------------+
| Analyzers    | :ref:`Wordpress`         |
+--------------+--------------------------+


.. _use-const:

Use const
#########


The const keyword may be used to define constant, just like the `'define() <http://www.php.net/define>`_ function. 

When defining a constant, it is recommended to use 'const' when the features of the constant are not dynamical (name or value are known at compile time). 
This way, constant will be defined at compile time, and not at execution time. 

.. code-block:: php

   <?php
     //Do
     const A = 1;
     // Don't 
     define('A', 1);
     
   ?>


`'define() <http://www.php.net/define>`_ function is useful when the constant is not known at compile time, or when case sensitivity is necessary.

.. code-block:: php

   <?php
     // Read $a in database or config file
     define('A', $a);
   
     // Read $a in database or config file
     define('B', 1, true);
     echo b;
   ?>

+--------------+----------------------------------------------------------------+
| Command Line | Constants/ConstRecommended                                     |
+--------------+----------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Coding Conventions <coding-conventions>` |
+--------------+----------------------------------------------------------------+


.. _use-password\_hash():

Use password_hash()
###################


PHP 5.5 introduced `'password_hash() <http://www.php.net/password_hash>`_ and password_check() to replace the use of `'crypt() <http://www.php.net/crypt>`_ to check password.

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/Password55                                                                                                                                                   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _use-random\_int():

Use random_int()
################


`'rand() <http://www.php.net/rand>`_ and `'mt_rand() <http://www.php.net/mt_rand>`_ should be replaced with random_int().

At worse, `'rand() <http://www.php.net/rand>`_ should be replaced with `'mt_rand() <http://www.php.net/mt_rand>`_, which is a drop-in replacement and `'srand() <http://www.php.net/srand>`_ by `'mt_srand() <http://www.php.net/mt_srand>`_. 

random_int() replaces `'rand() <http://www.php.net/rand>`_, and has no seeding function like `'srand() <http://www.php.net/srand>`_.

.. code-block:: php

   <?php
   
   // Avoid using this
   $random = rand(0, 10);
   
   // Drop-in replacement
   $random = mt_rand(0, 10);
   
   // Even better but different : 
   // valid with PHP 7.0+
   try {
       $random = random_int(0, 10);
   } catch (\Exception $e) {
       // process case of not enoug random values
   }
   
   
   ?>


Since PHP 7, random_int() along with random_bytes(), provides cryptographically secure pseudo-random bytes, which are good to be used
when security is involved. openssl_random_pseudo_bytes() may be used when the OpenSSL extension is available.

+--------------+------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/BetterRand                                                                                                   |
+--------------+------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Security`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------------+


.. _used-once-property:

Used Once Property
##################


Property used once in their defining class. 

Properties used in one method only may be used several times, and read only. This may be a class constant. Such properties are meant to be overwritten by an extending class, and that's possible with class constants. 

Setting properties with default values is a good way to avoid literring the code with literal values, and provide a single point of update (by extension, or by hardcoding) for all those situations. A constant is definitely better suited for this task.

.. code-block:: php

   <?php
   
   class foo {
       private $defaultCols = '*';
       cont DEFAULT_COLUMNS = '*';
   
       // $this->defaultCols holds a default value. Should be a constant.
       function bar($table, $cols) {
           // This is necessary to activate usage of default values
           if (empty($cols)) {
               $cols = $this->defaultCols;
           }
           $res = $this->query('SELECT '.$cols.' FROM '.$table);
           // ....
       }
   
       // Upgraded version of bar, with default values
       function bar2($table, $cols = self::DEFAULT_COLUMNS) {
           $res = $this->query('SELECT '.$cols.' FROM '.$table);
           // .....
       }
   }
   
   ?>

+--------------+--------------------------+
| Command Line | Classes/UsedOnceProperty |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _used-once-variables:

Used Once Variables
###################


This is the list of used once variables. 

.. code-block:: php

   <?php
   
   // The variables below never appear again in the code
   $writtenOnce = 1;
   
   foo($readOnce);
   
   ?>


Such variables are useless. Variables must be used at least twice : once for writing, once for reading, at least. It is recommended to remove them.

In special situations, variables may be used once : 

+ PHP predefined variables, as they are already initialized. They are omitted in this analyze.
+ Interface function's arguments, since the function has no body; They are omitted in this analyze.
+ Dynamically created variables ($$x, ${$this->y} or also using extract), as they are runtime values and can't be determined at static code time. They are reported for manual review.
+ Dynamically included files will provide in-scope extra variables.

The current analyzer count variables at the application level, and not at a method scope level.

+--------------+----------------------------+
| Command Line | Variables/VariableUsedOnce |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _used-once-variables-(in-scope):

Used Once Variables (In Scope)
##############################


This is the list of used once variables, scope by scope. Those variables are used once in a function, a method, a class or a namespace. In any case, this means the variable is read or written, while it should be used at least twice. 

.. code-block:: php

   <?php
   
   function foo() {
       // The variables below never appear twice, inside foo()
       $writtenOnce = 1;
   
       foo($readOnce);
       // They do appear again in other functions, or in global space. 
   }
   
   function bar() {
       $writtenOnce = 1;
       foo($readOnce);
   }
   
   ?>

+--------------+-------------------------------------+
| Command Line | Variables/VariableUsedOnceByContext |
+--------------+-------------------------------------+
| Analyzers    | :ref:`Analyze`                      |
+--------------+-------------------------------------+


.. _used-protected-method:

Used Protected Method
#####################


Marks methods being used in the current class or its children classes.

+--------------+------------------------------+
| Command Line | Classes/UsedProtectedMethod  |
+--------------+------------------------------+
| Analyzers    | :ref:`Dead code <dead-code>` |
+--------------+------------------------------+


.. _used-routes:

Used Routes
###########


List of all routes used in the application. 

.. code-block:: php

   <?php
   
   // '/admin/' is a route. 
   $app->get('/admin/', function ($x) { /* do something(); */ });
   
   // '/contact/'.$email is a dynamic route. 
   $app->post('/contact/'.$email.'/{id}, function ($x) { /* do something(); */ });
   
   ?>


See also `Routing <https://www.slimframework.com/docs/objects/router.html>`_.

+--------------+-----------------+
| Command Line | Slim/UsedRoutes |
+--------------+-----------------+
| Analyzers    | :ref:`Slim`     |
+--------------+-----------------+


.. _useless-abstract-class:

Useless Abstract Class
######################


Those classes are marked 'abstract' and they are never extended. This way, they won't be instantiated nor used. 

Abstract classes that have only static methods are omitted here : one usage of such classes are Utilities classes, which only offer static methods. 

.. code-block:: php

   <?php
   
   // Never extended class : this is useless
   abstract class foo {}
   
   // Extended class
   abstract class bar {
       public function barbar() {}
   }
   
   class bar2 extends bar {}
   
   // Utility class : omitted here
   abstract class bar {
       public static function barbar() {}
   }
   
   ?>

+--------------+-------------------------+
| Command Line | Classes/UselessAbstract |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _useless-brackets:

Useless Brackets
################


Those brackets have no use here. 

They may be a left over of an old instruction, or a misunderstanding of the alternative syntax.

.. code-block:: php

   <?php
   
   // The following brackets are useless : they are a leftover from an older instruction
   // if (DEBUG) 
   {
       $a = 1;
   }
   
   // Here, the extra brackets are useless
   for($a = 2; $a < 5; $a++) : {
       $b++;
   } endfor;
   
   ?>

+--------------+----------------------------+
| Command Line | Structures/UselessBrackets |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _useless-casting:

Useless Casting
###############


There is no need to overcast returned values.

.. code-block:: php

   <?php
   
   // trim always returns a string : cast is useless
   $a = (string) trim($b);
   
   // strpos doesn't always returns an integer : cast is useful
   $a = (boolean) strpos($b, $c);
   
   // comparison don't need casting, nor parenthesis
   $c = (bool) ($b > 2);
   
   ?>

+--------------+---------------------------+
| Command Line | Structures/UselessCasting |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _useless-check:

Useless Check
#############


Situation where the condition is useless. 

.. code-block:: php

   <?php
   
   // Checking for type is good. 
   if (is_array($array)) {
       foreach($array as $a) {
           doSomething($a);
       }
   }
   
   // Foreach on empty arrays doesn't start. Checking is useless
   if (!empty($array)) {
       foreach($array as $a) {
           doSomething($a);
       }
   }
   
   ?>

+--------------+-------------------------+
| Command Line | Structures/UselessCheck |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _useless-constructor:

Useless Constructor
###################


Class constructor that have empty bodies are useless. They may be removed.

+--------------+----------------------------+
| Command Line | Classes/UselessConstructor |
+--------------+----------------------------+
| Analyzers    | :ref:`Analyze`             |
+--------------+----------------------------+


.. _useless-final:

Useless Final
#############


When a class is declared final, all of its methods are also final by default. 

There is no need to declare them individually final.

.. code-block:: php

   <?php
   
       final class foo {
           // Useless final, as the whole class is final
           final function method() { }
       }
   
       class bar {
           // Useful final, as the whole class is not final
           final function method() { }
       }
   
   ?>


See also `Final keyword <http://php.net/manual/en/language.oop5.final.php>`_, and `When to declare final <https://ocramius.github.io/blog/when-to-declare-classes-final/>`_.

+--------------+-------------------------------------------------------------------------------------------------+
| Command Line | Classes/UselessFinal                                                                            |
+--------------+-------------------------------------------------------------------------------------------------+
| clearPHP     | `no-useless-final <https://github.com/dseguy/clearPHP/tree/master/rules/no-useless-final.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                  |
+--------------+-------------------------------------------------------------------------------------------------+


.. _useless-global:

Useless Global
##############


Global are useless in two cases. First, on super-globals, which are always globals, like $_GET. Secondly, on variables that are not used.

.. code-block:: php

   <?php
   
   // $_POST is already a global : it is in fact a global everywhere
   global $_POST;
   
   // $unused is useless
   function foo() {
       global $used, $unused;
       
       ++$used;
   }
   
   ?>


Also, PHP has superglobals, a special team of variables that are always available, whatever the context. 
They are : $GLOBALS, $_SERVER, $_GET, $_POST, $_FILES, $_COOKIE, $_SESSION, $_REQUEST and $_ENV.

+--------------+--------------------------+
| Command Line | Structures/UselessGlobal |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _useless-instructions:

Useless Instructions
####################


Those instructions are useless, or contains useless parts. 

For example, running '&lt;?php 1 + 1; ?&gt;' does nothing : the addition is actually performed, but not used : not displayed, not stored, not set. Just plain lost. 

Here the useless instructions that are spotted : 

.. code-block:: php

   <?php
   
   // Concatenating with an empty string is useless.
   $string = 'This part '.$is.' usefull but '.$not.'';
   
   // This is a typo, that PHP turns into a constant, then a string, then nothing.
   conitnue;
   
   // Empty string in a concatenation
   $a = 'abc' . '';
   
   // Returning expression, whose result is not used (additions, comparisons, properties, closures, new without =, ...)
   1 + 2;
   
   // Returning post-incrementation
   function foo($a) {
       return $a++;
   }
   
   // 'array_replace() with only one argument
   $replaced = array_replace($array);
   // 'array_replace() is OK with ... 
   $replaced = array_replace(...$array);
   
   // @ operator on source array, in foreach, or when assigning literals
   $array = @array(1,2,3);
   
   // Multiple comparisons in a for loop : only the last is actually used.
   for($i = 0; $j = 0; $j < 10, $i < 20; ++$j, ++$i) {
       print $i.' '.$j.PHP_EOL;
   }
   
   ?>

+--------------+-------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/UselessInstruction                                                                               |
+--------------+-------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-useless-instruction <https://github.com/dseguy/clearPHP/tree/master/rules/no-useless-instruction.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                              |
+--------------+-------------------------------------------------------------------------------------------------------------+


.. _useless-interfaces:

Useless Interfaces
##################


The interfaces below are defined and are implemented by some classes. 
However, they are never used to enforce objects's class in the code, using `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ or a typehint. 
As they are currently used, those interfaces may be removed without change in behavior.

.. code-block:: php

   <?php
       // only defined interface but never enforced
       interface i {};
       class c implements i {} 
   ?>


Interfaces should be used in Typehint or with the `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ operator. 

.. code-block:: php

   <?php
       interface i {};
       
       function foo(i $arg) { 
           // Now, $arg is always an 'i'
       }
       
       function bar($arg) { 
           if (!($arg 'instanceof i)) {
               // Now, $arg is always an 'i'
           }
       }
   ?>

+--------------+-----------------------------------------------------------------------------------------------------------+
| Command Line | Interfaces/UselessInterfaces                                                                              |
+--------------+-----------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-useless-interfaces <https://github.com/dseguy/clearPHP/tree/master/rules/no-useless-interfaces.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                            |
+--------------+-----------------------------------------------------------------------------------------------------------+


.. _useless-parenthesis:

Useless Parenthesis
###################


Situations where parenthesis are not necessary, and may be removed.

.. code-block:: php

   <?php
   
       if ( ($condition) ) {}
       while( ($condition) ) {}
       do $a++; while ( ($condition) );
       
       switch ( ($a) ) {}
       $y = (1);
       ($y) == (1);
       
       f(($x));
   
       // = has precedence over == 
       ($a = $b) == $c;
       
       ($a++);
       
       // No need for parenthesis in default values
       function foo($c = ( 1 + 2) ) {}
   ?>

+--------------+-------------------------------+
| Command Line | Structures/UselessParenthesis |
+--------------+-------------------------------+
| Analyzers    | :ref:`Analyze`                |
+--------------+-------------------------------+


.. _useless-return:

Useless Return
##############


The spotted functions or methods have a return statement, but this statement is useless. This is the case for constructor and destructors, whose return value are ignored or inaccessible.

When return is void, and the last element in a function, it is also useless.

.. code-block:: php

   <?php
   
   class foo {
       function '__construct() {
           // return is not used by PHP
           return 2;
       }
   }
   
   function bar(&$a) {
       $a++;
       // The last return, when empty, is useless
       return;
   }
   
   ?>

+--------------+-------------------------+
| Command Line | Functions/UselessReturn |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _useless-switch:

Useless Switch
##############


This switch has only one case. It may very well be replaced by a ifthen structure.

.. code-block:: php

   <?php
   switch($a) {
       case 1:
           doSomething();
           'break;
   }
   
   // Same as 
   
   if ($a == 1) {
       doSomething();
   }
   ?>

+--------------+--------------------------+
| Command Line | Structures/UselessSwitch |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _useless-unset:

Useless Unset
#############


Unsetting variables may not be applicable with a certain type of variables. This is the list of such cases.

.. code-block:: php

   <?php
   
   function foo($a) {
       // unsetting arguments is useless
       unset($a);
       
       global $b;
       // unsetting global variable has no effect 
       unset($b);
   
       static $c;
       // unsetting static variable has no effect 
       unset($c);
       
       foreach($d as $e){
           // unsetting a blind variable is useless
           (unset) $e;
       }
   }
   
   ?>

+--------------+-------------------------------------------------------------------------------------------------+
| Command Line | Structures/UselessUnset                                                                         |
+--------------+-------------------------------------------------------------------------------------------------+
| clearPHP     | `no-useless-unset <https://github.com/dseguy/clearPHP/tree/master/rules/no-useless-unset.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                  |
+--------------+-------------------------------------------------------------------------------------------------+


.. _uses-default-values:

Uses Default Values
###################


Default values are provided to methods so as to make it convenient to use. However, with new versions, those values may change. For example, in PHP 5.4, `'htmlentities() <http://www.php.net/htmlentities>`_ switched from Latin1 to UTF-8 default encoding.

.. code-block:: php

   <?php
   
   $string = Eu não sou o pão;
   
   echo htmlentities($string);
   
   // PHP 5.3 : Eu n&Atilde;&pound;o sou o p&Atilde;&pound;o
   // PHP 5.4 : Eu n&atilde;o sou o p&atilde;o
   
   // Stable across versions
   echo htmlentities($string, 'UTF8');
   
   ?>


As much as possible, it is recommended to use explicit values in those methods, so as to prevent from being surprise at a future PHP evolution. 

This analyzer tend to report a lot of false positives, including usage of `'count() <http://www.php.net/count>`_. Count() indeed has a second argument for recursive counts, and a default value. This may be ignored safely.

+--------------+--------------------------------+
| Command Line | Functions/UsesDefaultArguments |
+--------------+--------------------------------+
| Analyzers    | :ref:`Analyze`                 |
+--------------+--------------------------------+


.. _using-$this-outside-a-class:

Using $this Outside A Class
###########################


`$this` is a special variable, that should only be used in a class context. 

Until PHP 7.1, `$this` may be used as an argument in a function (or a method), a global, a static : while this is legit, it sounds confusing enough to avoid it.

.. code-block:: php

   <?php
   
   function foo($this) {
       echo $this;
   }
   ?>


Starting with PHP 7.1, the PHP engine check thouroughly that $this is used in an appropriate manner, and raise fatal errors in case it isn't.

+--------------+-------------------------------------------------------------------------------------------------+
| Command Line | Classes/UsingThisOutsideAClass                                                                  |
+--------------+-------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+-------------------------------------------------------------------------------------------------+


.. _usort-sorting-in-php-7.0:

Usort Sorting In PHP 7.0
########################


Usort(), `'uksort() <http://www.php.net/uksort>`_ and `'uasort() <http://www.php.net/uasort>`_ behavior has changed in PHP 7. Values that are equals (based on the user-provided method) may be sorted differently than in PHP 5. 

If this sorting is important, it is advised to add extra comparison in the user-function and avoid returning 0 (thus, depending on default implementation). 

.. code-block:: php

   <?php
   
   $a = [ 2, 4, 3, 6];
   
   function noSort($a) { return $a > 5; }
   
   usort($a, 'noSort');
   print_r($a);
   
   ?>


In PHP 5, the results is :::

   
   Array
   (
       [0] => 3
       [1] => 4
       [2] => 2
       [3] => 6
   )
   


in PHP 7, the result is :::

   
   Array
   (
       [0] => 2
       [1] => 4
       [2] => 3
       [3] => 6
   )

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Php/UsortSorting                                                                                                                                                 |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _var:

Var
###


Var was used in PHP 4 to mark properties as public. Nowadays, new keywords are available : public, protected, private. Var is equivalent to public. 

It is recommended to avoid using var, and explicitely use the new keywords.

.. code-block:: php

   <?php
   
   class foo {
       public $bar = 1;
       // Avoid var
       //var $bar = 1; 
   }
   
   ?>

+--------------+---------------------------------------------------------------------------------------------------------+
| Command Line | Classes/OldStyleVar                                                                                     |
+--------------+---------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-php4-class-syntax <https://github.com/dseguy/clearPHP/tree/master/rules/no-php4-class-syntax.md>`__ |
+--------------+---------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                          |
+--------------+---------------------------------------------------------------------------------------------------------+


.. _variable-global:

Variable Global
###############


Variable global such are valid in PHP 5.6, but no in PHP 7.0. They should be replaced with ${$foo->bar}.

.. code-block:: php

   <?php
   
   // Forbidden in PHP 7
   global $normalGlobal;
   
   // Forbidden in PHP 7
   global $$variable->global ;
   
   // Tolerated in PHP 7
   global ${$variable->global};
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/VariableGlobal                                                                                  |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _while(list()-=-each()):

While(List() = Each())
######################


This code structure is quite old : it should be replace by the more modern and efficient foreach.

.. code-block:: php

   <?php
       foreach($array as $key => $value) {
           doSomethingWith($key) and $value;
       }
   ?>

+--------------+-------------------------------------+
| Command Line | Structures/WhileListEach            |
+--------------+-------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Performances` |
+--------------+-------------------------------------+


.. _wpdb-best-usage:

Wpdb Best Usage
###############


Use the adapted API with $wpdb.

Wordpress database API ($wpdb) offers several eponymous methods to safely handle insert, delete, replace and update. 

It is recommended to use them, instead of writing queries with concatenations.

.. code-block:: php

   <?php
   // Example from Wordpress Manual
   $user_count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->users" );
   echo <p>User count is {$user_count}</p>;
   ?>


See `Class Reference/wpdb <https://codex.wordpress.org/Class_Reference/wpdb>`_

+--------------+-------------------------+
| Command Line | Wordpress/WpdbBestUsage |
+--------------+-------------------------+
| Analyzers    | :ref:`Wordpress`        |
+--------------+-------------------------+


.. _wpdb-prepare-or-not:

Wpdb Prepare Or Not
###################


Always use $wpdb->prepare() when variables are used in the SQL query.

When using $wpdb, it is recommended to use directly the query() method when the SQL is not using variables.

.. code-block:: php

   <?php
   
   // No need to prepare this query : it is all known at coding time.
   $wpdb->prepare('INSERT INTO table VALUES (1,2,3)');
   
   // No need to prepare this query : $wpdb->prefix is safe
   $wpdb->prepare('INSERT INTO {$wpdb->prefix}table values (1,2,3)');
   
   // Don't use query when variable are involved : always use prepare
   $wpdb->query('INSERT INTO TABLE values (1,2,'.$var.')');
   
   ?>

+--------------+----------------------------+
| Command Line | Wordpress/WpdbPrepareOrNot |
+--------------+----------------------------+
| Analyzers    | :ref:`Wordpress`           |
+--------------+----------------------------+


.. _written-only-variables:

Written Only Variables
######################


Those variables are being written, but never read. This way, they are useless and should be removed, or read at some point.

+--------------+-----------------------------------------------------------------------------------------------------+
| Command Line | Variables/WrittenOnlyVariable                                                                       |
+--------------+-----------------------------------------------------------------------------------------------------+
| clearPHP     | `no-unused-variable <https://github.com/dseguy/clearPHP/tree/master/rules/no-unused-variable.md>`__ |
+--------------+-----------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                      |
+--------------+-----------------------------------------------------------------------------------------------------+


.. _wrong-class-location:

Wrong Class Location
####################


Classes may not be used or extended in any places inside the Zend Framework file hierarchy. 
For example, Zend_Controller_Action must be inside a /controllers/ folder for the routing system to find it. 

Here are the validation that are currently performed : 
* Zend_Auth shouldn't be in templates files (.phtml)
* Zend_Controller_Action must be in /controllers/ folder
* Zend_View_Helper_Abstract must be in /helpers/ folder

+--------------+----------------------+
| Command Line | ZendF/NotInThatPath  |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _wrong-number-of-arguments:

Wrong Number Of Arguments
#########################


Those functioncalls are made with too many or too few arguments. 

When the number arguments is wrong for native functions, PHP emits a warning. 
When the number arguments is too small for custom functions, PHP raises an exception. 
When the number arguments is too hight for custom functions, PHP ignores the arguments. Such arguments should be handled with the variadic operator, or with `'func_get_args() <http://www.php.net/func_get_args>`_ family of functions.

.. code-block:: php

   <?php
   
   echo strtoupper('This function is', 'ignoring arguments');
   //Warning: 'strtoupper() expects exactly 1 parameter, 2 given in Command line code on line 1
   
   echo 'strtoupper();
   //Warning: 'strtoupper() expects exactly 1 parameter, 0 given in Command line code on line 1
   
   function foo($argument) {}
   echo foo();
   //Fatal error: Uncaught ArgumentCountError: Too few arguments to function foo(), 0 passed in /Users/famille/Desktop/analyzeG3/test.php on line 10 and exactly 1 expected in /Users/famille/Desktop/analyzeG3/test.php:3
   
   echo foo('This function is', 'ignoring arguments');
   
   ?>


It is recommended to check the signature of the methods, and fix the arguments.

+--------------+-------------------------------------------------------------------------------------------------------------+
| Command Line | Functions/WrongNumberOfArguments                                                                            |
+--------------+-------------------------------------------------------------------------------------------------------------+
| clearPHP     | `no-missing-argument.md <https://github.com/dseguy/clearPHP/tree/master/rules/no-missing-argument.md.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`                                                                                              |
+--------------+-------------------------------------------------------------------------------------------------------------+


.. _wrong-optional-parameter:

Wrong Optional Parameter
########################


Wrong placement of optional parameters.

PHP parameters are optional when they defined with a default value, like this : 

.. code-block:: php

   <?php
       function x($arg = 1) {
           // PHP code here
       }
   ?>


When a function have both compulsory and optional parameters, the compulsory ones should appear first, and the optional should appear last : 

.. code-block:: php

   <?php
       function x($arg, $arg2 = 2) {
           // PHP code here
       }
   ?>


PHP will solve this problem at runtime, assign values in the same other, but will miss some of the default values and emits warnings. 

It is better to put all the optional parameters at the end of the method's signature.

+--------------+----------------------------------+
| Command Line | Functions/WrongOptionalParameter |
+--------------+----------------------------------+
| Analyzers    | :ref:`Analyze`                   |
+--------------+----------------------------------+


.. _wrong-parameter-type:

Wrong Parameter Type
####################


The expected parameter is not of the correct type. Check PHP documentation to know which is the right format to be used.

.. code-block:: php

   <?php
   
   // substr() shouldn't work on integers.
   // the first argument is first converted to string, and it is 123456.
   echo substr(123456, 0, 4); // display 1234
   
   // substr() shouldn't work on boolean
   // the first argument is first converted to string, and it is 1, and not t
   echo substr(true, 0, 1); // displays 1
   
   // substr() works correctly on strings.
   echo substr(123456, 0, 4);
   
   ?>

+--------------+---------------------------+
| Command Line | Php/InternalParameterType |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _wrong-fopen()-mode:

Wrong fopen() Mode
##################


Wrong file opening for `'fopen() <http://www.php.net/fopen>`_.

`'fopen() <http://www.php.net/fopen>`_ has a few modes, as described in the documentation : 'r', 'r+', for reading;  'w', 'w+' for writing; 'a', 'a+' for appending; 'x', 'x+' for modifying; 'c', 'c+' for writing and locking, 't' for text files and windows only.
An optional 'b' may be used to make the `'fopen() <http://www.php.net/fopen>`_ call more portable and binary safe. 

.. code-block:: php

   <?php
   
   // open the file for reading, in binary mode
   $fp = fopen('/tmp/php.txt', 'rb');
   
   // New option e in PHP 7.0.16 and 7.1.2 (beware of compatibility)
   $fp = fopen('/tmp/php.txt', 'rbe');
   
   // Unknown option x
   $fp = fopen('/tmp/php.txt', 'rbx');
   
   ?>


Any other values are not understood by PHP.

+--------------+----------------+
| Command Line | Php/FopenMode  |
+--------------+----------------+
| Analyzers    | :ref:`Analyze` |
+--------------+----------------+


.. _yoda-comparison:

Yoda Comparison
###############


Yoda comparison is a way to write conditions which places literal values on the left side. 

.. code-block:: php

   <?php
     if (1 == $a) {
       // Then condition
     } 
   ?>


The objective is to avoid mistaking a comparison to an assignation. If the comparison operateur is mistaken, but the literal is on the left, then an error will be triggered, instead of a silent bug. 

.. code-block:: php

   <?php
       // error in comparison! 
       if ($a = 1) {
           // Then condition
       } 
   ?>

+--------------+------------------------------------------------+
| Command Line | Structures/YodaComparison                      |
+--------------+------------------------------------------------+
| Analyzers    | :ref:`Coding Conventions <coding-conventions>` |
+--------------+------------------------------------------------+


.. _zf3-usage-of-deprecated:

ZF3 Usage Of Deprecated
#######################


Structures are marked with @deprecated in Zend Framework 3, before being removed. That gives an initial warning that the code will `'break <http://php.net/manual/en/control-structures.break.php>`_ if it continues using this structure.

Any kind of structure may be @deprecated : classes, traits, interfaces, methods, constants, properties and parameters. 

.. code-block:: php

   <?php
   
   // Deprecated class 
   $a = new Zend\Authentication\Adapter\DbTable();
   
   // deprecated method : 
   $b->setLibOption();
   
   // deprecated constant in 2.5
   Zend\Db\Sql::JOIN_OUTER_LEFT;
   Zend\Db\Sql::JOIN_LEFT;
   
   // deprecated trait
   class foo {
       // Deprecated during most 2.0 series. 
       // use Zend\EventManager\EventManagerAwareTrait instead
       use Zend\EventManager\ProvidesEvents;
   }
   
   // deprecated interface
   class foo2 implements Zend\EventManager\SharedEventAggregateAwareInterface {}
   
   // deprecated property
   $a->allowEmpty = 2;
   
   
   ?>


Currently, parameters are omitted in the analysis.

+--------------+--------------------------+
| Command Line | ZendF/Zf3DeprecatedUsage |
+--------------+--------------------------+
| Analyzers    | :ref:`ZendFramework`     |
+--------------+--------------------------+


.. _zend-classes:

Zend Classes
############


Spot Zend Classes in the code.

Classes are detected by checking the full namespaced name with the prefix \'zend_\' (Zend Framework 1) or \'\zend\' (Zend Framework 2).

.. code-block:: php

   <?php
   
   namespace {
       // Zend View class (This is for the example, not actual code)
       class Zend_View {}
   }
   
   namespace Zend\Feed { 
       // Zend Feed Uri class (This is for the example, not actual code)
       class Uri {  }
   }
   
   ?>

+--------------+----------------------+
| Command Line | ZendF/ZendClasses    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-interface:

Zend Interface
##############


Identify Zend Framework interface, based on fully qualified name.

.. code-block:: php

   <?php
                      // This is a zend interface
   class X implements Zend\Authentication\Adapter\Http\Exception\ExceptionInterface, 
                      // This is Not a zend interface
                      Not\Zend\Authentication\Adapter\Http\Exception\ExceptionInterface {
   }
   
                          // This is a zend interface
   interface Y implements Zend\Authentication\Adapter\Http\ResolverInterface, 
                          // This is Not a zend interface
                          Not\Zend\Authentication\Adapter\Http\ResolverInterface {
   
   }
   
   ?>

+--------------+----------------------+
| Command Line | ZendF/ZendInterfaces |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-trait:

Zend Trait
##########


Identify Zend Framework traits, based on fully qualified name.

.. code-block:: php

   <?php
   
   class X {
       // This is a zend trait
       use Zend\Db\Adapter\AdapterAwareTrait;
   
       // This is NOT a zend trait
       use Not\Zend\Db\Adapter\AdapterAwareTrait;
   }
   
   ?>

+--------------+----------------------+
| Command Line | ZendF/ZendTrait      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zendf/dontusegpc:

ZendF/DontUseGPC
################


Avoid using PHP superglobal when using Zend Framework. Zend Framework provides other ways to reach the incoming values : they should be used.

.. code-block:: php

   <?php
   
   // Normal PHP code
   $parameter = $_GET['parameter'];
   
   // The Zend Framework way.
   // 
   <?php
   namespace <module name>\Controller;
   
   use Zend\Mvc\Controller\AbstractActionController;
   use Zend\View\Model\ViewModel;
   
   class HelloController extends AbstractActionController
   {
       public function worldAction()
       {
           $message = $this->params()->fromQuery('message', 'foo');
           return new ViewModel(['message' => $message]);
       }
   }
   ?>


See also `Quick Start <https://github.com/zendframework/zend-mvc/blob/master/doc/book/quick-start.md>`_ of the Zend-mvc component.

+--------------+----------------------+
| Command Line | ZendF/DontUseGPC     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zendf/zendtypehinting:

ZendF/ZendTypehinting
#####################


Zend classes or interfaces used in `'instanceof <http://php.net/manual/en/language.operators.type.php>`_ or typehint situations.

.. code-block:: php

   <?php
   
   // In a typehint 
   function a(Zend\View $class) {
       //...
   }
   
   // In a 'instanceof 
   if ($a 'instanceof Zend_Acl_Exception) {
   
   }
   
   ?>

+--------------+-----------------------+
| Command Line | ZendF/ZendTypehinting |
+--------------+-----------------------+
| Analyzers    | :ref:`ZendFramework`  |
+--------------+-----------------------+


.. _zend\config:

Zend\Config
###########


The Zend Framework 3 component Zend-Config is used.

.. code-block:: php

   <?php
   // Example from the Zend Framework 3 dos
   
   // Create the config object
   $config = new Zend\Config\Config([], true);
   $config->production = [];
   
   $config->production->webhost = 'www.example.com';
   $config->production->database = [];
   $config->production->database->params = [];
   $config->production->database->params->host = 'localhost';
   $config->production->database->params->username = 'production';
   $config->production->database->params->password = 'secret';
   $config->production->database->params->dbname = 'dbproduction';
   
   $writer = new Zend\Config\Writer\Ini();
   echo $writer->toString($config);
   
   ?>


See also `Zend-config <https://docs.zendframework.com/zend-config/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Config      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _\_\_dir\_\_-then-slash:

__DIR__ Then Slash
##################


`'__DIR__ <http://php.net/manual/en/language.constants.predefined.php>`_ must be concatenated with a string starting with /.

The magic constant `'__DIR__ <http://php.net/manual/en/language.constants.predefined.php>`_ holds the name of the current directory, without final /. When it is used to build path, then the following path fragment must start with /. Otherwise, two directories names will be merged together. 

.. code-block:: php

   <?php
   
   // '__DIR__ = /a/b/c
   // $filePath = /a/b/c/g.php
   
   // /a/b/c/d/e/f.txt : correct path
   echo '__DIR__.'/d/e/f.txt';
   echo dirname($filePath).'/d/e/f.txt';
   
   // /a/b/cd/e/f.txt : most probably incorrect path
   echo '__DIR__.'d/e/f.txt';
   echo dirname($filePath).'d/e/f.txt';
   
   ?>

+--------------+-------------------------+
| Command Line | Structures/DirThenSlash |
+--------------+-------------------------+
| Analyzers    | :ref:`Analyze`          |
+--------------+-------------------------+


.. _\_\_debuginfo()-usage:

__debugInfo() usage
###################


The magic function `'__debugInfo() <http://php.net/manual/en/language.oop5.magic.php>`_ has been introduced in PHP 5.6. In the previous versions of PHP, this method is ignored and won't be called when debugging.

.. code-block:: php

   <?php
   
   // PHP 5.6 or later
   class foo {
       private $bar = 1;
       private $reallyHidden = 2;
       
       function '__debugInfo() {
           return ['bar' => $this->bar,
                   'reallyHidden' => 'Secret'];
       }
   }
   
   $f = new Foo();
   var_dump($f);
   
   ?>


This ends up with :::

    
   object(foo)#1 (2) {
     [bar]=>
     int(1)
     [reallyHidden]=>
     string(6) Secret
   }

+--------------+---------------------------------------------------------------------------------+
| Command Line | Php/debugInfoUsage                                                              |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP53`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55` |
+--------------+---------------------------------------------------------------------------------+


.. _\_\_tostring()-throws-exception:

__toString() Throws Exception
#############################


Magical method `'__toString() <http://php.net/manual/en/language.oop5.magic.php>`_ can't throw exceptions.

In fact, `'__toString() <http://php.net/manual/en/language.oop5.magic.php>`_ may not let an exception pass. If it throw an exception, but must catch it. If an underlying method throws an exception, it must be caught.

.. code-block:: php

   <?php
   
   class myString {
       private $string = null;
       
       public function '__construct($string) {
           $this->string = $string;
       }
       
       public function '__toString() {
           // Do not throw exceptions in '__toString
           if (!is_string($this->string)) {
               throw new Exception('$this->string is not a string!!');
           }
           
           return $this->string;
       }
   }   
   
   ?>


A fatal error is displayed, when an exception is not intercepted in the `'__toString() <http://php.net/manual/en/language.oop5.magic.php>`_ function. 

PHP Fatal error:  Method myString::`'__toString() <http://php.net/manual/en/language.oop5.magic.php>`_ must not throw an exception, caught Exception: 'Exception message' in file.php

See also `__toString() <http://php.net/manual/en/language.oop5.magic.php#object.tostring>`_.

+--------------+------------------------------------+
| Command Line | Structures/toStringThrowsException |
+--------------+------------------------------------+
| Analyzers    | :ref:`Analyze`                     |
+--------------+------------------------------------+


.. _crypt()-without-salt:

crypt() Without Salt
####################


PHP 5.6 and later require a salt when calling `'crypt() <http://www.php.net/crypt>`_. Previous versions didn't require it. Salt is a simple string, that is usually only known by the application.

According to the manual : The salt parameter is optional. However, `'crypt() <http://www.php.net/crypt>`_ creates a weak hash without the salt. PHP 5.6 or later raise an E_NOTICE error without it. Make sure to specify a strong enough salt for better security.

.. code-block:: php

   <?php
   // Set the password
   $password = 'mypassword';
   
   // Get the hash, letting the salt be automatically generated
   // This generates a notice after PHP 5.6
   $hash = crypt($password);
   
   
   $hash = crypt($password);
   
   ?>

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/CryptWithoutSalt                                                                                                                                                                 |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _error\_reporting()-with-integers:

error_reporting() With Integers
###############################


Using named constants with error_reporting is strongly encouraged to ensure compatibility for future versions. As error levels are added, the range of integers increases, so older integer-based error levels will not always behave as expected. (Adapted from the documentation).

.. code-block:: php

   <?php
   
   // This is ready for PHP next version
   error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE & ~E_WARNING);
   
   // This is not ready for PHP next version
   error_reporting(2047);
   
   // -1 and 0 are omitted, as they will be valid even is constants changes.
   error_reporting(-1);
   error_reporting(0);
   
   ?>

+--------------+--------------------------------------+
| Command Line | Structures/ErrorReportingWithInteger |
+--------------+--------------------------------------+
| Analyzers    | :ref:`Analyze`                       |
+--------------+--------------------------------------+


.. _eval()-without-try:

eval() Without Try
##################


`'eval() <http://www.php.net/eval>`_ emits a `'ParseError <http://php.net/manual/fr/class.parseerror.php>`_ exception with PHP 7 and later. Catching this exception is the recommended way to handle errors when using the `'eval() <http://www.php.net/eval>`_ function.

.. code-block:: php

   <?php
   
   $code = 'This is no PHP code.';
   
   //PHP 5 style
   eval($code);
   // Ends up with a Fatal error, at execution time
   
   //PHP 7 style
   try {
       eval($code);
   } catch ('ParseError $e) {
       cleanUpAfterEval();
   }
   
   ?>


Note that it will catch situations where `'eval() <http://www.php.net/eval>`_ is provided with code that can't be used, but it will not catch security problems. Avoid using `'eval() <http://www.php.net/eval>`_ with incoming data.

+--------------+---------------------------+
| Command Line | Structures/EvalWithoutTry |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _ext/apc:

ext/apc
#######


Extension `Alternative PHP Cache <http://php.net/apc>`_.

.. code-block:: php

   <?php
   $bar = 'BAR';
   apc_add('foo', $bar);
   var_dump(apc_fetch('foo'));
   echo \n;
   $bar = 'NEVER GETS SET';
   apc_add('foo', $bar);
   var_dump(apc_fetch('foo'));
   echo \n;
   ?>

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Extensions/Extapc                                                                                                                                                |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _ext/dba:

ext/dba
#######


Extension ext/dba.

These functions build the foundation for accessing Berkeley DB style databases.

.. code-block:: php

   <?php
   
   $id = dba_open('/tmp/test.db', 'n', 'db2');
   
   if (!$id) {
       echo 'dba_open failed'.PHP_EOL;
       'exit;
   }
   
   dba_replace('key', 'This is an example!', $id);
   
   if (dba_exists('key', $id)) {
       echo dba_fetch('key', $id);
       dba_delete('key', $id);
   }
   
   dba_close($id);
   ?>


See also `Database (dbm-style) Abstraction Layer <http://php.net/manual/en/book.dba.php>`_.

+--------------+---------------------------+
| Command Line | Extensions/Extdba         |
+--------------+---------------------------+
| Analyzers    | :ref:`CompatibilityPHP53` |
+--------------+---------------------------+


.. _ext/ereg:

ext/ereg
########


Extension ext/ereg.

.. code-block:: php

   <?php
   if (ereg ('([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})', $date, $regs)) {
       echo $regs[3].'.'.$regs[2].'.'.$regs[1];
   } else {
       echo 'Invalid date format: '.$date;
   }
   ?>


See also `Ereg <http://php.net/manual/en/function.ereg.php>`_.

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Extensions/Extereg                                                                                         |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _ext/fdf:

ext/fdf
#######


Extension ext/fdf.

+--------------+---------------------------+
| Command Line | Extensions/Extfdf         |
+--------------+---------------------------+
| Analyzers    | :ref:`CompatibilityPHP53` |
+--------------+---------------------------+


.. _ext/mcrypt:

ext/mcrypt
##########


Extension ext/mcrypt

+--------------+---------------------------------------------------------------------------------+
| Command Line | Extensions/Extmcrypt                                                            |
+--------------+---------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------+


.. _ext/mhash:

ext/mhash
#########


Extension mhash (obsolete since PHP 5.3.0).

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Extensions/Extmhash                                                                                                                                                                         |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _ext/ming:

ext/ming
########


Extension ext/ming, to create swf files with PHP.

+--------------+---------------------------+
| Command Line | Extensions/Extming        |
+--------------+---------------------------+
| Analyzers    | :ref:`CompatibilityPHP53` |
+--------------+---------------------------+


.. _ext/mysql:

ext/mysql
#########


Extension ext/mysql

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Extensions/Extmysql                                                                                                                                              |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _func\_get\_arg()-modified:

func_get_arg() Modified
#######################


`'func_get_arg() <http://www.php.net/func_get_arg>`_ and `'func_get_args() <http://www.php.net/func_get_args>`_ used to report the calling value of the argument until PHP 7. Since PHP 7, it is reporting the value of the argument at calling time, which may have been modified by a previous instruction. 

.. code-block:: php

   <?php
   
   function x($a) {
       $a++;
       print func_get_arg(0);
   }
   
   x(0);
   ?>


This code will display 1 in PHP 7, and 0 in PHP 5.

+--------------+----------------------------------------------------------------------------------------------------------------------------+
| Command Line | Functions/funcGetArgModified                                                                                               |
+--------------+----------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+----------------------------------------------------------------------------------------------------------------------------+


.. _include\_once()-usage:

include_once() Usage
####################


include_once() and require_once() functions should be avoided for performances reasons.

.. code-block:: php

   <?php
   
   // Including a library. 
   include 'lib/helpers.inc';
   
   // Including a library, and avoiding double inclusion
   include_once 'lib/helpers.inc';
   
   ?>


Try using autoload for loading classes, or use include() or require() and make it possible to include several times the same file without errors.

+--------------+----------------------+
| Command Line | Structures/OnceUsage |
+--------------+----------------------+
| Analyzers    | :ref:`Analyze`       |
+--------------+----------------------+


.. _list()-may-omit-variables:

list() May Omit Variables
#########################


list() is the only PHP function that accepts to have omitted arguments. If the following code makes no usage of a listed variable, just omit it. 

.. code-block:: php

   <?php
       list ($a, , $b) = array(1, 2, 3);
   ?>


$b will be 3, and the 2 value will be omitted. This is cleaner, and save some memory.

+--------------+--------------------------+
| Command Line | Structures/ListOmissions |
+--------------+--------------------------+
| Analyzers    | :ref:`Analyze`           |
+--------------+--------------------------+


.. _mcrypt\_create\_iv()-with-default-values:

mcrypt_create_iv() With Default Values
######################################


mcrypt_create_iv used to have MCRYPT_DEV_RANDOM as default values, and in PHP 5.6, it now uses MCRYPT_DEV_URANDOM.

If the code doesn't have a second argument, it relies on the default value. It is recommended to set explicitely the value, so has to avoid problems while migrating.

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/McryptcreateivWithoutOption                                                                                                                                                      |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP54`, :ref:`CompatibilityPHP55`, :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP56`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


.. _parse\_str()-warning:

parse_str() Warning
###################


The `'parse_str() <http://www.php.net/parse_str>`_ function parses a query string and assigns the resulting variables to the local scope. This may create a unexpected number of variables, and even overwrite the existing one.

.. code-block:: php

   <?php
     function foo( ) {
       global $a;
       
       echo $a;
     }
   
     parse_str('a=1'); // No second parameter
     foo( );
     // displays 1
   ?>


Always use an empty variable a second parameter to `'parse_str() <http://www.php.net/parse_str>`_, so as to collect the incoming values, and then, filter them in that array.

+--------------+-------------------------------------------------------------------------------------------------------+
| Command Line | Security/parseUrlWithoutParameters                                                                    |
+--------------+-------------------------------------------------------------------------------------------------------+
| clearPHP     | `know-your-variables <https://github.com/dseguy/clearPHP/tree/master/rules/know-your-variables.md>`__ |
+--------------+-------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Security`                                                                                       |
+--------------+-------------------------------------------------------------------------------------------------------+


.. _preg\_match\_all()-flag:

preg_match_all() Flag
#####################


preg_match_all() has an option to configure the structure of the results : it is either by capturing parenthesis (by default), or by result sets. 

The second option is the most interesting when the following `'foreach() <http://php.net/manual/en/control-structures.foreach.php>`_ loop has to manipulate several captured strings at the same time. No need to use an index in the first array and use it in the other arrays.

.. code-block:: php

   <?php
   $string = 'ababab';
   
   // default behavior
   preg_match_all('/(a)(b)/', $string, $r);
   $found = '';
   foreach($r[1] as $id => $s) {
       $found .= $s.$r[2][$id];
   }
   
   // better behavior
   preg_match_all('/(a)(b)/', $string, $r, PREG_SET_ORDER);
   $found = '';
   foreach($r as $s) {
       $found .= $s[1].$s[2];
   }
   
   ?>


The second syntax is easier to read and may be marginally faster to execute (preg_match_all and foreach).

+--------------+----------------------+
| Command Line | Php/PregMatchAllFlag |
+--------------+----------------------+
| Analyzers    | :ref:`Analyze`       |
+--------------+----------------------+


.. _preg\_replace-with-option-e:

preg_replace With Option e
##########################


`'preg_replace() <http://www.php.net/preg_replace>`_ supported the /e option until PHP 7.0. It allowed the use of `'eval() <http://www.php.net/eval>`_'ed expression as replacement. This has been dropped in PHP 7.0, for security reasons.

`'preg_replace() <http://www.php.net/preg_replace>`_ with /e option may be replaced with `'preg_replace_callback() <http://www.php.net/preg_replace_callback>`_ and a closure, or `'preg_replace_callback_array() <http://www.php.net/preg_replace_callback_array>`_ and an array of closures.

.. code-block:: php

   <?php
   
   // preg_replace with /e
   $string = 'abcde';
   
   // PHP 5.6 and older usage of /e
   $replaced = preg_replace('/c/e', 'strtoupper($0)', $string);
   
   // PHP 7.0 and more recent
   // With one replacement
   $replaced = preg_replace_callback('/c/', function ($x) { return strtoupper($x[0]); }, $string);
   
   // With several replacements, preventing multiple calls to preg_replace_callback
   $replaced = preg_replace_callback_array(array('/c/' => function ($x) { return strtoupper($x[0]); },
                                                 '/[a-b]/' => function ($x) { return strtolower($x[0]); }), $string);
   ?>

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------+
| Command Line | Structures/pregOptionE                                                                                                                      |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`CompatibilityPHP70`, :ref:`Security`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------+


.. _self,-parent,-static-outside-class:

self, parent, static Outside Class
##################################


self, parent and static should be called inside a class or trait. PHP lint won't report those situations. 

self, parent and static may be used in a trait : their actual value will be only known at execution time, when the trait is used.

.. code-block:: php

   <?php
   // In the examples, self, parent and static may be used interchangeably
   
   // This raises a Fatal error
   //Fatal error: Uncaught Error: Cannot access static:: when no class scope is active
   new static();
   
   // static calls
   echo self::CONSTANTE;
   echo self::$property;
   echo self::method();
   
   // as a type hint
   function foo(static $x) {
       doSomething();
   }
   
   // as a 'instanceof
   if ($x 'instanceof static) {
       doSomething();
   }
   
   ?>


Such syntax problem is only revealed at execution time : PHP raises a Fatal error. 

The origin of the problem is usually a method that was moved outside a class, at least temporarily.

See also `Scope Resolution Operator (::) <http://php.net/manual/en/language.oop5.paamayim-nekudotayim.php>`_.

+--------------+---------------------------+
| Command Line | Classes/NoPSSOutsideClass |
+--------------+---------------------------+
| Analyzers    | :ref:`Analyze`            |
+--------------+---------------------------+


.. _set\_exception\_handler()-warning:

set_exception_handler() Warning
###############################


The `'set_exception_handler() <http://www.php.net/set_exception_handler>`_ callable function has to be adapted to PHP 7 : Exception is not the right typehint, it is now `'Throwable <http://php.net/manual/fr/class.throwable.php>`_. 

When in doubt about backward compatibility, just drop the Typehint. Otherwise, use `'Throwable <http://php.net/manual/fr/class.throwable.php>`_.

.. code-block:: php

   <?php
   
   // PHP 5.6- typehint 
   class foo { function bar(\Exception $e) {} }
   
   // PHP 7+ typehint 
   class foo { function bar('Throwable $e) {} }
   
   // PHP 5 and PHP 7 compatible typehint (note : there is none)
   class foo { function bar($e) {} }
   
   set_exception_handler(foo);
   
   ?>

+--------------+------------------------------------------------------------------------------------------------------------+
| Command Line | Php/SetExceptionHandlerPHP7                                                                                |
+--------------+------------------------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`CompatibilityPHP70`, :ref:`CompatibilityPHP71`, :ref:`CompatibilityPHP72`, :ref:`CompatibilityPHP73` |
+--------------+------------------------------------------------------------------------------------------------------------+


.. _var\_dump()...-usage:

var_dump()... Usage
###################


`'var_dump() <http://www.php.net/var_dump>`_, `'print_r() <http://www.php.net/print_r>`_ or `'var_export() <http://www.php.net/var_export>`_ should not be left in any production code. They are debugging functions.

.. code-block:: php

   <?php
   
   if ($error) {
       // Debugging usage of var_dump
       // And major security problem 
       var_dump($query);
       
       // This is OK : the $query is logged, and not displayed
       $this->log(print_r($query, true));
   }
   
   ?>


They may be tolerated during development time, but must be removed so as not to have any chance to be run in production.

+--------------+-------------------------------------------------------------------------------------------+
| Command Line | Structures/VardumpUsage                                                                   |
+--------------+-------------------------------------------------------------------------------------------+
| clearPHP     | `no-debug-code <https://github.com/dseguy/clearPHP/tree/master/rules/no-debug-code.md>`__ |
+--------------+-------------------------------------------------------------------------------------------+
| Analyzers    | :ref:`Analyze`, :ref:`Security`                                                           |
+--------------+-------------------------------------------------------------------------------------------+


.. _zend-authentication-2.5.0-undefined-classes:

zend-authentication 2.5.0 Undefined Classes
###########################################


zend-authentication classes, interfaces and traits that are not defined in version 2.5.0.

zend-authentication 2.5.0 has 27 classes, no traits and 9 interfaces;

  See also : `zend-authentication <https://github.com/zendframework/zend-authentication>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+---------------------------+
| Command Line | ZendF/Zf3Authentication25 |
+--------------+---------------------------+
| Analyzers    | :ref:`ZendFramework`      |
+--------------+---------------------------+


.. _zend-authentication-usage:

zend-authentication Usage
#########################


zend-authentication usage, based on classes, interfaces and traits. This covers version 2.5.0.

zend-authentication has 27 classes, no traits and 9 interfaces;

See also : `zend-authentication <https://github.com/zendframework/zend-authentication>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-------------------------+
| Command Line | ZendF/Zf3Authentication |
+--------------+-------------------------+
| Analyzers    | :ref:`ZendFramework`    |
+--------------+-------------------------+


.. _zend-barcode-2.5.0-undefined-classes:

zend-barcode 2.5.0 Undefined Classes
####################################


zend-barcode classes, interfaces and traits that are not defined in version 2.5.0.

zend-barcode 2.5.0 has 40 classes, no traits and 5 interfaces;

  See also : `zend-barcode <https://github.com/zendframework/zend-barcode>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Barcode25   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-barcode-2.6.0-undefined-classes:

zend-barcode 2.6.0 Undefined Classes
####################################


zend-barcode classes, interfaces and traits that are not defined in version 2.6.0.

zend-barcode 2.6.0 has 40 classes, no traits and 5 interfaces;

  See also : `zend-barcode <https://github.com/zendframework/zend-barcode>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Barcode26   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-barcode-usage:

zend-barcode Usage
##################


zend-barcode usage, based on classes, interfaces and traits. This covers all two versions 2.5.0 and 2.6.0.

zend-barcode has 40 classes, no traits and 5 interfaces;

See also : `zend-barcode <https://github.com/zendframework/zend-barcode>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Barcode     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-cache-2.5.0-undefined-classes:

zend-cache 2.5.0 Undefined Classes
##################################


zend-cache classes, interfaces and traits that are not defined in version 2.5.0.

+--------------+----------------------+
| Command Line | ZendF/Zf3Cache25     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-cache-2.6.0-undefined-classes:

zend-cache 2.6.0 Undefined Classes
##################################


zend-cache classes, interfaces and traits that are not defined in version 2.6.0.

+--------------+----------------------+
| Command Line | ZendF/Zf3Cache26     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-cache-2.7.0-undefined-classes:

zend-cache 2.7.0 Undefined Classes
##################################


zend-cache classes, interfaces and traits that are not defined in version 2.7.0.
8 new classes 
1 new trait

+--------------+----------------------+
| Command Line | ZendF/Zf3Cache27     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-cache-usage:

zend-cache Usage
################


zend-cache usage, based on classes, interfaces and traits. This covers all versions, from 2.5.0.

+--------------+--------------------------------------------+
| Command Line | ZendF/Zf3Cache                             |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`ZendFramework`, :ref:`ZendFramework` |
+--------------+--------------------------------------------+


.. _zend-captcha-2.5.0-undefined-classes:

zend-captcha 2.5.0 Undefined Classes
####################################


zend-captcha classes, interfaces and traits that are not defined in version 2.5.0.

zend-captcha 2.5.0 has 13 classes, no traits and 2 interfaces;

  See also : `zend-captcha <https://github.com/zendframework/zend-captcha>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Captcha25   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-captcha-2.6.0-undefined-classes:

zend-captcha 2.6.0 Undefined Classes
####################################


zend-captcha classes, interfaces and traits that are not defined in version 2.6.0.

zend-captcha 2.6.0 has 13 classes, no traits and 2 interfaces;

  See also : `zend-captcha <https://github.com/zendframework/zend-captcha>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Captcha26   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-captcha-2.7.0-undefined-classes:

zend-captcha 2.7.0 Undefined Classes
####################################


zend-captcha classes, interfaces and traits that are not defined in version 2.7.0.

zend-captcha 2.7.0 has 13 classes, no traits and 2 interfaces;

  See also : `zend-captcha <https://github.com/zendframework/zend-captcha>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Captcha27   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-captcha-usage:

zend-captcha Usage
##################


zend-captcha usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-captcha has 13 classes, no traits and 2 interfaces;

See also : `zend-captcha <https://github.com/zendframework/zend-captcha>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Captcha     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-code-2.5.0-undefined-classes:

zend-code 2.5.0 Undefined Classes
#################################


zend-code classes, interfaces and traits that are not defined in version 2.5.0.

zend-code 2.5.0 has 71 classes, no traits and 14 interfaces;

  See also : `zend-code <https://github.com/zendframework/zend-code>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Code25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-code-2.6.0-undefined-classes:

zend-code 2.6.0 Undefined Classes
#################################


zend-code classes, interfaces and traits that are not defined in version 2.6.0.

zend-code 2.6.0 has 72 classes, no traits and 14 interfaces;

1 new classe 
.  See also : `zend-code <https://github.com/zendframework/zend-code>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Code26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-code-3.0.0-undefined-classes:

zend-code 3.0.0 Undefined Classes
#################################


zend-code classes, interfaces and traits that are not defined in version 3.0.0.

zend-code 3.0.0 has 73 classes, no traits and 14 interfaces;

1 new classe 
.  See also : `zend-code <https://github.com/zendframework/zend-code>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Code30      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-code-3.1.0-undefined-classes:

zend-code 3.1.0 Undefined Classes
#################################


zend-code classes, interfaces and traits that are not defined in version 3.1.0.

zend-code 3.1.0 has 73 classes, no traits and 14 interfaces;

  See also : `zend-code <https://github.com/zendframework/zend-code>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Code31      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-code-usage:

zend-code Usage
###############


zend-code usage, based on classes, interfaces and traits. This covers all four versions, from 2.5.0 to 3.1.0..

zend-code has 73 classes, no traits and 14 interfaces;

See also : `zend-code <https://github.com/zendframework/zend-code>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Code        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-config-2.5.x:

zend-config 2.5.x
#################


zend-config, all versions 2.5.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Config25    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-config-2.6.x:

zend-config 2.6.x
#################


zend-config, all versions 2.6.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Config26    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-config-3.0.x:

zend-config 3.0.x
#################


zend-config, all versions beyond 3.0.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Config30    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-config-3.1.x:

zend-config 3.1.x
#################


zend-config, all versions beyond 3.1.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Config31    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-console-2.5.0-undefined-classes:

zend-console 2.5.0 Undefined Classes
####################################


zend-console classes, interfaces and traits that are not defined in version 2.5.0.

zend-console 2.5.0 has 27 classes, no traits and 6 interfaces;

  See also : `zend-console <https://github.com/zendframework/zend-console>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Console25   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-console-2.6.0-undefined-classes:

zend-console 2.6.0 Undefined Classes
####################################


zend-console classes, interfaces and traits that are not defined in version 2.6.0.

zend-console 2.6.0 has 27 classes, no traits and 6 interfaces;

  See also : `zend-console <https://github.com/zendframework/zend-console>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Console26   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-console-usage:

zend-console Usage
##################


zend-console usage, based on classes, interfaces and traits. This covers all two versions 2.5.0 and 2.6.0.

zend-console has 27 classes, no traits and 6 interfaces;

See also : `zend-console <https://github.com/zendframework/zend-console>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Console     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-crypt-2.5.0-undefined-classes:

zend-crypt 2.5.0 Undefined Classes
##################################


zend-crypt classes, interfaces and traits that are not defined in version 2.5.0.

zend-crypt 2.5.0 has 32 classes, no traits and 8 interfaces;

  See also : `zend-crypt <https://github.com/zendframework/zend-crypt>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Crypt25     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-crypt-2.6.0-undefined-classes:

zend-crypt 2.6.0 Undefined Classes
##################################


zend-crypt classes, interfaces and traits that are not defined in version 2.6.0.

zend-crypt 2.6.0 has 32 classes, no traits and 8 interfaces;

  See also : `zend-crypt <https://github.com/zendframework/zend-crypt>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Crypt26     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-crypt-3.0.0-undefined-classes:

zend-crypt 3.0.0 Undefined Classes
##################################


zend-crypt classes, interfaces and traits that are not defined in version 3.0.0.

zend-crypt 3.0.0 has 35 classes, no traits and 8 interfaces;

3 new classes 
.  See also : `zend-crypt <https://github.com/zendframework/zend-crypt>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Crypt30     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-crypt-3.1.0-undefined-classes:

zend-crypt 3.1.0 Undefined Classes
##################################


zend-crypt classes, interfaces and traits that are not defined in version 3.1.0.

zend-crypt 3.1.0 has 36 classes, no traits and 8 interfaces;

1 new classe 
.  See also : `zend-crypt <https://github.com/zendframework/zend-crypt>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Crypt31     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-crypt-3.2.0-undefined-classes:

zend-crypt 3.2.0 Undefined Classes
##################################


zend-crypt classes, interfaces and traits that are not defined in version 3.2.0.

zend-crypt 3.2.0 has 36 classes, no traits and 8 interfaces;

  See also : `zend-crypt <https://github.com/zendframework/zend-crypt>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Crypt32     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-crypt-usage:

zend-crypt Usage
################


zend-crypt usage, based on classes, interfaces and traits. This covers all five versions, from 2.5.0 to 3.2.0..

zend-crypt has 36 classes, no traits and 8 interfaces;

See also : `zend-crypt <https://github.com/zendframework/zend-crypt>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Crypt       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-db-2.5.0-undefined-classes:

zend-db 2.5.0 Undefined Classes
###############################


zend-db classes, interfaces and traits that are not defined in version 2.5.0.

zend-db 2.5.0 has 162 classes, 1 traits and 30 interfaces;

  See also : `zend-db <https://github.com/zendframework/zend-db>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Db25        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-db-2.6.0-undefined-classes:

zend-db 2.6.0 Undefined Classes
###############################


zend-db classes, interfaces and traits that are not defined in version 2.6.0.

zend-db 2.6.0 has 165 classes, 1 traits and 31 interfaces;

3 new classes 
.  See also : `zend-db <https://github.com/zendframework/zend-db>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Db26        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-db-2.7.0-undefined-classes:

zend-db 2.7.0 Undefined Classes
###############################


zend-db classes, interfaces and traits that are not defined in version 2.7.0.

zend-db 2.7.0 has 165 classes, 1 traits and 31 interfaces;

  See also : `zend-db <https://github.com/zendframework/zend-db>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Db27        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-db-2.8.0-undefined-classes:

zend-db 2.8.0 Undefined Classes
###############################


zend-db classes, interfaces and traits that are not defined in version 2.8.0.

zend-db 2.8.0 has 168 classes, 1 traits and 31 interfaces;

3 new classes 
.  See also : `zend-db <https://github.com/zendframework/zend-db>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Db28        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-db-usage:

zend-db Usage
#############


zend-db usage, based on classes, interfaces and traits. This covers all four versions, from 2.5.0 to 2.8.0..

zend-db has 168 classes, 1 traits and 31 interfaces;

See also : `zend-db <https://github.com/zendframework/zend-db>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Db          |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-debug-2.5.0-undefined-classes:

zend-debug 2.5.0 Undefined Classes
##################################


zend-debug classes, interfaces and traits that are not defined in version 2.5.0.

zend-debug 2.5.0 has 1 classes, no traits and no interfaces;

  See also : `zend-debug <https://github.com/zendframework/zend-debug>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Debug25     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-debug-usage:

zend-debug Usage
################


zend-debug usage, based on classes, interfaces and traits. This covers version 2.5.0.

zend-debug has 1 classes, no traits and no interfaces;

See also : `zend-debug <https://github.com/zendframework/zend-debug>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Debug       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-di-2.5.0-undefined-classes:

zend-di 2.5.0 Undefined Classes
###############################


zend-di classes, interfaces and traits that are not defined in version 2.5.0.

zend-di 2.5.0 has 28 classes, no traits and 6 interfaces;

  See also : `zend-di <https://github.com/zendframework/zend-di>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Di25        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-di-2.6.0-undefined-classes:

zend-di 2.6.0 Undefined Classes
###############################


zend-di classes, interfaces and traits that are not defined in version 2.6.0.

zend-di 2.6.0 has 28 classes, no traits and 6 interfaces;

  See also : `zend-di <https://github.com/zendframework/zend-di>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Di26        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-di-usage:

zend-di Usage
#############


zend-di usage, based on classes, interfaces and traits. This covers all two versions 2.5.0 and 2.6.0.

zend-di has 28 classes, no traits and 6 interfaces;

See also : `zend-di <https://github.com/zendframework/zend-di>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Di          |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-dom-2.5.0-undefined-classes:

zend-dom 2.5.0 Undefined Classes
################################


zend-dom classes, interfaces and traits that are not defined in version 2.5.0.

zend-dom 2.5.0 has 9 classes, no traits and 1 interfaces;

  See also : `zend-dom <https://github.com/zendframework/zend-dom>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Dom25       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-dom-2.6.0-undefined-classes:

zend-dom 2.6.0 Undefined Classes
################################


zend-dom classes, interfaces and traits that are not defined in version 2.6.0.

zend-dom 2.6.0 has 9 classes, no traits and 1 interfaces;

  See also : `zend-dom <https://github.com/zendframework/zend-dom>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Dom26       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-dom-usage:

zend-dom Usage
##############


zend-dom usage, based on classes, interfaces and traits. This covers all two versions 2.5.0 and 2.6.0.

zend-dom has 9 classes, no traits and 1 interfaces;

See also : `zend-dom <https://github.com/zendframework/zend-dom>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Dom         |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-escaper-2.5.0-undefined-classes:

zend-escaper 2.5.0 Undefined Classes
####################################


zend-escaper classes, interfaces and traits that are not defined in version 2.5.0.

zend-escaper 2.5.0 has 3 classes, no traits and 1 interfaces;

  See also : `zend-escaper <https://github.com/zendframework/zend-escaper>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Escaper25   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-escaper-usage:

zend-escaper Usage
##################


zend-escaper usage, based on classes, interfaces and traits. This covers version 2.5.0.

zend-escaper has 3 classes, no traits and 1 interfaces;

See also : `zend-escaper <https://github.com/zendframework/zend-escaper>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Escaper     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-eventmanager-2.5.0-undefined-classes:

zend-eventmanager 2.5.0 Undefined Classes
#########################################


zend-eventmanager classes, interfaces and traits that are not defined in version 2.5.0.

zend-eventmanager 2.5.0 has 12 classes, 3 traits and 11 interfaces;

  See also : `zend-eventmanager <https://github.com/zendframework/zend-eventmanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------------------------+
| Command Line | ZendF/Zf3Eventmanager25                    |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`ZendFramework`, :ref:`ZendFramework` |
+--------------+--------------------------------------------+


.. _zend-eventmanager-2.6.0-undefined-classes:

zend-eventmanager 2.6.0 Undefined Classes
#########################################


zend-eventmanager classes, interfaces and traits that are not defined in version 2.6.0.

zend-eventmanager 2.6.0 has 12 classes, 3 traits and 12 interfaces;

  See also : `zend-eventmanager <https://github.com/zendframework/zend-eventmanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------------------------+
| Command Line | ZendF/Zf3Eventmanager26                    |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`ZendFramework`, :ref:`ZendFramework` |
+--------------+--------------------------------------------+


.. _zend-eventmanager-3.0.0-undefined-classes:

zend-eventmanager 3.0.0 Undefined Classes
#########################################


zend-eventmanager classes, interfaces and traits that are not defined in version 3.0.0.

zend-eventmanager 3.0.0 has 14 classes, 3 traits and 9 interfaces;

4 new classes 
, 1 new trait 
. 2 removed classes 
, 1 removed trait 
. See also : `zend-eventmanager <https://github.com/zendframework/zend-eventmanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------------------------+
| Command Line | ZendF/Zf3Eventmanager30                    |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`ZendFramework`, :ref:`ZendFramework` |
+--------------+--------------------------------------------+


.. _zend-eventmanager-3.1.0-undefined-classes:

zend-eventmanager 3.1.0 Undefined Classes
#########################################


zend-eventmanager classes, interfaces and traits that are not defined in version 3.1.0.

zend-eventmanager 3.1.0 has 14 classes, 3 traits and 9 interfaces;

  See also : `zend-eventmanager <https://github.com/zendframework/zend-eventmanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------------------------+
| Command Line | ZendF/Zf3Eventmanager31                    |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`ZendFramework`, :ref:`ZendFramework` |
+--------------+--------------------------------------------+


.. _zend-eventmanager-usage:

zend-eventmanager Usage
#######################


zend-eventmanager usage, based on classes, interfaces and traits. This covers all four versions, from 2.5.0 to 3.1.0..

zend-eventmanager has 16 classes, 4 traits and 12 interfaces;

See also : `zend-eventmanager <https://github.com/zendframework/zend-eventmanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------------------------+
| Command Line | ZendF/Zf3Eventmanager                      |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`ZendFramework`, :ref:`ZendFramework` |
+--------------+--------------------------------------------+


.. _zend-feed-2.5.0-undefined-classes:

zend-feed 2.5.0 Undefined Classes
#################################


zend-feed classes, interfaces and traits that are not defined in version 2.5.0.

zend-feed 2.5.0 has 88 classes, no traits and 15 interfaces;

  See also : `zend-feed <https://github.com/zendframework/zend-feed>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Feed25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-feed-2.6.0-undefined-classes:

zend-feed 2.6.0 Undefined Classes
#################################


zend-feed classes, interfaces and traits that are not defined in version 2.6.0.

zend-feed 2.6.0 has 93 classes, no traits and 17 interfaces;

5 new classes 
.  See also : `zend-feed <https://github.com/zendframework/zend-feed>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Feed26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-feed-2.7.0-undefined-classes:

zend-feed 2.7.0 Undefined Classes
#################################


zend-feed classes, interfaces and traits that are not defined in version 2.7.0.

zend-feed 2.7.0 has 93 classes, no traits and 17 interfaces;

  See also : `zend-feed <https://github.com/zendframework/zend-feed>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Feed27      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-feed-usage:

zend-feed Usage
###############


zend-feed usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-feed has 93 classes, no traits and 17 interfaces;

See also : `zend-feed <https://github.com/zendframework/zend-feed>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Feed        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-file-2.5.0-undefined-classes:

zend-file 2.5.0 Undefined Classes
#################################


zend-file classes, interfaces and traits that are not defined in version 2.5.0.

zend-file 2.5.0 has 14 classes, no traits and 2 interfaces;

  See also : `zend-file <https://github.com/zendframework/zend-file>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3File25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-file-2.6.0-undefined-classes:

zend-file 2.6.0 Undefined Classes
#################################


zend-file classes, interfaces and traits that are not defined in version 2.6.0.

zend-file 2.6.0 has 14 classes, no traits and 2 interfaces;

  See also : `zend-file <https://github.com/zendframework/zend-file>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3File26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-file-2.7.0-undefined-classes:

zend-file 2.7.0 Undefined Classes
#################################


zend-file classes, interfaces and traits that are not defined in version 2.7.0.

zend-file 2.7.0 has 14 classes, no traits and 2 interfaces;

  See also : `zend-file <https://github.com/zendframework/zend-file>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3File27      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-file-usage:

zend-file Usage
###############


zend-file usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-file has 14 classes, no traits and 2 interfaces;

See also : `zend-file <https://github.com/zendframework/zend-file>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3File        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-filter-2.5.0-undefined-classes:

zend-filter 2.5.0 Undefined Classes
###################################


zend-filter classes, interfaces and traits that are not defined in version 2.5.0.

zend-filter 2.5.0 has 73 classes, no traits and 4 interfaces;

  See also : `zend-filter <https://github.com/zendframework/zend-filter>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Filter25    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-filter-2.6.0-undefined-classes:

zend-filter 2.6.0 Undefined Classes
###################################


zend-filter classes, interfaces and traits that are not defined in version 2.6.0.

zend-filter 2.6.0 has 73 classes, no traits and 4 interfaces;

  See also : `zend-filter <https://github.com/zendframework/zend-filter>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Filter26    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-filter-2.7.0-undefined-classes:

zend-filter 2.7.0 Undefined Classes
###################################


zend-filter classes, interfaces and traits that are not defined in version 2.7.0.

zend-filter 2.7.0 has 76 classes, no traits and 4 interfaces;

3 new classes 
.  See also : `zend-filter <https://github.com/zendframework/zend-filter>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Filter27    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-filter-usage:

zend-filter Usage
#################


zend-filter usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-filter has 76 classes, no traits and 4 interfaces;

See also : `zend-filter <https://github.com/zendframework/zend-filter>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Filter      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-form-2.5.0-undefined-classes:

zend-form 2.5.0 Undefined Classes
#################################


zend-form classes, interfaces and traits that are not defined in version 2.5.0.

zend-form 2.5.0 has 115 classes, 2 traits and 9 interfaces;

  See also : `zend-form <https://github.com/zendframework/zend-form>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Form25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-form-2.6.0-undefined-classes:

zend-form 2.6.0 Undefined Classes
#################################


zend-form classes, interfaces and traits that are not defined in version 2.6.0.

zend-form 2.6.0 has 115 classes, 2 traits and 9 interfaces;

  See also : `zend-form <https://github.com/zendframework/zend-form>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Form26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-form-2.7.0-undefined-classes:

zend-form 2.7.0 Undefined Classes
#################################


zend-form classes, interfaces and traits that are not defined in version 2.7.0.

zend-form 2.7.0 has 116 classes, 2 traits and 9 interfaces;

1 new classe 
.  See also : `zend-form <https://github.com/zendframework/zend-form>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Form27      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-form-2.8.0-undefined-classes:

zend-form 2.8.0 Undefined Classes
#################################


zend-form classes, interfaces and traits that are not defined in version 2.8.0.

zend-form 2.8.0 has 120 classes, 2 traits and 9 interfaces;

4 new classes 
.  See also : `zend-form <https://github.com/zendframework/zend-form>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Form28      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-form-2.9.0-undefined-classes:

zend-form 2.9.0 Undefined Classes
#################################


zend-form classes, interfaces and traits that are not defined in version 2.9.0.

zend-form 2.9.0 has 123 classes, 3 traits and 9 interfaces;

4 new classes 
, 1 new trait 
. 1 removed classe 
. See also : `zend-form <https://github.com/zendframework/zend-form>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Form29      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-form-usage:

zend-form Usage
###############


zend-form usage, based on classes, interfaces and traits. This covers all five versions, from 2.5.0 to 2.9.0..

zend-form has 124 classes, 3 traits and 9 interfaces;

See also : `zend-form <https://github.com/zendframework/zend-form>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Form        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-http-2.5.0-undefined-classes:

zend-http 2.5.0 Undefined Classes
#################################


zend-http classes, interfaces and traits that are not defined in version 2.5.0.

zend-http 2.5.0 has 97 classes, no traits and 8 interfaces;

  See also : `zend-http <https://github.com/zendframework/zend-http>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Http25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-http-2.6.0-undefined-classes:

zend-http 2.6.0 Undefined Classes
#################################


zend-http classes, interfaces and traits that are not defined in version 2.6.0.

zend-http 2.6.0 has 97 classes, no traits and 8 interfaces;

  See also : `zend-http <https://github.com/zendframework/zend-http>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Http26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-http-usage:

zend-http Usage
###############


zend-http usage, based on classes, interfaces and traits. This covers all two versions 2.5.0 and 2.6.0.

zend-http has 97 classes, no traits and 8 interfaces;

See also : `zend-http <https://github.com/zendframework/zend-http>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Http        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-i18n-2.5.0-undefined-classes:

zend-i18n 2.5.0 Undefined Classes
#################################


zend-i18n classes, interfaces and traits that are not defined in version 2.5.0.

zend-i18n 2.5.0 has 40 classes, 1 traits and 5 interfaces;

  See also : `zend-i18n <https://github.com/zendframework/zend-i18n>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3I18n25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-i18n-2.6.0-undefined-classes:

zend-i18n 2.6.0 Undefined Classes
#################################


zend-i18n classes, interfaces and traits that are not defined in version 2.6.0.

zend-i18n 2.6.0 has 40 classes, 1 traits and 5 interfaces;

  See also : `zend-i18n <https://github.com/zendframework/zend-i18n>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3I18n26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-i18n-2.7.0-undefined-classes:

zend-i18n 2.7.0 Undefined Classes
#################################


zend-i18n classes, interfaces and traits that are not defined in version 2.7.0.

zend-i18n 2.7.0 has 43 classes, 1 traits and 5 interfaces;

3 new classes 
.  See also : `zend-i18n <https://github.com/zendframework/zend-i18n>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3I18n27      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-i18n-usage:

zend-i18n Usage
###############


zend-i18n usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-i18n has 43 classes, 1 traits and 5 interfaces;

See also : `zend-i18n <https://github.com/zendframework/zend-i18n>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3I18n        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-i18n-resources-usage:

zend-i18n resources Usage
#########################


zend-i18n-resources usage, based on classes, interfaces and traits. This covers the only version, 2.5.0.

zend-i18n has 1 classe, no traits and no interfaces;

See also : `zend-i18n-resources <https://github.com/zendframework/zend-i18n-resources>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-------------------------+
| Command Line | ZendF/Zf3I18n_resources |
+--------------+-------------------------+
| Analyzers    | :ref:`ZendFramework`    |
+--------------+-------------------------+


.. _zend-i18n-resources-2.5.x:

zend-i18n-resources 2.5.x
#########################


zend-i18n-resources, all versions 2.5.x.

+--------------+---------------------------+
| Command Line | ZendF/Zf3I18n_resources25 |
+--------------+---------------------------+
| Analyzers    | :ref:`ZendFramework`      |
+--------------+---------------------------+


.. _zend-inputfilter-2.5.0-undefined-classes:

zend-inputfilter 2.5.0 Undefined Classes
########################################


zend-inputfilter classes, interfaces and traits that are not defined in version 2.5.0.

zend-inputfilter 2.5.0 has 11 classes, 1 traits and 9 interfaces;

  See also : `zend-inputfilter <https://github.com/zendframework/zend-inputfilter>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+------------------------+
| Command Line | ZendF/Zf3Inputfilter25 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _zend-inputfilter-2.6.0-undefined-classes:

zend-inputfilter 2.6.0 Undefined Classes
########################################


zend-inputfilter classes, interfaces and traits that are not defined in version 2.6.0.

zend-inputfilter 2.6.0 has 11 classes, 1 traits and 9 interfaces;

  See also : `zend-inputfilter <https://github.com/zendframework/zend-inputfilter>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+------------------------+
| Command Line | ZendF/Zf3Inputfilter26 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _zend-inputfilter-2.7.0-undefined-classes:

zend-inputfilter 2.7.0 Undefined Classes
########################################


zend-inputfilter classes, interfaces and traits that are not defined in version 2.7.0.

zend-inputfilter 2.7.0 has 14 classes, 1 traits and 9 interfaces;

3 new classes 
.  See also : `zend-inputfilter <https://github.com/zendframework/zend-inputfilter>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+------------------------+
| Command Line | ZendF/Zf3Inputfilter27 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _zend-inputfilter-usage:

zend-inputfilter Usage
######################


zend-inputfilter usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-inputfilter has 14 classes, 1 traits and 9 interfaces;

See also : `zend-inputfilter <https://github.com/zendframework/zend-inputfilter>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Inputfilter |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-json-2.5.0-undefined-classes:

zend-json 2.5.0 Undefined Classes
#################################


zend-json classes, interfaces and traits that are not defined in version 2.5.0.

zend-json 2.5.0 has 22 classes, no traits and 2 interfaces;

  See also : `zend-json <https://github.com/zendframework/zend-json>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Json25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-json-2.6.0-undefined-classes:

zend-json 2.6.0 Undefined Classes
#################################


zend-json classes, interfaces and traits that are not defined in version 2.6.0.

zend-json 2.6.0 has 22 classes, no traits and 2 interfaces;

  See also : `zend-json <https://github.com/zendframework/zend-json>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Json26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-json-3.0.0-undefined-classes:

zend-json 3.0.0 Undefined Classes
#################################


zend-json classes, interfaces and traits that are not defined in version 3.0.0.

zend-json 3.0.0 has 8 classes, no traits and 1 interfaces;

14 removed classes. 

See also : `zend-json <https://github.com/zendframework/zend-json>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Json30      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-json-usage:

zend-json Usage
###############


zend-json usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 3.0.0..

zend-json has 22 classes, no traits and 2 interfaces;

See also : `zend-json <https://github.com/zendframework/zend-json>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Json        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-loader-2.5.0-undefined-classes:

zend-loader 2.5.0 Undefined Classes
###################################


zend-loader classes, interfaces and traits that are not defined in version 2.5.0.

zend-loader 2.5.0 has 13 classes, no traits and 4 interfaces;

  See also : `zend-loader <https://github.com/zendframework/zend-loader>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Loader25    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-loader-usage:

zend-loader Usage
#################


zend-loader usage, based on classes, interfaces and traits. This covers version 2.5.0.

zend-loader has 13 classes, no traits and 4 interfaces;

See also : `zend-loader <https://github.com/zendframework/zend-loader>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Loader      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-log-2.5.0-undefined-classes:

zend-log 2.5.0 Undefined Classes
################################


zend-log classes, interfaces and traits that are not defined in version 2.5.0.

zend-log 2.5.0 has 42 classes, 1 traits and 9 interfaces;

  See also : `zend-log <https://github.com/zendframework/zend-log>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Log25       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-log-2.6.0-undefined-classes:

zend-log 2.6.0 Undefined Classes
################################


zend-log classes, interfaces and traits that are not defined in version 2.6.0.

zend-log 2.6.0 has 45 classes, 1 traits and 9 interfaces;

3 new classes 
.  See also : `zend-log <https://github.com/zendframework/zend-log>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Log26       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-log-2.7.0-undefined-classes:

zend-log 2.7.0 Undefined Classes
################################


zend-log classes, interfaces and traits that are not defined in version 2.7.0.

zend-log 2.7.0 has 47 classes, 1 traits and 9 interfaces;

2 new classes 
.  See also : `zend-log <https://github.com/zendframework/zend-log>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Log27       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-log-2.8.0-undefined-classes:

zend-log 2.8.0 Undefined Classes
################################


zend-log classes, interfaces and traits that are not defined in version 2.8.0.

zend-log 2.8.0 has 53 classes, 1 traits and 9 interfaces;

6 new classes 
.  See also : `zend-log <https://github.com/zendframework/zend-log>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Log28       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-log-2.9.0-undefined-classes:

zend-log 2.9.0 Undefined Classes
################################


zend-log classes, interfaces and traits that are not defined in version 2.9.0.

zend-log 2.9.0 has 56 classes, 1 traits and 11 interfaces;

3 new classes 
.  See also : `zend-log <https://github.com/zendframework/zend-log>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Log29       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-log-usage:

zend-log Usage
##############


zend-log usage, based on classes, interfaces and traits. This covers all five versions, from 2.5.0 to 2.9.0..

zend-log has 56 classes, 1 traits and 11 interfaces;

See also : `zend-log <https://github.com/zendframework/zend-log>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Log         |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mail-2.5.0-undefined-classes:

zend-mail 2.5.0 Undefined Classes
#################################


zend-mail classes, interfaces and traits that are not defined in version 2.5.0.

zend-mail 2.5.0 has 74 classes, no traits and 16 interfaces;

  See also : `zend-mail <https://github.com/zendframework/zend-mail>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mail25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mail-2.6.0-undefined-classes:

zend-mail 2.6.0 Undefined Classes
#################################


zend-mail classes, interfaces and traits that are not defined in version 2.6.0.

zend-mail 2.6.0 has 74 classes, no traits and 16 interfaces;

  See also : `zend-mail <https://github.com/zendframework/zend-mail>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mail26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mail-2.7.0-undefined-classes:

zend-mail 2.7.0 Undefined Classes
#################################


zend-mail classes, interfaces and traits that are not defined in version 2.7.0.

zend-mail 2.7.0 has 77 classes, no traits and 16 interfaces;

3 new classes 
.  See also : `zend-mail <https://github.com/zendframework/zend-mail>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mail27      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mail-usage:

zend-mail Usage
###############


zend-mail usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-mail has 77 classes, no traits and 16 interfaces;

See also : `zend-mail <https://github.com/zendframework/zend-mail>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mail        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-math-2.5.0-undefined-classes:

zend-math 2.5.0 Undefined Classes
#################################


zend-math classes, interfaces and traits that are not defined in version 2.5.0.

zend-math 2.5.0 has 12 classes, no traits and 3 interfaces;

  See also : `zend-math <https://github.com/zendframework/zend-math>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Math25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-math-2.6.0-undefined-classes:

zend-math 2.6.0 Undefined Classes
#################################


zend-math classes, interfaces and traits that are not defined in version 2.6.0.

zend-math 2.6.0 has 11 classes, no traits and 3 interfaces;

1 removed classe. 

See also : `zend-math <https://github.com/zendframework/zend-math>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Math26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-math-2.7.0-undefined-classes:

zend-math 2.7.0 Undefined Classes
#################################


zend-math classes, interfaces and traits that are not defined in version 2.7.0.

zend-math 2.7.0 has 11 classes, no traits and 3 interfaces;

  See also : `zend-math <https://github.com/zendframework/zend-math>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Math27      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-math-3.0.0-undefined-classes:

zend-math 3.0.0 Undefined Classes
#################################


zend-math classes, interfaces and traits that are not defined in version 3.0.0.

zend-math 3.0.0 has 10 classes, no traits and 3 interfaces;

1 removed classe. 

See also : `zend-math <https://github.com/zendframework/zend-math>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Math30      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-math-usage:

zend-math Usage
###############


zend-math usage, based on classes, interfaces and traits. This covers all four versions, from 2.5.0 to 3.0.0..

zend-math has 12 classes, no traits and 3 interfaces;

See also : `zend-math <https://github.com/zendframework/zend-math>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Math        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-memory-2.5.0-undefined-classes:

zend-memory 2.5.0 Undefined Classes
###################################


zend-memory classes, interfaces and traits that are not defined in version 2.5.0.

zend-memory 2.5.0 has 8 classes, no traits and 2 interfaces;

  See also : `zend-memory <https://github.com/zendframework/zend-memory>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Memory25    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-memory-usage:

zend-memory Usage
#################


zend-memory usage, based on classes, interfaces and traits. This covers version 2.5.0.

zend-memory has 8 classes, no traits and 2 interfaces;

See also : `zend-memory <https://github.com/zendframework/zend-memory>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Memory      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mime-2.5.0-undefined-classes:

zend-mime 2.5.0 Undefined Classes
#################################


zend-mime classes, interfaces and traits that are not defined in version 2.5.0.

zend-mime 2.5.0 has 6 classes, no traits and 1 interfaces;

  See also : `zend-mime <https://github.com/zendframework/zend-mime>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mime25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mime-2.6.0-undefined-classes:

zend-mime 2.6.0 Undefined Classes
#################################


zend-mime classes, interfaces and traits that are not defined in version 2.6.0.

zend-mime 2.6.0 has 6 classes, no traits and 1 interfaces;

  See also : `zend-mime <https://github.com/zendframework/zend-mime>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mime26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mime-usage:

zend-mime Usage
###############


zend-mime usage, based on classes, interfaces and traits. This covers all two versions 2.5.0 and 2.6.0.

zend-mime has 6 classes, no traits and 1 interfaces;

See also : `zend-mime <https://github.com/zendframework/zend-mime>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mime        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-modulemanager-2.5.0-undefined-classes:

zend-modulemanager 2.5.0 Undefined Classes
##########################################


zend-modulemanager classes, interfaces and traits that are not defined in version 2.5.0.

zend-modulemanager 2.5.0 has 19 classes, no traits and 27 interfaces;

  See also : `zend-modulemanager <https://github.com/zendframework/zend-modulemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------+
| Command Line | ZendF/Zf3Modulemanager25 |
+--------------+--------------------------+
| Analyzers    | :ref:`ZendFramework`     |
+--------------+--------------------------+


.. _zend-modulemanager-2.6.0-undefined-classes:

zend-modulemanager 2.6.0 Undefined Classes
##########################################


zend-modulemanager classes, interfaces and traits that are not defined in version 2.6.0.

zend-modulemanager 2.6.0 has 19 classes, no traits and 27 interfaces;

  See also : `zend-modulemanager <https://github.com/zendframework/zend-modulemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------+
| Command Line | ZendF/Zf3Modulemanager26 |
+--------------+--------------------------+
| Analyzers    | :ref:`ZendFramework`     |
+--------------+--------------------------+


.. _zend-modulemanager-2.7.0-undefined-classes:

zend-modulemanager 2.7.0 Undefined Classes
##########################################


zend-modulemanager classes, interfaces and traits that are not defined in version 2.7.0.

zend-modulemanager 2.7.0 has 19 classes, no traits and 27 interfaces;

  See also : `zend-modulemanager <https://github.com/zendframework/zend-modulemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------+
| Command Line | ZendF/Zf3Modulemanager27 |
+--------------+--------------------------+
| Analyzers    | :ref:`ZendFramework`     |
+--------------+--------------------------+


.. _zend-modulemanager-usage:

zend-modulemanager Usage
########################


zend-modulemanager usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-modulemanager has 19 classes, no traits and 27 interfaces;

See also : `zend-modulemanager <https://github.com/zendframework/zend-modulemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+------------------------+
| Command Line | ZendF/Zf3Modulemanager |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _zend-mvc:

zend-mvc
########


zend-mvc, all versions beyond 2.5.0.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mvc         |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mvc-2.5.x:

zend-mvc 2.5.x
##############


zend-mvc, all versions 2.5.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mvc25       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mvc-2.6.x:

zend-mvc 2.6.x
##############


zend-mvc, all versions 2.6.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mvc26       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mvc-2.7.x:

zend-mvc 2.7.x
##############


zend-mvc, all versions 2.7.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mvc27       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-mvc-3.0.x:

zend-mvc 3.0.x
##############


zend-mvc, all versions 3.0.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Mvc30       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-navigation-2.5.0-undefined-classes:

zend-navigation 2.5.0 Undefined Classes
#######################################


zend-navigation classes, interfaces and traits that are not defined in version 2.5.0.

zend-navigation 2.5.0 has 14 classes, no traits and 1 interfaces;

  See also : `zend-navigation <https://github.com/zendframework/zend-navigation>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-----------------------+
| Command Line | ZendF/Zf3Navigation25 |
+--------------+-----------------------+
| Analyzers    | :ref:`ZendFramework`  |
+--------------+-----------------------+


.. _zend-navigation-2.6.0-undefined-classes:

zend-navigation 2.6.0 Undefined Classes
#######################################


zend-navigation classes, interfaces and traits that are not defined in version 2.6.0.

zend-navigation 2.6.0 has 15 classes, no traits and 1 interfaces;

1 new classe 
.  See also : `zend-navigation <https://github.com/zendframework/zend-navigation>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-----------------------+
| Command Line | ZendF/Zf3Navigation26 |
+--------------+-----------------------+
| Analyzers    | :ref:`ZendFramework`  |
+--------------+-----------------------+


.. _zend-navigation-2.7.0-undefined-classes:

zend-navigation 2.7.0 Undefined Classes
#######################################


zend-navigation classes, interfaces and traits that are not defined in version 2.7.0.

zend-navigation 2.7.0 has 18 classes, no traits and 1 interfaces;

3 new classes 
.  See also : `zend-navigation <https://github.com/zendframework/zend-navigation>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-----------------------+
| Command Line | ZendF/Zf3Navigation27 |
+--------------+-----------------------+
| Analyzers    | :ref:`ZendFramework`  |
+--------------+-----------------------+


.. _zend-navigation-2.8.0-undefined-classes:

zend-navigation 2.8.0 Undefined Classes
#######################################


zend-navigation classes, interfaces and traits that are not defined in version 2.8.0.

zend-navigation 2.8.0 has 18 classes, no traits and 1 interfaces;

  See also : `zend-navigation <https://github.com/zendframework/zend-navigation>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-----------------------+
| Command Line | ZendF/Zf3Navigation28 |
+--------------+-----------------------+
| Analyzers    | :ref:`ZendFramework`  |
+--------------+-----------------------+


.. _zend-navigation-usage:

zend-navigation Usage
#####################


zend-navigation usage, based on classes, interfaces and traits. This covers all four versions, from 2.5.0 to 2.8.0..

zend-navigation has 18 classes, no traits and 1 interfaces;

See also : `zend-navigation <https://github.com/zendframework/zend-navigation>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Navigation  |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-paginator-2.5.0-undefined-classes:

zend-paginator 2.5.0 Undefined Classes
######################################


zend-paginator classes, interfaces and traits that are not defined in version 2.5.0.

zend-paginator 2.5.0 has 26 classes, no traits and 5 interfaces;

  See also : `zend-paginator <https://github.com/zendframework/zend-paginator>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Paginator25 |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-paginator-2.6.0-undefined-classes:

zend-paginator 2.6.0 Undefined Classes
######################################


zend-paginator classes, interfaces and traits that are not defined in version 2.6.0.

zend-paginator 2.6.0 has 27 classes, no traits and 5 interfaces;

1 new classe 
.  See also : `zend-paginator <https://github.com/zendframework/zend-paginator>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Paginator26 |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-paginator-2.7.0-undefined-classes:

zend-paginator 2.7.0 Undefined Classes
######################################


zend-paginator classes, interfaces and traits that are not defined in version 2.7.0.

zend-paginator 2.7.0 has 31 classes, no traits and 5 interfaces;

4 new classes 
.  See also : `zend-paginator <https://github.com/zendframework/zend-paginator>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Paginator27 |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-paginator-usage:

zend-paginator Usage
####################


zend-paginator usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-paginator has 31 classes, no traits and 5 interfaces;

See also : `zend-paginator <https://github.com/zendframework/zend-paginator>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Paginator   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-progressbar-2.5.0-undefined-classes:

zend-progressbar 2.5.0 Undefined Classes
########################################


zend-progressbar classes, interfaces and traits that are not defined in version 2.5.0.

zend-progressbar 2.5.0 has 15 classes, no traits and 3 interfaces;

  See also : `zend-progressbar <https://github.com/zendframework/zend-progressbar>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+------------------------+
| Command Line | ZendF/Zf3Progressbar25 |
+--------------+------------------------+
| Analyzers    | :ref:`ZendFramework`   |
+--------------+------------------------+


.. _zend-progressbar-usage:

zend-progressbar Usage
######################


zend-progressbar usage, based on classes, interfaces and traits. This covers version 2.5.0.

zend-progressbar has 15 classes, no traits and 3 interfaces;

See also : `zend-progressbar <https://github.com/zendframework/zend-progressbar>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Progressbar |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-serializer-2.5.0-undefined-classes:

zend-serializer 2.5.0 Undefined Classes
#######################################


zend-serializer classes, interfaces and traits that are not defined in version 2.5.0.

zend-serializer 2.5.0 has 17 classes, no traits and 2 interfaces;

  See also : `zend-serializer <https://github.com/zendframework/zend-serializer>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-----------------------+
| Command Line | ZendF/Zf3Serializer25 |
+--------------+-----------------------+
| Analyzers    | :ref:`ZendFramework`  |
+--------------+-----------------------+


.. _zend-serializer-2.6.0-undefined-classes:

zend-serializer 2.6.0 Undefined Classes
#######################################


zend-serializer classes, interfaces and traits that are not defined in version 2.6.0.

zend-serializer 2.6.0 has 17 classes, no traits and 2 interfaces;

  See also : `zend-serializer <https://github.com/zendframework/zend-serializer>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-----------------------+
| Command Line | ZendF/Zf3Serializer26 |
+--------------+-----------------------+
| Analyzers    | :ref:`ZendFramework`  |
+--------------+-----------------------+


.. _zend-serializer-2.7.0-undefined-classes:

zend-serializer 2.7.0 Undefined Classes
#######################################


zend-serializer classes, interfaces and traits that are not defined in version 2.7.0.

zend-serializer 2.7.0 has 20 classes, no traits and 2 interfaces;

3 new classes 
.  See also : `zend-serializer <https://github.com/zendframework/zend-serializer>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-----------------------+
| Command Line | ZendF/Zf3Serializer27 |
+--------------+-----------------------+
| Analyzers    | :ref:`ZendFramework`  |
+--------------+-----------------------+


.. _zend-serializer-2.8.0-undefined-classes:

zend-serializer 2.8.0 Undefined Classes
#######################################


zend-serializer classes, interfaces and traits that are not defined in version 2.8.0.

zend-serializer 2.8.0 has 20 classes, no traits and 2 interfaces;

  See also : `zend-serializer <https://github.com/zendframework/zend-serializer>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-----------------------+
| Command Line | ZendF/Zf3Serializer28 |
+--------------+-----------------------+
| Analyzers    | :ref:`ZendFramework`  |
+--------------+-----------------------+


.. _zend-serializer-usage:

zend-serializer Usage
#####################


zend-serializer usage, based on classes, interfaces and traits. This covers all four versions, from 2.5.0 to 2.8.0..

zend-serializer has 20 classes, no traits and 2 interfaces;

See also : `zend-serializer <https://github.com/zendframework/zend-serializer>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Serializer  |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-server-2.5.0-undefined-classes:

zend-server 2.5.0 Undefined Classes
###################################


zend-server classes, interfaces and traits that are not defined in version 2.5.0.

zend-server 2.5.0 has 22 classes, no traits and 4 interfaces;

  See also : `zend-server <https://github.com/zendframework/zend-server>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Server25    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-server-2.6.0-undefined-classes:

zend-server 2.6.0 Undefined Classes
###################################


zend-server classes, interfaces and traits that are not defined in version 2.6.0.

zend-server 2.6.0 has 22 classes, no traits and 4 interfaces;

  See also : `zend-server <https://github.com/zendframework/zend-server>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Server26    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-server-2.7.0-undefined-classes:

zend-server 2.7.0 Undefined Classes
###################################


zend-server classes, interfaces and traits that are not defined in version 2.7.0.

zend-server 2.7.0 has 22 classes, no traits and 4 interfaces;

  See also : `zend-server <https://github.com/zendframework/zend-server>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Server27    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-server-usage:

zend-server Usage
#################


zend-server usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-server has 22 classes, no traits and 4 interfaces;

See also : `zend-server <https://github.com/zendframework/zend-server>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Server      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-servicemanager-2.5.0-undefined-classes:

zend-servicemanager 2.5.0 Undefined Classes
###########################################


zend-servicemanager classes, interfaces and traits that are not defined in version 2.5.0.

zend-servicemanager 2.5.0 has 17 classes, 2 traits and 10 interfaces;

  See also : `zend-servicemanager <https://github.com/zendframework/zend-servicemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+---------------------------+
| Command Line | ZendF/Zf3Servicemanager25 |
+--------------+---------------------------+
| Analyzers    | :ref:`ZendFramework`      |
+--------------+---------------------------+


.. _zend-servicemanager-2.6.0-undefined-classes:

zend-servicemanager 2.6.0 Undefined Classes
###########################################


zend-servicemanager classes, interfaces and traits that are not defined in version 2.6.0.

zend-servicemanager 2.6.0 has 17 classes, 2 traits and 10 interfaces;

  See also : `zend-servicemanager <https://github.com/zendframework/zend-servicemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+---------------------------+
| Command Line | ZendF/Zf3Servicemanager26 |
+--------------+---------------------------+
| Analyzers    | :ref:`ZendFramework`      |
+--------------+---------------------------+


.. _zend-servicemanager-2.7.0-undefined-classes:

zend-servicemanager 2.7.0 Undefined Classes
###########################################


zend-servicemanager classes, interfaces and traits that are not defined in version 2.7.0.

zend-servicemanager 2.7.0 has 18 classes, 2 traits and 10 interfaces;

1 new classe 
.  See also : `zend-servicemanager <https://github.com/zendframework/zend-servicemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+---------------------------+
| Command Line | ZendF/Zf3Servicemanager27 |
+--------------+---------------------------+
| Analyzers    | :ref:`ZendFramework`      |
+--------------+---------------------------+


.. _zend-servicemanager-3.0.0-undefined-classes:

zend-servicemanager 3.0.0 Undefined Classes
###########################################


zend-servicemanager classes, interfaces and traits that are not defined in version 3.0.0.

zend-servicemanager 3.0.0 has 10 classes, no traits and 12 interfaces;

2 new classes 
. 10 removed classes 
, 2 removed traits 
. See also : `zend-servicemanager <https://github.com/zendframework/zend-servicemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+---------------------------+
| Command Line | ZendF/Zf3Servicemanager30 |
+--------------+---------------------------+
| Analyzers    | :ref:`ZendFramework`      |
+--------------+---------------------------+


.. _zend-servicemanager-3.1.0-undefined-classes:

zend-servicemanager 3.1.0 Undefined Classes
###########################################


zend-servicemanager classes, interfaces and traits that are not defined in version 3.1.0.

zend-servicemanager 3.1.0 has 11 classes, 1 traits and 12 interfaces;

1 new classe 
, 1 new trait 
.  See also : `zend-servicemanager <https://github.com/zendframework/zend-servicemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+---------------------------+
| Command Line | ZendF/Zf3Servicemanager31 |
+--------------+---------------------------+
| Analyzers    | :ref:`ZendFramework`      |
+--------------+---------------------------+


.. _zend-servicemanager-3.2.0-undefined-classes:

zend-servicemanager 3.2.0 Undefined Classes
###########################################


zend-servicemanager classes, interfaces and traits that are not defined in version 3.2.0.

zend-servicemanager 3.2.0 has 17 classes, 1 traits and 12 interfaces;

6 new classes 
.  See also : `zend-servicemanager <https://github.com/zendframework/zend-servicemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+---------------------------+
| Command Line | ZendF/Zf3Servicemanager32 |
+--------------+---------------------------+
| Analyzers    | :ref:`ZendFramework`      |
+--------------+---------------------------+


.. _zend-servicemanager-3.3.0-undefined-classes:

zend-servicemanager 3.3.0 Undefined Classes
###########################################


zend-servicemanager classes, interfaces and traits that are not defined in version 3.3.0.

zend-servicemanager 3.3.0 has 17 classes, 1 traits and 12 interfaces;

  See also : `zend-servicemanager <https://github.com/zendframework/zend-servicemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+---------------------------+
| Command Line | ZendF/Zf3Servicemanager33 |
+--------------+---------------------------+
| Analyzers    | :ref:`ZendFramework`      |
+--------------+---------------------------+


.. _zend-servicemanager-usage:

zend-servicemanager Usage
#########################


zend-servicemanager usage, based on classes, interfaces and traits. This covers all seven versions, from 2.5.0 to 3.3.0..

zend-servicemanager has 27 classes, 3 traits and 15 interfaces;

See also : `zend-servicemanager <https://github.com/zendframework/zend-servicemanager>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+-------------------------+
| Command Line | ZendF/Zf3Servicemanager |
+--------------+-------------------------+
| Analyzers    | :ref:`ZendFramework`    |
+--------------+-------------------------+


.. _zend-session-2.5.0-undefined-classes:

zend-session 2.5.0 Undefined Classes
####################################


zend-session classes, interfaces and traits that are not defined in version 2.5.0.

zend-session 2.5.0 has 26 classes, no traits and 7 interfaces;

  See also : `zend-session <https://github.com/zendframework/zend-session>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Session25   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-session-2.6.0-undefined-classes:

zend-session 2.6.0 Undefined Classes
####################################


zend-session classes, interfaces and traits that are not defined in version 2.6.0.

zend-session 2.6.0 has 27 classes, 1 traits and 7 interfaces;

2 new classes 
, 1 new trait 
. 1 removed classe 
. See also : `zend-session <https://github.com/zendframework/zend-session>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Session26   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-session-2.7.0-undefined-classes:

zend-session 2.7.0 Undefined Classes
####################################


zend-session classes, interfaces and traits that are not defined in version 2.7.0.

zend-session 2.7.0 has 31 classes, 1 traits and 7 interfaces;

6 new classes 
. 2 removed classes 
. See also : `zend-session <https://github.com/zendframework/zend-session>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Session27   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-session-usage:

zend-session Usage
##################


zend-session usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 2.7.0..

zend-session has 33 classes, 1 traits and 7 interfaces;

See also : `zend-session <https://github.com/zendframework/zend-session>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Session     |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-soap-2.5.0-undefined-classes:

zend-soap 2.5.0 Undefined Classes
#################################


zend-soap classes, interfaces and traits that are not defined in version 2.5.0.

zend-soap 2.5.0 has 20 classes, no traits and 3 interfaces;

  See also : `zend-soap <https://github.com/zendframework/zend-soap>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Soap25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-soap-2.6.0-undefined-classes:

zend-soap 2.6.0 Undefined Classes
#################################


zend-soap classes, interfaces and traits that are not defined in version 2.6.0.

zend-soap 2.6.0 has 20 classes, no traits and 3 interfaces;

  See also : `zend-soap <https://github.com/zendframework/zend-soap>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Soap26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-soap-usage:

zend-soap Usage
###############


zend-soap usage, based on classes, interfaces and traits. This covers all two versions 2.5.0 and 2.6.0.

zend-soap has 20 classes, no traits and 3 interfaces;

See also : `zend-soap <https://github.com/zendframework/zend-soap>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Soap        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-stdlib-2.5.0-undefined-classes:

zend-stdlib 2.5.0 Undefined Classes
###################################


zend-stdlib classes, interfaces and traits that are not defined in version 2.5.0.

zend-stdlib 2.5.0 has 65 classes, 5 traits and 26 interfaces;

  See also : `zend-stdlib <https://github.com/zendframework/zend-stdlib>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Stdlib25    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-stdlib-2.6.0-undefined-classes:

zend-stdlib 2.6.0 Undefined Classes
###################################


zend-stdlib classes, interfaces and traits that are not defined in version 2.6.0.

zend-stdlib 2.6.0 has 67 classes, 5 traits and 26 interfaces;

2 new classes 
.  See also : `zend-stdlib <https://github.com/zendframework/zend-stdlib>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Stdlib26    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-stdlib-2.7.0-undefined-classes:

zend-stdlib 2.7.0 Undefined Classes
###################################


zend-stdlib classes, interfaces and traits that are not defined in version 2.7.0.

zend-stdlib 2.7.0 has 68 classes, 5 traits and 26 interfaces;

1 new classe 
.  See also : `zend-stdlib <https://github.com/zendframework/zend-stdlib>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Stdlib27    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-stdlib-3.0.0-undefined-classes:

zend-stdlib 3.0.0 Undefined Classes
###################################


zend-stdlib classes, interfaces and traits that are not defined in version 3.0.0.

zend-stdlib 3.0.0 has 30 classes, 4 traits and 12 interfaces;

38 removed classes, 1 removed trait. 

See also : `zend-stdlib <https://github.com/zendframework/zend-stdlib>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Stdlib30    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-stdlib-3.1.0-undefined-classes:

zend-stdlib 3.1.0 Undefined Classes
###################################


zend-stdlib classes, interfaces and traits that are not defined in version 3.1.0.

zend-stdlib 3.1.0 has 31 classes, 4 traits and 12 interfaces;

1 new classe.  

See also : `zend-stdlib <https://github.com/zendframework/zend-stdlib>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Stdlib31    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-stdlib-usage:

zend-stdlib Usage
#################


zend-stdlib usage, based on classes, interfaces and traits. This covers all five versions, from 2.5.0 to 3.1.0..

zend-stdlib has 69 classes, 5 traits and 27 interfaces;

See also : `zend-stdlib <https://github.com/zendframework/zend-stdlib>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Stdlib      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-tag-2.5.0-undefined-classes:

zend-tag 2.5.0 Undefined Classes
################################


zend-tag classes, interfaces and traits that are not defined in version 2.5.0.

zend-tag 2.5.0 has 14 classes, no traits and 4 interfaces;

  See also : `zend-tag <https://github.com/zendframework/zend-tag>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Tag25       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-tag-2.6.0-undefined-classes:

zend-tag 2.6.0 Undefined Classes
################################


zend-tag classes, interfaces and traits that are not defined in version 2.6.0.

zend-tag 2.6.0 has 14 classes, no traits and 4 interfaces;

  See also : `zend-tag <https://github.com/zendframework/zend-tag>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Tag26       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-tag-usage:

zend-tag Usage
##############


zend-tag usage, based on classes, interfaces and traits. This covers all two versions 2.5.0 and 2.6.0.

zend-tag has 14 classes, no traits and 4 interfaces;

See also : `zend-tag <https://github.com/zendframework/zend-tag>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Tag         |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-test-2.5.0-undefined-classes:

zend-test 2.5.0 Undefined Classes
#################################


zend-test classes, interfaces and traits that are not defined in version 2.5.0.

zend-test 2.5.0 has 4 classes, no traits and no interfaces;

  See also : `zend-test <https://github.com/zendframework/zend-test>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------------------------+
| Command Line | ZendF/Zf3Test25                            |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`ZendFramework`, :ref:`ZendFramework` |
+--------------+--------------------------------------------+


.. _zend-test-2.6.0-undefined-classes:

zend-test 2.6.0 Undefined Classes
#################################


zend-test classes, interfaces and traits that are not defined in version 2.6.0.

zend-test 2.6.0 has 4 classes, no traits and no interfaces;

  See also : `zend-test <https://github.com/zendframework/zend-test>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------------------------+
| Command Line | ZendF/Zf3Test26                            |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`ZendFramework`, :ref:`ZendFramework` |
+--------------+--------------------------------------------+


.. _zend-test-3.0.0-undefined-classes:

zend-test 3.0.0 Undefined Classes
#################################


zend-test classes, interfaces and traits that are not defined in version 3.0.0.

zend-test 3.0.0 has 4 classes, no traits and no interfaces;

  See also : `zend-test <https://github.com/zendframework/zend-test>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------------------------+
| Command Line | ZendF/Zf3Test30                            |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`ZendFramework`, :ref:`ZendFramework` |
+--------------+--------------------------------------------+


.. _zend-test-usage:

zend-test Usage
###############


zend-test usage, based on classes, interfaces and traits. This covers all three versions, from 2.5.0 to 3.0.0..

zend-test has 4 classes, no traits and no interfaces;

See also : `zend-test <https://github.com/zendframework/zend-test>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+--------------------------------------------+
| Command Line | ZendF/Zf3Test                              |
+--------------+--------------------------------------------+
| Analyzers    | :ref:`ZendFramework`, :ref:`ZendFramework` |
+--------------+--------------------------------------------+


.. _zend-text-2.5.0-undefined-classes:

zend-text 2.5.0 Undefined Classes
#################################


zend-text classes, interfaces and traits that are not defined in version 2.5.0.

zend-text 2.5.0 has 22 classes, no traits and 4 interfaces;

  See also : `zend-text <https://github.com/zendframework/zend-text>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Text25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-text-2.6.0-undefined-classes:

zend-text 2.6.0 Undefined Classes
#################################


zend-text classes, interfaces and traits that are not defined in version 2.6.0.

zend-text 2.6.0 has 22 classes, no traits and 4 interfaces;

  See also : `zend-text <https://github.com/zendframework/zend-text>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Text26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-text-usage:

zend-text Usage
###############


zend-text usage, based on classes, interfaces and traits. This covers all two versions 2.5.0 and 2.6.0.

zend-text has 22 classes, no traits and 4 interfaces;

See also : `zend-text <https://github.com/zendframework/zend-text>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Text        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-uri:

zend-uri
########


zend-uri, all versions beyond 2.5.0.

+--------------+----------------------+
| Command Line | ZendF/Zf3Uri         |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-uri-2.5.x:

zend-uri 2.5.x
##############


zend-uri, all versions 2.5.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Uri25       |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-validator:

zend-validator
##############


zend-validator, all versions beyond 2.5.0.

+--------------+----------------------+
| Command Line | ZendF/Zf3Validator   |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-validator-2.6.x:

zend-validator 2.6.x
####################


zend-validator, all versions 2.6.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Validator26 |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-validator-2.7.x:

zend-validator 2.7.x
####################


zend-validator, all versions 2.7.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Validator27 |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-validator-2.8.x:

zend-validator 2.8.x
####################


zend-validator, all versions 2.8.x.

+--------------+----------------------+
| Command Line | ZendF/Zf3Validator28 |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-view-2.5.0-undefined-classes:

zend-view 2.5.0 Undefined Classes
#################################


zend-view classes, interfaces and traits that are not defined in version 2.5.0.

+--------------+----------------------+
| Command Line | ZendF/Zf3View25      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-view-2.6.0-undefined-classes:

zend-view 2.6.0 Undefined Classes
#################################


zend-view classes, interfaces and traits that are not defined in version 2.6.0.

+--------------+----------------------+
| Command Line | ZendF/Zf3View26      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-view-2.7.0-undefined-classes:

zend-view 2.7.0 Undefined Classes
#################################


zend-view classes, interfaces and traits that are not defined in version 2.7.0.
1 new trait

+--------------+----------------------+
| Command Line | ZendF/Zf3View27      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-view-2.8.0-undefined-classes:

zend-view 2.8.0 Undefined Classes
#################################


zend-view classes, interfaces and traits that are not defined in version 2.8.0.

+--------------+----------------------+
| Command Line | ZendF/Zf3View28      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-view-2.9.0-undefined-classes:

zend-view 2.9.0 Undefined Classes
#################################


zend-view classes, interfaces and traits that are not defined in version 2.9.0.
2 new classes

+--------------+----------------------+
| Command Line | ZendF/Zf3View29      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-view-usage:

zend-view Usage
###############


zend-view usage, based on classes, interfaces and traits. This covers all versions, from 2.5.0.

+--------------+----------------------+
| Command Line | ZendF/Zf3View        |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-xmlrpc-2.5.0-undefined-classes:

zend-xmlrpc 2.5.0 Undefined Classes
###################################


zend-xmlrpc classes, interfaces and traits that are not defined in version 2.5.0.

zend-xmlrpc 2.5.0 has 41 classes, no traits and 4 interfaces;

  See also : `zend-xmlrpc <https://github.com/zendframework/zend-xmlrpc>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Xmlrpc25    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-xmlrpc-2.6.0-undefined-classes:

zend-xmlrpc 2.6.0 Undefined Classes
###################################


zend-xmlrpc classes, interfaces and traits that are not defined in version 2.6.0.

zend-xmlrpc 2.6.0 has 41 classes, no traits and 4 interfaces;

  See also : `zend-xmlrpc <https://github.com/zendframework/zend-xmlrpc>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Xmlrpc26    |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


.. _zend-xmlrpc-usage:

zend-xmlrpc Usage
#################


zend-xmlrpc usage, based on classes, interfaces and traits. This covers all two versions 2.5.0 and 2.6.0.

zend-xmlrpc has 41 classes, no traits and 4 interfaces;

See also : `zend-xmlrpc <https://github.com/zendframework/zend-xmlrpc>`_ and `Zend Framework <https://framework.zend.com/>`_.

+--------------+----------------------+
| Command Line | ZendF/Zf3Xmlrpc      |
+--------------+----------------------+
| Analyzers    | :ref:`ZendFramework` |
+--------------+----------------------+


