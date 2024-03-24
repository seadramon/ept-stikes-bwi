<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

use App\Services\QuestionService;

class QuestionsImport implements ToModel, WithStartRow
{
    protected $part_id;

    public function __construct($part_id)
    {
        $this->part_id = $part_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $q = new QuestionService;
        $urutan = $q->getNextUrutan($this->part_id);

        return new Question([
            'part_id' => $this->part_id,
            'question'     => $row[1],
            'choice_a'    => $row[2], 
            'choice_b'    => $row[3], 
            'choice_c'    => $row[4], 
            'choice_d'    => $row[5], 
            'answer'    => $row[6],
            'urutan' => $urutan
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
