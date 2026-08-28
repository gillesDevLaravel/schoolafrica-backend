<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\Coefficient;
use App\Models\Matter;
use App\Models\Product;
use App\Models\School;
use App\Models\Section;
use App\Models\TypeEvaluation;
use App\Models\TypeInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Validation\DataValidation;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * @group Excel Templates
 */
class ExcelTemplateController extends BaseController
{
    /**
     * Nombre de lignes de données vides prégénérées dans le template
     */
    private const DATA_ROWS = 100;

    /**
     * Couleur de fond de la ligne des clés BD (ligne 1)
     */
    private const COLOR_KEY_ROW = 'D9E1F2';

    /**
     * Couleur de fond de la ligne des traductions (ligne 2)
     */
    private const COLOR_LABEL_ROW = 'BDD7EE';

    /**
     * Télécharger un template Excel pour l'importation
     *
     * @bodyParam type string required Le type d'entité : invoices ou ratings
     * @bodyParam idSchool int required L'ID de l'école (pour filtrer les listes déroulantes)
     * @bodyParam idSection int required L'ID de la section
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function downloadTemplate(Request $request)
    {
        $request->validate([
            'type'      => 'required|string|in:invoices,ratings',
            'idSchool'  => 'required|integer|exists:schools,id',
            'idSection' => 'required|integer|exists:section,id',
        ]);

        $type      = $request->input('type');
        $idSchool  = (int) $request->input('idSchool');
        $idSection = (int) $request->input('idSection');

        try {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()
                ->setCreator('MS School')
                ->setTitle("Template import - {$type}")
                ->setDescription("Template d'importation pour {$type}");

            // Feuille principale de données
            $dataSheet = $spreadsheet->getActiveSheet();
            $dataSheet->setTitle('Données');

            if ($type === 'invoices') {
                $this->buildInvoiceTemplate($dataSheet, $spreadsheet, $idSchool, $idSection);
                $filename = "template_factures_{$idSchool}.xlsx";
            } else {
                $this->buildRatingTemplate($dataSheet, $spreadsheet, $idSchool, $idSection);
                $filename = "template_notes_{$idSchool}.xlsx";
            }

            // Activer la feuille principale
            $spreadsheet->setActiveSheetIndex(0);

            $writer = new Xlsx($spreadsheet);

            return response()->streamDownload(function () use ($writer) {
                $writer->save('php://output');
            }, $filename, [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control'       => 'max-age=0',
            ]);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . ' in ' . $th->getFile() . ':' . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    // -------------------------------------------------------------------------
    //  INVOICE TEMPLATE
    // -------------------------------------------------------------------------

    private function buildInvoiceTemplate($sheet, Spreadsheet $spreadsheet, int $idSchool, int $idSection): void
    {
        // Définition des colonnes : [clé_bd => traduction_fr]
        $columns = [
            'amount'           => 'Montant',
            'reasons'          => 'Raison / Motif',
            'date'             => 'Date (AAAA-MM-JJ)',
            'payment_deadline' => 'Date limite de paiement',
            'statut'           => 'Statut',
            'mode'             => 'Mode de paiement',
            'typeUser'         => 'Type de bénéficiaire',
            'idUser'           => 'ID Bénéficiaire',
            'idTypeInvoice'    => 'Type de facture',
            'number'           => 'Numéro de facture',
            'idProduct'        => 'Produit',
            'type_produit'     => 'Type de produit',
            'quantite'         => 'Quantité',
            'prix_unitaire'    => 'Prix unitaire',
            'idSchool'         => 'École',
            'idSection'        => 'Section',
        ];

        // Listes déroulantes : valeurs statiques (énumérations)
        $staticDropdowns = [
            'statut'   => ['paid', 'unpaid'],
            'mode'     => ['espèces', 'chèque', 'virement', 'mobile_money', 'carte'],
            'typeUser' => ['customer', 'user'],
        ];

        // Listes déroulantes : données depuis la BD
        $dbDropdowns = [
            'idTypeInvoice' => TypeInvoice::where('school_id', $idSchool)->get()->map(function($r) { return $r->id . ' - ' . $r->name; })->toArray(),
            'idProduct'     => Product::all()->map(function($r) { return $r->id . ' - ' . $r->name; })->toArray(),
            'idSchool'      => School::all()->map(function($r) { return $r->id . ' - ' . $r->name; })->toArray(),
            'idSection'     => Section::where('idSchool', $idSchool)->get()->map(function($r) { return $r->id . ' - ' . $r->name; })->toArray(),
        ];

        $this->writeHeaders($sheet, $columns);
        $this->applyHeaderStyles($sheet, count($columns));

        $listsSheet = $this->createListsSheet($spreadsheet);
        $this->writeDropdownLists($listsSheet, array_merge($staticDropdowns, $dbDropdowns));
        $this->applyDropdownValidations($sheet, $columns, array_merge($staticDropdowns, $dbDropdowns), $listsSheet);

        $this->setColumnWidths($sheet, $columns);
    }

    // -------------------------------------------------------------------------
    //  RATING TEMPLATE
    // -------------------------------------------------------------------------

    private function buildRatingTemplate($sheet, Spreadsheet $spreadsheet, int $idSchool, int $idSection): void
    {
        $columns = [
            'idStudent'        => 'ID Étudiant',
            'idMatter'         => 'Matière',
            'idClasse'         => 'Classe',
            'idAssessment'     => 'Évaluation',
            'idAssessmentType' => "Type d'évaluation",
            'idTypeEvaluation' => 'Type évaluation',
            'value'            => 'Note',
            'observation'      => 'Observation',
            'idTeacher'        => 'ID Enseignant',
            'idCoeficient'     => 'Coefficient',
        ];

        $dbDropdowns = [
            'idMatter'         => Matter::where('idSchool', $idSchool)->where('idSection', $idSection)->get()->map(function($r) { return $r->id . ' - ' . $r->name; })->toArray(),
            'idClasse'         => Classes::where('idSchool', $idSchool)->where('idSection', $idSection)->get()->map(function($r) { return $r->id . ' - ' . $r->name; })->toArray(),
            'idAssessment'     => Assessment::where('idSchool', $idSchool)->where('idSection', $idSection)->get()->map(function($r) { return $r->id . ' - ' . ($r->libelle ?? ($r->date ?? 'éval ' . $r->id)); })->toArray(),
            'idAssessmentType' => AssessmentType::where('idSchool', $idSchool)->where('idSection', $idSection)->get()->map(function($r) { return $r->id . ' - ' . $r->name; })->toArray(),
            'idTypeEvaluation' => TypeEvaluation::where('idSchool', $idSchool)->where('idSection', $idSection)->get()->map(function($r) { return $r->id . ' - ' . $r->name; })->toArray(),
            'idCoeficient'     => Coefficient::where('idSchool', $idSchool)->where('idSection', $idSection)->get()->map(function($r) { return $r->id . ' - ' . $r->value; })->toArray(),
        ];

        $this->writeHeaders($sheet, $columns);
        $this->applyHeaderStyles($sheet, count($columns));

        $listsSheet = $this->createListsSheet($spreadsheet);
        $this->writeDropdownLists($listsSheet, $dbDropdowns);
        $this->applyDropdownValidations($sheet, $columns, $dbDropdowns, $listsSheet);

        $this->setColumnWidths($sheet, $columns);
    }

    // -------------------------------------------------------------------------
    //  HELPERS COMMUNS
    // -------------------------------------------------------------------------

    /**
     * Écrit les deux lignes d'en-tête :
     *   Ligne 1 → clés BD
     *   Ligne 2 → traductions françaises
     */
    private function writeHeaders($sheet, array $columns): void
    {
        $col = 1;
        foreach ($columns as $key => $label) {
            $sheet->setCellValueByColumnAndRow($col, 1, $key);
            $sheet->setCellValueByColumnAndRow($col, 2, $label);
            $col++;
        }

        // Figer les deux premières lignes
        $sheet->freezePane('A3');
    }

    /**
     * Applique les styles de mise en forme sur les deux lignes d'en-tête
     */
    private function applyHeaderStyles($sheet, int $colCount): void
    {
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);

        // Ligne 1 : clés BD
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => '1F3864'],
                'size'  => 10,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => self::COLOR_KEY_ROW],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Ligne 2 : traductions
        $sheet->getStyle("A2:{$lastCol}2")->applyFromArray([
            'font' => [
                'bold'   => true,
                'italic' => true,
                'color'  => ['rgb' => '1F3864'],
                'size'   => 10,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => self::COLOR_LABEL_ROW],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(2)->setRowHeight(20);
    }

    /**
     * Crée la feuille "Listes" cachée qui contiendra les valeurs des dropdowns
     */
    private function createListsSheet(Spreadsheet $spreadsheet)
    {
        $listsSheet = $spreadsheet->createSheet();
        $listsSheet->setTitle('Listes');
        $listsSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

        return $listsSheet;
    }

    /**
     * Écrit les listes de valeurs dans la feuille "Listes"
     * Chaque colonne correspond à un champ avec dropdown
     *
     * @return array<string, string> Map [fieldName => 'Listes!$A$1:$A$N']
     */
    private function writeDropdownLists($listsSheet, array $dropdowns): array
    {
        $colIndex = 1;
        $ranges   = [];

        foreach ($dropdowns as $field => $values) {
            // En-tête de colonne (nom du champ) sur la ligne 1
            $listsSheet->setCellValueByColumnAndRow($colIndex, 1, $field);

            $row = 2;
            foreach ($values as $value) {
                $listsSheet->setCellValueByColumnAndRow($colIndex, $row, $value);
                $row++;
            }

            $colLetter     = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $lastRow       = max(2, $row - 1);
            $ranges[$field] = "Listes!\${$colLetter}\$2:\${$colLetter}\${$lastRow}";

            $colIndex++;
        }

        return $ranges;
    }

    /**
     * Applique les validations déroulantes (DataValidation) sur les colonnes concernées
     * de la feuille de données, pour les lignes 3 à (3 + DATA_ROWS - 1)
     */
    private function applyDropdownValidations($sheet, array $columns, array $dropdowns, $listsSheet): void
    {
        // Recalculer les plages (colonnes et leur range dans "Listes")
        $listsColIndex = 1;
        $listsRanges   = [];
        foreach ($dropdowns as $field => $values) {
            $colLetter             = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($listsColIndex);
            $lastRow               = max(2, count($values) + 1);
            $listsRanges[$field]   = "Listes!\${$colLetter}\$2:\${$colLetter}\${$lastRow}";
            $listsColIndex++;
        }

        $colIndex = 1;
        foreach (array_keys($columns) as $field) {
            if (isset($listsRanges[$field])) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $startRow  = 3;
                $endRow    = 3 + self::DATA_ROWS - 1;

                for ($row = $startRow; $row <= $endRow; $row++) {
                    $validation = $sheet->getCell("{$colLetter}{$row}")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(true);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Valeur invalide');
                    $validation->setError('Veuillez choisir une valeur dans la liste.');
                    $validation->setPromptTitle($field);
                    $validation->setPrompt('Sélectionnez une valeur dans la liste.');
                    $validation->setFormula1($listsRanges[$field]);
                }
            }
            $colIndex++;
        }
    }

    /**
     * Définit la largeur des colonnes selon leur contenu
     */
    private function setColumnWidths($sheet, array $columns): void
    {
        $colIndex = 1;
        foreach ($columns as $key => $label) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $width     = max(strlen($key), strlen($label)) + 4;
            $sheet->getColumnDimension($colLetter)->setWidth($width);
            $colIndex++;
        }
    }
}
