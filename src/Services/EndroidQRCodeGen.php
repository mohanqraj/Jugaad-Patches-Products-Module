<?php

namespace Drupal\product_page\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
// use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
// use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class EndroidQRCodeGen
{
    
    public function generateQrCode(string $scancode)
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($scancode)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            // ->logoPath(__DIR__.'\assets\symfony.png')
            // ->labelText('This is the label')
            // ->labelFont(new NotoSans(20))
            // ->labelAlignment(new LabelAlignmentCenter())
            ->validateResult(false)
            ->build();
        $dataUri = $result->getDataUri();
        return $dataUri;
    }
}

