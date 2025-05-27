<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CourseExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $courses;
    public function collection()
    {
        return $this->courses = Course::orderBy('priority', 'DESC')->get();
    }
    public function map($courses): array
    {
        return [
            $courses->id,
            $courses->course_name,
            $courses->description,
            $courses->new_student_fees,
            $courses->old_student_fees,
            $courses->status == 1 ? 'Active' : 'Not active',
            $courses->priority,
        ];
    }
    public function headings(): array
    {
        return [
            'Course Id',
            'Course Name',
            'Description',
            'New Student Fees',
            'Old Student Fees',
            'Status',
            'Priority',
        ];
    }
}
