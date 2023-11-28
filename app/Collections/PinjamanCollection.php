<?php declare(strict_types=1);

namespace App\Collections;

use App\Models\Pinjaman;
use Illuminate\Database\Eloquent\Collection;

class PinjamanCollection extends Collection
{
    public function __construct(mixed $array)
    {
        $newarray = [];
        foreach($array as $row) {
            $newarray[] = $row instanceof Pinjaman ? $row : new Pinjaman((array) $row);
        }
        parent::__construct($newarray);
    }
}
