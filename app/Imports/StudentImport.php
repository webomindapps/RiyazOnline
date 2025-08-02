<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\Course;
use App\Models\State;
use App\Models\StudentCourseDetail;
use App\Models\StudentDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements SkipsEmptyRows, ToModel, WithHeadingRow, SkipsOnFailure, WithValidation, WithBatchInserts, WithChunkReading, WithUpserts
{
    use SkipsFailures;
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        $country = Country::where('name', $row['country'])->first();
        $state = State::where('name', $row['state'])->first();
        $data = [];
        $data['f_name'] = $row['first_name'];
        $data['l_name'] = $row['last_name'];
        $data['email'] = $row['email'];
        $data['gender'] = $row['gender'] == "Male" ? 0 : 1;
        $data['age'] = $row['age'];
        // $data['dob'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth']);
        $data['phone'] = $row['contact'];
        $data['phone_2'] = $row['alternate_contact'];
        $data['country_id'] = $country?->id;
        $data['state_id'] = $state?->id;
        $data['city'] = $row['city'];
        $data['date'] = date("Y-m-d");
        $data['date_joining'] = date("Y-m-d");
        $data['latest_paid_date'] = date("Y-m-d");
        $data['status'] = 2;
        $data['current_address'] = $row['current_address'] ?? "";
        $data['permanent_address'] = $row['permanent_address'] ?? "";
        $data['emg_contact_person'] = $row['emergency_contact_person'] ?? "";
        $data['emg_contact_no'] = $row['emergency_contact_number'] ?? "";
        $data['emg_relation'] = $row['emergency_person_relation'] ?? "";
        $data['status'] = $row['status'] ? 2 : 3;
        $student = StudentDetail::create($data);
        $course = Course::where('course_name', $row['course'])->first();
        if ($course) {
            $invoice_no = $this->generateInvoiceNo();
            $convenance = 0;
            $gst_amount = 0;
            $grand_total = $course->new_student_fees;
            $fees = $course->new_student_fees;
            $conv_fee = 0;
            // if ($country->id == "101") {
            //     $conv_fee = $course->conv_indian;
            // } else {
            //     $conv_fee = $course->conv_foreigner;
            // }
            $grand_total = $fees + $conv_fee;
            StudentCourseDetail::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'course_name' => $course->course_name,
                "invoice_no" => $invoice_no[0],
                "financial_year" => $invoice_no[1],
                'type' => 1,
                'convenience_fees' => $convenance,
                'gst_amount' => $gst_amount,
                'grand_total' => $grand_total,
                'amount' => $fees,
                'due_date' => Carbon::parse($data['latest_paid_date'])->addMonth()->format('Y-m-d'),
                'paid_date' => $data['latest_paid_date'],
                'teacher' => "1",
                'manual' => "1",
                'penalty_amount' => 0,
                'pdf_link' => 1,
                'method' => 1,
            ]);
        }
        return $student;
    }
    public function rules(): array
    {
        return [];
    }
    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }
    public function uniqueBy()
    {
        return 'Email';
    }
    public function generateInvoiceNo()
    {
        $prefix = "RZ";
        $month = date('m');

        // Determine financial year (e.g., 23-24)
        if ($month < 4) {
            $startYear = date('y', strtotime('-1 year'));
            $endYear = date('y');
        } else {
            $startYear = date('y');
            $endYear = date('y', strtotime('+1 year'));
        }

        $financialYear = $startYear . $endYear;

        // Pattern to match current financial year
        $pattern = "{$prefix}/{$financialYear}/%";

        // Get last invoice_no of current financial year
        $last = StudentCourseDetail::where('invoice_no', 'like', $pattern)
            ->orderByDesc('id') // assuming higher ID = latest
            ->first();

        if ($last) {
            // Extract last number from invoice_no
            $parts = explode('/', $last->invoice_no);
            $lastNumber = isset($parts[2]) ? intval($parts[2]) : 0;
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Pad number with leading zeroes (e.g. 0001)
        $formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        $invoiceNo = "{$prefix}/{$financialYear}/{$formattedNumber}";

        return [$invoiceNo, $financialYear];
    }
}
