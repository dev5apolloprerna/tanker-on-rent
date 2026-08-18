<?php

namespace App\Exports;

use App\Models\Customer;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Mirrors resources/views/admin/orders/monthly_pdf.blade.php row for row,
 * so the Excel download always matches what the PDF shows.
 */
class MonthlyOrdersExport implements FromArray, WithStyles, WithEvents, ShouldAutoSize, WithTitle
{
    protected array $reportRows;
    protected float $grandTotal;
    protected float $grandPaid;
    protected float $grandDiscount;
    protected float $grandUnpaid;
    protected Carbon $generatedAt;
    protected ?Customer $pdfCustomer;

    /** Row numbers we need after building the sheet, for styling/merges. */
    protected int $headingRow = 5;
    protected int $lastDataRow = 5;

    public function __construct(
        array $reportRows,
        float $grandTotal,
        float $grandPaid,
        float $grandDiscount,
        float $grandUnpaid,
        Carbon $generatedAt,
        ?Customer $pdfCustomer = null
    ) {
        $this->reportRows   = $reportRows;
        $this->grandTotal   = $grandTotal;
        $this->grandPaid    = $grandPaid;
        $this->grandDiscount = $grandDiscount;
        $this->grandUnpaid  = $grandUnpaid;
        $this->generatedAt  = $generatedAt;
        $this->pdfCustomer  = $pdfCustomer;
    }

    public function title(): string
    {
        return 'Monthly Orders';
    }

    public function array(): array
    {
        $firstOrder     = $this->reportRows[0]['order'] ?? null;
        $customerName   = $this->pdfCustomer->customer_name ?? ($firstOrder->customer->customer_name ?? 'All Customers');
        $customerMobile = $this->pdfCustomer->customer_mobile ?? ($firstOrder->customer->customer_mobile ?? '');

        $rows = [];
        $rows[] = ['સુવિધા વોટર સપ્લાયર્સ'];
        $rows[] = [$customerName . ($customerMobile ? ' (MO. ' . $customerMobile . ')' : '')];
        $rows[] = ['Generated: ' . $this->generatedAt->format('d-m-Y h:i A')];
        $rows[] = []; // spacer

        // Heading row (row 5)
        $rows[] = ['Tanker', 'Tanker Name', 'Installment Date', 'Tanker No', 'Months', 'Rent', 'Total Rent', 'Tanker Status'];
        $this->headingRow = count($rows);

        if (empty($this->reportRows)) {
            $rows[] = ['No monthly orders found.'];
        }

        foreach ($this->reportRows as $i => $row) {
            $order    = $row['order'];
            $snap     = $row['snap'];
            $schedule = $row['schedule'];

            $status = (int) $order->isReceive === 0 ? 'ટેન્કર મળી ગઈ' : 'ટેન્કર નથી મળી';

            $rows[] = [
                'Tanker.' . ($i + 1),
                $order->tanker->tanker_name ?? '-',
                $schedule[0] ?? '-',
                $order->tanker->tanker_code ?? '-',
                (int) $snap['months'],
                (float) $snap['base'],
                (float) $snap['total_due'],
                $status,
            ];

            // Remaining installment dates, one per row, same as the PDF
            foreach (array_slice($schedule, 1) as $date) {
                $rows[] = ['', '', $date, '', '', '', '', ''];
            }
        }

        $this->lastDataRow = count($rows);

        // Summary block, same 4 figures shown under the PDF table
        $rows[] = []; // spacer
        $rows[] = ['Total Amount', (float) $this->grandTotal];
        $rows[] = ['Paid Amount', (float) $this->grandPaid];
        $rows[] = ['Discount Amount', (float) $this->grandDiscount];
        $rows[] = ['Needed Amount', (float) $this->grandUnpaid];

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFont()->setItalic(true)->setSize(9);

        $headingRange = 'A' . $this->headingRow . ':H' . $this->headingRow;
        $sheet->getStyle($headingRange)->getFont()->setBold(true);
        $sheet->getStyle($headingRange)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('F1F1F1');

        $summaryStart = $this->lastDataRow + 2;
        $summaryEnd   = $summaryStart + 3;
        $sheet->getStyle('A' . $summaryStart . ':A' . $summaryEnd)->getFont()->setBold(true);
        $sheet->getStyle('B' . $summaryStart . ':B' . $summaryEnd)->getFont()->setBold(true);
        $sheet->getStyle('B' . $summaryStart . ':B' . $summaryEnd)
            ->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('F' . ($this->headingRow + 1) . ':G' . $this->lastDataRow)
            ->getNumberFormat()->setFormatCode('#,##0.00');

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');
                $sheet->mergeCells('A3:H3');
                $sheet->getStyle('A1:A3')->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
