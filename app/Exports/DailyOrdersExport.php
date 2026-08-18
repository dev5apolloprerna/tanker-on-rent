<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DailyOrdersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $rows;
    protected $totals;

    /**
     * @param \Illuminate\Support\Collection $rows   DailyOrder rows already annotated with calc_* fields
     * @param array $totals                          Column totals, e.g. ['extra'=>.., 'grand'=>.., 'paid'=>.., 'due'=>.., 'days'=>..]
     */
    public function __construct($rows, array $totals = [])
    {
        $this->rows   = $rows;
        $this->totals = $totals;
    }

    public function collection()
    {
        return collect($this->rows);
    }

    public function title(): string
    {
        return 'Daily Orders';
    }

    public function headings(): array
    {
        return [
            'Order #',
            'Date',
            'Customer',
            'Type',
            'Mobile',
            'Received',
            'Days',
            'Extra Rent',
            'Total',
            'Paid',
            'Due',
        ];
    }

    public function map($r): array
    {
        return [
            $r->daily_order_id,
            $r->rent_date ? Carbon::parse($r->rent_date)->format('d-m-Y') : '',
            $r->customer_name,
            ((int) $r->customer_id === 0) ? 'Retail' : 'Recurring',
            $r->mobile,
            $r->received_at ? Carbon::parse($r->received_at)->format('d-m-Y') : 'Not Received',
            (int) ($r->calc_days ?? 0),
            (float) ($r->calc_extra ?? 0),
            (float) ($r->calc_grand ?? 0),
            (float) ($r->calc_paid ?? 0),
            (float) ($r->calc_due ?? 0),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Bold header row
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);

        // Append a Totals row under the data, if totals were supplied
        if (!empty($this->totals)) {
            $lastRow = $this->rows->count() + 2; // +1 header, +1 to move to next row
            $sheet->setCellValue('A' . $lastRow, 'Totals');
            $sheet->mergeCells('A' . $lastRow . ':G' . $lastRow);
            $sheet->setCellValue('H' . $lastRow, (float) ($this->totals['extra'] ?? 0));
            $sheet->setCellValue('I' . $lastRow, (float) ($this->totals['grand'] ?? 0));
            $sheet->setCellValue('J' . $lastRow, (float) ($this->totals['paid'] ?? 0));
            $sheet->setCellValue('K' . $lastRow, (float) ($this->totals['due'] ?? 0));
            $sheet->getStyle('A' . $lastRow . ':K' . $lastRow)->getFont()->setBold(true);
        }

        return [];
    }
}
