<?php

namespace Jakmall\Recruitment\Calculator\Database;
use Jakmall\Recruitment\Calculator\Database\Infrastructure\DatabaseManagerInterface;
use Jakmall\Recruitment\Calculator\Database\Product;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\Setup;

//TODO: create implementation.
class DatabaseMysql implements DatabaseManagerInterface
{
    /**
     * Returns array of command history.
     *
     * @return array
     */
    public function getAll(): array {
    	$isDevMode = true;
		$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__), $isDevMode);
		// or if you prefer yaml or XML
		//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);
		//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);

		// database configuration parameters
		$conn = array(
		    'driver' => 'pdo_sqlite',
		    'path' => __DIR__ . '/db.sqlite',
		);

		// obtaining the entity manager
		$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);
		$product = new Product();
		$product->setName('awdawd');

		$entityManager->persist($product);
		$entityManager->flush();

		echo "Created Product with ID " . $product->getId() . "\n";



    	return [];
    }

}
