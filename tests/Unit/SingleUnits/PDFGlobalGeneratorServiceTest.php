<?php

namespace Tests\Unit\SingleUnits;

use App\Services\PDFGlobalGeneratorService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class PDFGlobalGeneratorServiceTest extends TestCase
{
    use WithFaker;

    public function testCanGenerateSamplePDFFile(){
        $pdfGlobalGenerator = new PDFGlobalGeneratorService();

        $data = [
            'name' => $this->faker->word()
        ];

        $pdf = $pdfGlobalGenerator->generatePDF("welcome_mod", $data, "test-single");

        // On vérifie que le fichier PDF est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(pdf)$/',
            $pdf
        );
    }

    public function testCannotGenerateWithUnexistingView(){
        $pdfGlobalGenerator = new PDFGlobalGeneratorService();

        $data = [
            'name' => $this->faker->word()
        ];

        $pdf = $pdfGlobalGenerator->generatePDF("vue_inexistante", $data, "test-single");

        // On vérifie que l'exception est levée et que le message retourné est celui attendu
        $this->assertEquals("View vue_inexistante does not exist", $pdf);
    }

    public function testCanGenerateSampleZIPFile(){
        $pdfGlobalGenerator = new PDFGlobalGeneratorService();

        $pdfs = [];
        // on va générer un nombre aléatoire de docs,
        for ($n=0; $n<rand(2,50); $n++){

            $filename = Str::slug($this->faker->text(30));

            $data = [
                'name' => $filename,
            ];

            $tmp_pdffile = $pdfGlobalGenerator->generatePDF("welcome_mod", $data, $filename);
            $pdfs[] = [
                'name' => $filename,
                'link' => $tmp_pdffile,
            ];

            $this->assertMatchesRegularExpression(
                '/^https?:\/\/.+\.(pdf)$/',
                $tmp_pdffile
            );
        }

        // on va générer le zip de ces pdfs

        $zipfile = $pdfGlobalGenerator->generateZIP($pdfs, "zip_test_file");

        // On vérifie que le fichier ZIP est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(zip)$/',
            $zipfile
        );
    }

    public function testCannotGenerateZIPFileFromEmptyPDFsArray(){
        $pdfGlobalGenerator = new PDFGlobalGeneratorService();

        $pdfs = [];

        // on va générer le zip de ces pdfs

        $zipfile = $pdfGlobalGenerator->generateZIP($pdfs, "zip_test_file.zip");

        // On vérifie que l'exception est levée et que le message retourné est celui attendu
        $this->assertEquals("Cannot generate empty ZIP file", $zipfile);
    }
}
