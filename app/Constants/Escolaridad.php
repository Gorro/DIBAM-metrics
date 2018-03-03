<?php
/**
 * Created by PhpStorm.
 * User: aastudim
 * Date: 03-03-2018
 * Time: 12:37
 */

namespace  App\Constants;

abstract class Escolaridad
{
    const BASICA_COMPLETA = 1;
    const BASICA_INCOMPLETA = 2;
    const MEDIA_SECUNDARIA_COMPLETA = 3;
    const MEDIA_SECUNDARIA_INCOMPLETA = 4;
    const TECNICA_PROFESIONAL_COMPLETA = 5;
    const TECNICA_PROFESIONAL_INCOMPLETA = 6;
    const UNIVERSITARIA_COMPLETA = 7;
    const UNIVERSITARIA_INCOMPLETA = 8;
    const POSTGRADO = 9;
    const OTROS = 0;

    const NIVEL_ESCOLARIDAD = [
        self::BASICA_COMPLETA => 'Básica completa',
        self::BASICA_INCOMPLETA => 'Básica',
        self::MEDIA_SECUNDARIA_COMPLETA => 'Media/Secundaria completa',
        self::MEDIA_SECUNDARIA_INCOMPLETA => 'Media/Secundaria incompleta',
        self::TECNICA_PROFESIONAL_COMPLETA => 'Técnica/Técnica Profesional completa',
        self::TECNICA_PROFESIONAL_INCOMPLETA => 'Técnica/Técnica Profesional incompleta',
        self::UNIVERSITARIA_COMPLETA => 'Universitaria completa',
        self::UNIVERSITARIA_INCOMPLETA => 'Universitaria incompleta',
        self::POSTGRADO => 'Postgrado',
        self::OTROS => 'Otros',
    ];
}
