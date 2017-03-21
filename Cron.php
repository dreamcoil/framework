<?php

namespace Dreamcoil;

class Cron
{

    /**
     * @var array
     */
    private $jobs = [];

    /**
     * Checks if a job should be run
     *
     * @param $job
     * @param $timefields
     * @return bool
     */
    private function runable($job, $timefields)
    {
        $time = explode(" ", $job['time']);

        foreach($time as $key => $value) {
            $return[$key] = false;
            // Allow rules like "*/5" every 5 minutes
            $modulo = false;
            if(strpos($value,'*/') !== false) {
                $devision_value = explode('/', $value)[1];
                if($timefields[$key]%intval($devision_value)==0) {
                    $modulo = true;
                }
            }
            if($timefields[$key] == $value || $value == '*' || $modulo) {
                $return[$key] = true;
            }
        }

        if(in_array(false, $return)) {
            return false;
        }

        return true;
    }

    /**
     * Returns the timefield
     *
     * @param $time
     * @return array
     */
    private function getTimeFields($time)
    {
        $return[0] = date('i', $time);

        if($return[0]{0} == 0) {
            $return[0]{0} =  $return[0]{1};
            $return[0] = substr($return[0], 0, -1);
        }

        $return[1] = date('G', $time);

        $return[] = date('j', $time);

        $return[] = date('n', $time);

        $return[] = date('N', $time);

        $return[] = date('Y', $time);

        return $return;
    }

    /**
     * Run the cronjobs
     */
    public function run()
    {
        $timefields = $this->getTimeFields(time());

        foreach($this->getJobs() as $job)
        {
            if($this->runable($job, $timefields)) {
                echo exec($job['command']);
            }
        }
    }

    /**
     * Get all the jobs
     *
     * @return array
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Set all the jobs
     *
     * @param $jobs
     */
    public function setJobs($jobs)
    {
        $this->jobs = $jobs;
    }

    /**
     * Add a job to the list
     *
     * @param $job
     */
    public function addJob($job)
    {
        $this->jobs[] = $job;
    }

}
