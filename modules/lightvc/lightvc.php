<?php
/**
 * LightVC - A lightweight view-controller framework.
 * http://lightvc.org/
 * 
 * You provide your own model/ORM. We recommend Cough <http://coughphp.com>.
 * 
 * The purpose of this framework is to provide just a "view-controller"
 * setup without all the other junk. Ideally, the classes from other frameworks
 * should be reusable but instead they are mostly coupled with their frameworks.
 * It's up to you to go get those classes if you need them, or provide your own.
 * 
 * Additionally, we've decoupled it from any sort of Model so that you can use
 * the one you already know and love. And if you don't know one, now is a great
 * time to check out CoughPHP. Other ORMs can be found at:
 * 
 * http://en.wikipedia.org/wiki/List_of_object-relational_mapping_software#PHP
 * 
 * By providing just the VC, we increase the reusability of not only the
 * framework itself, but non-framework components as well.
 * 
 * The framework is fast. Currently the speed of this framework is unmatched by
 * any other PHP framework available today.
 * 
 * You get to use the classes you've already been using without worrying about
 * naming conflicts or inefficiencies from loading both your classes and the
 * classes from some other framework.
 * 
 * LightVC aims to be easier to use, more configurable, and light in footprint.
 * 
 * @author Anthony Bush
 * @version 1.0.4 (2008-03-15)
 * @package lightvc
 * @see http://lightvc.org/
 **/

include 'Lvc_Config.class.php';
include 'Lvc_Exception.class.php';
include 'Lvc_Request.class.php';
include 'Lvc_HttpRequest.class.php';
include 'Lvc_RouterInterface.class.php';
include 'Lvc_GetRouter.class.php';
include 'Lvc_RewriteRouter.class.php';
include 'Lvc_RegexRewriteRouter.class.php';
include 'Lvc_FrontController.class.php';
include 'Lvc_PageController.class.php';
include 'Lvc_View.class.php';
