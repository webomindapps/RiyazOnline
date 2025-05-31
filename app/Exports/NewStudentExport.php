<?php

namespace App\Exports;

use App\Models\StudentDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NewStudentExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $students;
    public function __construct($students)
    {
        $this->students = $students;
    }
    public function collection()
    {
        return $this->students;
    }
    public function map($student): array
    {
        return [
            $student->id,
            $student->name,
            $student->email,
            $student->phone,
            $student->contact_no2,
            date("d-m-Y", strtotime($student->dob)),
            $student->age,
            $student->gender == 1 ? 'Female' : 'Male',
            $student->mother_name,
            $student->father_name,
            $student->studentcourse->course_name,
            $student->current_address,
            $student->permanent_address,
            date("d-m-Y", strtotime($student->date)),
            date("d-m-Y", strtotime($student->date_joining)),
        ];
    }
    public function headings(): array
    {
        return [
            'Roll No',
            'Name',
            'Email',
            'Phone',
            'Alternate Phone',
            'Date of Birth',
            'Age',
            'Gender',
            'Mother Name',
            'Father Name',
            'Course',
            'Current Address',
            'Permanent Address',
            'Date of Register',
            'Date of Joining',
        ];
    }
}
