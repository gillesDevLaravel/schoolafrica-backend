<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Storage;

class PDFService
{
    public function generatePDF($pensionUser, $viewName)
    {
        try {
            ini_set('max_execution_time', 300);
            if (!isset($pensionUser['created_at'], $pensionUser['student'], $pensionUser['tranche'], $pensionUser['payment_mode'], $pensionUser['advancePayment'], $pensionUser['balancePayment'])) {
                throw new ServiceException('Invalid or incomplete pension user data');
            }
            // Formatage des données pour le PDF
            $formattedData = [
                'school' => $pensionUser['school']['name'],
                'date' => $pensionUser['created_at'],
                'student' => $pensionUser['student']['name'],
                'matricule' => $pensionUser['student']['matricule'] ?? null,
                'classroom' => $pensionUser['student']['classe']['name'],
                'imagePath' => 'public/profil/'.$pensionUser['school']['logo'],
                'pensionsDetails' => [
                    [
                        'pension' => 'Tranche ' . $pensionUser['tranche']['name'],
                        'date_limit' => date('Y-m-d', strtotime($pensionUser['tranche']['deadline'])),
                        'payment_mode' => $pensionUser['payment_mode'],
                        'price' => $pensionUser['tranche']['price'],
                        'amount' => $pensionUser['advancePayment'],
                        'reste' => $pensionUser['balancePayment']
                    ]
                ],
                'total_boarding' => $pensionUser['pension']['price'],
                'total_paid' => $pensionUser['advancePayment'],
                'reste' => $pensionUser['balancePayment']
            ];

            // Génération du PDF
            $html = View::make($viewName, $formattedData)->render();

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Enregistrement du PDF
            $directory = 'temp';
            Storage::makeDirectory($directory);
            $filePath = storage_path('app/temp/receipt.pdf');
            file_put_contents($filePath, $dompdf->output());

            return $filePath;
        } catch (\Throwable $th) {
            throw new ServiceException('Error Service generatePDF ' . $th->getMessage());
        }
    }

    public function generateFeePDF($feeUser, $viewName)
    {
        try {
            ini_set('max_execution_time', 300);
            if (!isset($feeUser['created_at'], $feeUser['student'], $feeUser['payment_mode'], $feeUser['advancePayment'], $feeUser['balancePayment'])) {
                throw new ServiceException('Invalid or incomplete fee user data');
            }
            // Formatage des données pour le PDF
            $formattedData = [
                'school' => $feeUser['school']['name'],
                'date' => $feeUser['created_at']->format('Y-m-d'),
                'student' => $feeUser['student']['name'],
                'matricule' => $feeUser['student']['matricule'] ?? null,
                'classroom' => $feeUser['student']['classe']['name'],
                'imagePath' => 'public/profil/'.$feeUser['school']['logo'],
                'feeDetails' => [
                    [
                        'fee' => $feeUser['fee']['name'],
                        'date_limit' => date('Y-m-d', strtotime($feeUser['fee']['deadline'])),
                        'payment_mode' => $feeUser['payment_mode'],
                        'price' => $feeUser['fee']['price'],
                        'amount' => $feeUser['advancePayment'],
                        'reste' => $feeUser['balancePayment']
                    ]
                ],
                'total_boarding' => $feeUser['fee']['price'],
                'total_paid' => $feeUser['advancePayment'],
                'reste' => $feeUser['balancePayment']
            ];

            // Génération du PDF
            $html = View::make($viewName, $formattedData)->render();

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Enregistrement du PDF
            $directory = 'temp';
            Storage::makeDirectory($directory);
            $filePath = storage_path('app/temp/receipt.pdf');
            file_put_contents($filePath, $dompdf->output());

            return $filePath;
        } catch (\Throwable $th) {
            throw new ServiceException('Error Service generatePDF ' . $th->getMessage());
        }
    }

    public function generatePDFFromArrayOfObjects($data, $viewName)
    {
        try {
            ini_set('max_execution_time', 300);
            if (!is_array($data) && !is_iterable($data)) {
                throw new ServiceException('Invalid data format. Expected array or iterable object.');
            }
            // Formatage des données pour le PDF
            $formattedData = [];
            foreach ($data as $item) {
                $formattedData['data'][] = $this->formatSingleData($item);
            }
            //return  $formattedData['data'][0]['student'];

            // Création du contenu HTML pour le PDF
            $view = View::make($viewName)->with('data', $formattedData);
            $html = $view->render();

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);

            // Génération du PDF
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Sauvegarde du PDF
            $directory = 'temp';
            Storage::makeDirectory($directory);
            $pdfContent = $dompdf->output();
            $filePath = storage_path('app/temp/receipt.pdf');
            file_put_contents($filePath, $pdfContent);

            return $filePath;
        } catch (\Throwable $th) {
            throw new ServiceException('Error Service generatePDFFromArrayOfObjects '. $th->getMessage());
        }
    }

    private function formatSingleData($data)
    {
        // Formater les données pour le cas où data est un objet
        return [
            'school' => $data->school->name,
            'date' => $data->created_at,
            'student' => $data->student->name,
            'matricule' => $data->student->matricule ?? null,
            'classroom' => $data->student->classe->name,
            'imagePath' => 'public/profil/'.$data->school->logo,
            'pensionsDetails' => [
                [
                    'pension' => 'Tranche ' . $data->tranche->name,
                    'date_limit' => date('Y-m-d', strtotime($data->tranche->deadline)),
                    'payment_mode' => $data->payment_mode,
                    'price' => $data->tranche->price,
                    'amount' => $data->advancePayment,
                    'reste' => $data->balancePayment
                ]
            ],
            'total_boarding' => $data->pension->price,
            'total_paid' => $data->advancePayment,
            'reste' => $data->balancePayment
        ];
    }

    public function generateFee2PDF($feeUser, $viewName)
    {
        try {
            ini_set('max_execution_time', 300);

            if (!isset($feeUser['FeePaye']['created_at'], $feeUser['FeePaye']['student'], $feeUser['FeePaye']['payment_mode'], $feeUser['FeePaye']['advancePayment'], $feeUser['FeePaye']['balancePayment'])) {
                throw new ServiceException('Invalid or incomplete fee user data');
            }
            // Formatage des données pour le PDF
            $formattedData = [
                'school' => $feeUser['FeePaye']['school']['name'],
                'date' => $feeUser['FeePaye']['created_at'],
                'student' => $feeUser['FeePaye']['student']['name'],
                'matricule' => $feeUser['FeePaye']['student']['matricule'] ?? null,
                'classroom' => $feeUser['FeePaye']['student']['classe']['name'],
                'imagePath' => 'public/profil/'.$feeUser['FeePaye']['school']['logo'],
                'feeDetails' => [
                    [
                        'fee' => $feeUser['FeePaye']['fee']['name'],
                        'date_limit' => $feeUser['FeePaye']['fee']['deadline'],
                        'payment_mode' => $feeUser['FeePaye']['payment_mode'],
                        'price' => $feeUser['FeePaye']['fee']['price'],
                        'amount' => $feeUser['FeePaye']['advancePayment'],
                        'reste' => $feeUser['FeePaye']['balancePayment']
                    ]
                ],
                'total_boarding' => $feeUser['FeePaye']['fee']['price'],
                'total_paid' => $feeUser['FeePaye']['advancePayment'],
                'reste' => $feeUser['FeePaye']['balancePayment']
            ];


            // Génération du PDF
            $html = View::make($viewName, $formattedData)->render();

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Enregistrement du PDF
            $directory = 'temp';
            Storage::makeDirectory($directory);
            $filePath = storage_path('app/temp/receipt.pdf');
            file_put_contents($filePath, $dompdf->output());

            return $filePath;
        } catch (\Throwable $th) {
            throw new ServiceException('Error Service generatePDF ' . $th->getMessage());
        }
    }




}

