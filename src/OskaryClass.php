<?php

namespace Mforbakova\Mojeoskary2;

class OskaryClass
{
    public const GENDER_MAN = 'man';
    public const GENDER_WOMAN = 'woman';

    public function __construct(
        private string $gender,
        private int $id,
        private int $year,
        private int $age,
        private string $name,
        private string $movie,
    ) {
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMovie()
    {
        return $this->movie;
    }
}
