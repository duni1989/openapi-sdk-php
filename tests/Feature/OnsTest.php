<?php

namespace AlibabaCloud\Tests\Feature;

use AlibabaCloud\Ons\Ons;
use PHPUnit\Framework\TestCase;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Ons\V20170918\OnsRegionList;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Exception\ClientException;

/**
 * Class OnsTest
 *
 * @package   AlibabaCloud\Tests\Feature
 */
class OnsTest extends TestCase
{
    /**
     * @throws ClientException
     */
    public function setUp()
    {
        parent::setUp();

        AlibabaCloud::accessKeyClient(
            \getenv('ACCESS_KEY_ID'),
            \getenv('ACCESS_KEY_SECRET')
        )->regionId('cn-hangzhou')->asDefaultClient();
    }

    public function testVersionResolve()
    {
        $request1 = AlibabaCloud::ons()
                                ->v20170918()
                                ->onsRegionList()
                                ->connectTimeout(60)
                                ->timeout(65);

        $request2 = Ons::v20170918()
                       ->onsRegionList()
                       ->connectTimeout(60)
                       ->timeout(65);

        self::assertInstanceOf(OnsRegionList::class, $request1);
        self::assertInstanceOf(OnsRegionList::class, $request2);
        self::assertEquals($request1, $request2);
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testOns()
    {
        $result = Ons::v20170918()
                     ->onsRegionList()
                     ->withOnsRegionId('cn-hangzhou')
                     ->withPreventCache('20190101121212111')
                     ->connectTimeout(60)
                     ->timeout(65)
                     ->request();

        self::assertArrayHasKey('Data', $result);
    }
}
