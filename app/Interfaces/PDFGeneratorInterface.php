<?php

namespace App\Interfaces;

interface PDFGeneratorInterface{
    /**
     * Fonction qui sera
     * @param array $ids
     * @return String
     */
    function generatePDFs(array $ids) : String;
}
