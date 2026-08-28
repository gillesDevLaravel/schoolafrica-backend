<?php

namespace Tests\Unit\SingleUnits;

use Illuminate\Support\Facades\App;
use Tests\TestCase;

class HelperTest extends TestCase
{
    public function testCanGenerateStudentRankFR()
    {
        $rang = 1;

        $studentRank = getStudentRankFR($rang);

        $this->assertEquals("$rang<sup>er</sup>", $studentRank);
    }

    public function testCanGenerateStudentRankENFirst()
    {
        App::setLocale('en');

        $rang = 1;

        $studentRank = getStudentRankEN($rang);

        $this->assertEquals("$rang<sup>st</sup>", $studentRank);
    }
    public function testCanGenerateStudentRankENSecond()
    {
        App::setLocale('en');

        $rang = 2;

        $studentRank = getStudentRankEN($rang);

        $this->assertEquals("$rang<sup>nd</sup>", $studentRank);
    }
    public function testCanGenerateStudentRankENThird()
    {
        App::setLocale('en');

        $rang = 3;

        $studentRank = getStudentRankEN($rang);

        $this->assertEquals("$rang<sup>rd</sup>", $studentRank);
    }
    public function testCanGenerateStudentRankENOtherCase()
    {
        App::setLocale('en');

        $rang = rand(1, 999); //TODO: faire des if else if ou switch pour les différents cas: les nbres finissant par 1 (921st), par 2 (32nd) ou 3(453rd), ou les autres (744th)

        $studentRank = getStudentRankEN($rang);

        switch ($rang % 10){
            case 1:
                $supVal = "st";
                break;
            case 2:
                $supVal = "nd";
                break;
            case 3:
                $supVal = "rd";
                break;
            default:
                $supVal = "th";  // default value
                break;
        }

        $this->assertEquals("$rang<sup>$supVal</sup>", $studentRank);
    }

    public function testCanGenerateStudentRank()
    {
        $rang = rand(1, 999);

        $studentRank = getStudentRank($rang);

        switch ($rang % 10){
            case 1:
                $supVal = "er";
                break;
            default:
                $supVal = "e";
        }

        $this->assertEquals("$rang<sup>$supVal</sup>", $studentRank);
    }
}
