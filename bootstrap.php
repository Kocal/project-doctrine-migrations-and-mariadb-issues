<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$paths = array(__DIR__."/src");

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

$cache = new \Doctrine\Common\Cache\ArrayCache();
$reader = new Doctrine\Common\Annotations\AnnotationReader();
$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver($reader, $paths);

$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);
$config->setMetadataDriverImpl($driver);

// database configuration parameters
$conn = \Symfony\Component\Yaml\Yaml::parseFile('config/doctrine.yml');

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
