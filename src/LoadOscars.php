<?php

namespace Mforbakova\Mojeoskary2;

use Exception;
use Webmozart\Assert\Assert;

class LoadOscars
{

    private array $itemsPerYear;
    private array $itemsPerMovie;


    public function __construct()
    {
    }


    public function loadOscars(string $file, string $gender)
    {

        $row = 0;

        if (($handle = fopen($file, 'r')) === FALSE) {
            throw new Exception('Cannot open file');
        }

        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            if ($data[0] === null) {
                continue;
            }

            if ($row++ === 0) {
                continue;
            }

            $id = trim($data[0]);
            Assert::digits($id, 'ID contains unexcepted chars');

            $year = trim($data[1]);
            Assert::digits($year, 'Year contains unexcepted chars');

            $age = trim($data[2]);
            Assert::digits($age, 'Age contains unexcepted chars');

            $name = trim($data[3]);
            Assert::digits($age, 'Age contains unexcepted chars');

            $movie = trim($data[4]);
            Assert::string($movie, 'Movie contains unexcepted chars');

            $oscarItem = new OskaryClass($gender, $id, $year, $age, $name, $movie);

            $this->itemsPerYear[$year][$gender] = $oscarItem;
            $this->itemsPerMovie[$movie][$gender] = $oscarItem;
        }
        ksort($this->itemsPerMovie, SORT_STRING);
        fclose($handle);
    }


    public function getItemsPerYear()
    {
        return $this->itemsPerYear;
    }


    public function getItemsPerMovie()
    {
        return array_filter($this->itemsPerMovie, function ($items) {
            if (isset($items[OskaryClass::GENDER_MAN]) && isset($items[OskaryClass::GENDER_WOMAN])) {
                return true;
            }

            return false;
        });
    }
}
