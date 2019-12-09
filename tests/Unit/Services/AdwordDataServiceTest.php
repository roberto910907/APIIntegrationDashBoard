<?php

namespace Tests\Unit\Services;

use App\Models\Adwords\AdwordsData;
use App\Models\Adwords\Reports\AdwordsDataReport;
use App\Services\AdwordsDataService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdwordDataServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testSyncAdwordsData(): void
    {
        $adwordsDataReport = \Mockery::mock(AdwordsDataReport::class);
        $adwordsDataReport
            ->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('getDownloadData')
            ->once()
            ->andReturn($this->getStubData());

        /** @var AdwordsDataService $adwordsDataService */
        $adwordsDataService = app()->makeWith(AdwordsDataService::class, ['adwordsDataReport' => $adwordsDataReport]);
        $adwordsDataService->syncAdwordsData(18271620928);

        $adwordsDataRows = AdwordsData::all();

        $this->assertEquals(17, $adwordsDataRows->count());
    }

    private function getStubData(): string
    {
        return <<<STUB
2019-12-07,41262003517,352126282,267308841289,10,0,0
2019-12-06,77073316773,973730377,379098054209,3,0,0
2019-12-06,62587666234,352126282,296951783731,1,0,0
2019-12-06,80240630827,1974139369,379215893012,5,2,13280000
2019-12-07,68492264779,1690825401,347193520694,1,0,0
2019-12-06,67633864796,973730377,395102319780,3,0,0
2019-12-06,26087948722,352126282,267256624311,11,0,0
2019-12-07,69122188507,1690825401,342546205138,1,0,0
2019-12-06,67633864796,973730377,395102319780,8,0,0
2019-12-07,90087292968,1690825401,398376013432,1,0,0
2019-12-06,41262003517,352126282,267308841286,1,0,0
2019-12-06,79794317022,973730377,395102319822,4,0,0
2019-12-07,76644790268,350790322,339160103497,1,0,0
2019-12-06,53702869145,973730377,286687618519,1,1,5320000
2019-12-07,70018241429,1690825401,349349653563,5,1,1880000
2019-12-07,26087953642,352126282,267308859997,8,1,2960000
2019-12-06,26087952922,352126282,267256624236,1,1,3090000
STUB;
    }
}
