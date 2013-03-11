<?php

namespace Code\AnalyzerBundle\Model;

class ClassModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $smells = array();

    /**
     * @var array
     */
    private $metrics = array();

    /**
     * @param string $name
     */
    public function __construct($name, array $smells = array(), $metrics = array())
    {
        $this->name = $name;
        $this->smells = $smells;
        $this->metrics = $metrics;
    }

    /**
     * Clone
     */
    public function __clone()
    {
        $this->smells = array();
        $this->metrics = array();
    }

    /*+
     * Return name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add smell
     *
     * @param SmellModel $smell
     * @return $this
     */
    public function addSmell(SmellModel $smell)
    {
        $this->smells[] = $smell;

        return $this;
    }

    /*+
     * Return smells
     *
     * @return object
     */
    public function getSmells()
    {
        return $this->smells;
    }

    /**
     * Is at least one smell set?
     *
     * @return boolean
     */
    public function hasSmells()
    {
        return count($this->smells) > 0;
    }

    /*+
     * Return score
     *
     * @return integer
     */
    public function getScore()
    {
        $score = 0;
        foreach ($this->smells as $smell)
        {
            $score += $smell->getScore();
        }

        return $score;
    }

    /**
     * Add metric
     *
     * @param MetricModel $metric
     * @return $this
     */
    public function addMetric(MetricModel $metric)
    {
        $this->metrics[$metric->getKey()] = $metric;

        return $this;
    }

    /**
     * Return metrics
     *
     * @return array
     */
    public function getMetrics()
    {
        return $this->metrics;
    }

    /**
     * Is at least one metric set?
     *
     * @return boolean
     */
    public function hasMetrics()
    {
        return count($this->metrics) > 0;
    }
}
