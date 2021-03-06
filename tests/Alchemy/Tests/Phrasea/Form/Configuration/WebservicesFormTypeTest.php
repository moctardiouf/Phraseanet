<?php

namespace Alchemy\Tests\Phrasea\Form\Configuration;

use Alchemy\Phrasea\Form\Configuration\WebservicesFormType;
use Alchemy\Tests\Phrasea\Form\FormTestCase;

/**
 * @group functional
 * @group legacy
 */
class WebservicesFormTypeTest extends FormTestCase
{
    public function getForm()
    {
        return new WebservicesFormType(self::$DI['app']['translator']);
    }
}
