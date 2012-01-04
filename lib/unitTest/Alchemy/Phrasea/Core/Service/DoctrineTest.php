<?php

/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2010 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__ . '/../../../../PhraseanetPHPUnitAuthenticatedAbstract.class.inc';

use Alchemy\Phrasea\Core\Service\Doctrine;
use Symfony\Component\Yaml\Yaml;
use Alchemy\Phrasea\Core as PhraseaCore;
use Alchemy\Phrasea\Core\Configuration;

/**
 *
 * @package
 * @license     http://opensource.org/licenses/gpl-3.0 GPLv3
 * @link        www.phraseanet.com
 */
class DoctrineTest extends PhraseanetPHPUnitAuthenticatedAbstract
{

  /**
   *
   * @var \Alchemy\Phrasea\Core\Configuration\Application 
   */
  public function setUp()
  {
    parent::setUp();
  }

  public function tearDown()
  {
    parent::tearDown();
  }

  public function testInitialize()
  {
    try
    {
      $spec = $this->getMock(
              '\Alchemy\Phrasea\Core\Configuration\Application'
              , array('getConfigurationFile')
      );

      $fileName = __DIR__ . '/../Configuration/confTestFiles/good.yml';

      $spec->expects($this->any())
              ->method('getConfigurationFile')
              ->will(
                      $this->returnValue(
                              new SplFileObject($fileName)
                      )
      );

      $handler = new Configuration\Handler($spec, new Configuration\Parser\Yaml());

      $configuration = new PhraseaCore\Configuration($handler);
      $configuration->setEnvironnement('prod');

      $doctrineService = new Doctrine($configuration->getDoctrine()->all());
    }
    catch (Exception $e)
    {
      $this->fail($e->getMessage());
    }
  }

  public function testNoDbalConf()
  {
    try
    {
      $doctrineService = new Doctrine();
      $this->fail("should raised an exception");
    }
    catch (\Exception $e)
    {
      
    }
  }

  public function testGetVersion()
  {
    $spec = $this->getMock(
            '\Alchemy\Phrasea\Core\Configuration\Application'
            , array('getConfigurationFile')
    );

    $fileName = __DIR__ . '/../Configuration/confTestFiles/good.yml';

    $spec->expects($this->any())
            ->method('getConfigurationFile')
            ->will(
                    $this->returnValue(
                            new SplFileObject($fileName)
                    )
    );

    $handler = new Configuration\Handler($spec, new Configuration\Parser\Yaml());

    $configuration = new PhraseaCore\Configuration($handler);
    $configuration->setEnvironnement('prod');

    $doctrineService = new Doctrine($configuration->getDoctrine()->all());
    $this->assertTrue(is_string($doctrineService->getVersion()));
  }

  public function testGetEntityManager()
  {
    $spec = $this->getMock(
            '\Alchemy\Phrasea\Core\Configuration\Application'
            , array('getConfigurationFile')
    );

    $fileName = __DIR__ . '/../Configuration/confTestFiles/good.yml';

    $spec->expects($this->any())
            ->method('getConfigurationFile')
            ->will(
                    $this->returnValue(
                            new SplFileObject($fileName)
                    )
    );

    $handler = new Configuration\Handler($spec, new Configuration\Parser\Yaml());

    $configuration = new PhraseaCore\Configuration($handler);
    $configuration->setEnvironnement('prod');

    $doctrineService = new Doctrine($configuration->getDoctrine()->all());
    $this->assertInstanceOf('\Doctrine\ORM\EntityManager', $doctrineService->getEntityManager());
  }

}