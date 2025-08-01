<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Repositories\ProductRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;

class ExportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $fileName
    ) {
    }

    public function handle(ProductRepository $repository): void
    {
        $disk = Storage::disk('local');
        $directory = 'exports';
        $path = $directory . '/' . $this->fileName;

        if (!$disk->exists($directory)) {
            $disk->makeDirectory($directory);
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'export_') . '.xlsx';

        $writer = new Writer();
        $writer->openToFile($tempPath);

        $headerStyle = (new Style())
            ->setFontBold()
            ->setFontSize(12)
            ->setFontColor(Color::BLACK)
            ->setBackgroundColor(Color::rgb(240, 240, 240))
            ->setCellAlignment(CellAlignment::CENTER);

        $headers = ['Название товара', 'Штрихкод', 'Цена', 'Название категории'];
        $writer->addRow(Row::fromValues($headers, $headerStyle));

        $rowStyle = (new Style())
            ->setCellAlignment(CellAlignment::LEFT)
            ->setFontSize(11);

        $products = $repository->getForExport();

        foreach ($products as $product) {
            $writer->addRow(Row::fromValues([
                $product['name'],
                $product['barcode'],
                number_format($product['price'], 2),
                $product['category'],
            ], $rowStyle));
        }

        $writer->close();

        $stream = fopen($tempPath, 'r');
        $disk->put($path, stream_get_contents($stream));
        fclose($stream);

        unlink($tempPath);
    }
}
