<?php
    namespace App\Imports;
    use Illuminate\Support\Collection;
    use Maatwebsite\Excel\Concerns\ToCollection;

    class ImportModel implements ToCollection
    {
       public function collection(Collection $rows)
       {
       }
    }