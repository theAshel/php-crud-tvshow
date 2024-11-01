<?php
namespace Tests\Crud;

use Entity\TVShow;
use Tests\CrudTester;
class TVShowCest
{
    public function delete(CrudTester $I): void
    {
        $tvShow = TVShow::findById(3);
        $tvShow->delete();
        $I->cantSeeInDatabase('tvshow', ['id' => 3]);
        $I->cantSeeInDatabase('tvshow', ['name' => 'Friends']);
        $I->assertNull($tvShow->getId());
        $I->assertSame('Friends', $tvShow->getName());
    }

    public function update(CrudTester $I): void
    {
        $tvShow = TVShow::findById(25);
        $tvShow->setName('Futubaba');
        $tvShow->setOriginalName('Futubaba');
        $tvShow->setHomepage('http://futubaba.com');
        $tvShow->setOverview('Histoire de Futubaba');
        $tvShow->save();
        $I->canSeeNumRecords(1, 'tvshow', [
            'id' => 25,
            'name' => 'Futubaba',
            'originalName' => 'Futubaba',
            'homepage' => 'http://futubaba.com',
            'overview' => 'Histoire de Futubaba'
        ]);
        $I->assertSame(25, $tvShow->getId());
        $I->assertSame('Futubaba', $tvShow->getName());
        $I->assertSame('Futubaba', $tvShow->getOriginalName());
        $I->assertSame('http://futubaba.com', $tvShow->getHomepage());
        $I->assertSame('Histoire de Futubaba', $tvShow->getOverview());
    }
}
