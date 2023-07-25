<?php

namespace Maris\Symfony\OSRM\Model;

/***
 * Модель матрицы оптимизации маршрута
 */
class Matrix
{
    /**
     * Массив Waypoint объектов, описывающих все назначения по порядку
     * @var array
     */
    protected array $destinations;

    /**
     * Массив Waypoint объектов, описывающих все источники по порядку
     * @var array
     */
    protected array $sources;

    /**
     * Массив массивов, в котором хранится матрица в порядке следования строк.
     * durations[i][j] указывает время прохождения от i-й путевой точки до j-й путевой точки.
     * Значения указаны в секундах.
     * @var array
     */
    protected array $durations;
}