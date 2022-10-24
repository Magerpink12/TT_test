<?php

ini_set('memory_limit', -1);

require('../include/configuration/init.php');
require('fpdf/fpdf.php');
class PDF extends FPDF
{
    public $faculty = '';
    public $subtitle = '';
    public $semester = '';
    public $level = '';
    public $department = '';

    function Header()
    {
        // Select Arial bold 15
        $this->SetFont('Times', 'B', 18);
        $this->SetTextColor(0, 0, 155);
        $this->SetDrawColor(0, 0, 155);
        $this->Cell(0, 7, 'YOBE STATE UNIVERSITY', 0, 1, 'C');
        $this->SetTextColor(0);
        $this->SetFont('', '', 13);
        $this->Cell(0, 5, 'Km 7, Gujba Road, P. M. B. 1144, Damaturu', 0, 1, 'C');
        $this->Cell(0, 5, '', 'B', 1, 'C');
        $this->SetFont('', 'B', 10);
        $this->Cell(0, 5, 'FACULTY OF ' . strtoupper($this->faculty), 0, 1, 'C');
        $this->Cell(0, 5, 'PROVISIONAL LECTURE TIME TABLE FOR ' . strtoupper($this->department) . ' ' . strtoupper($this->level) . ' ' . strtoupper($this->semester) . ' SEMESTER 2021/2022 ACADEMIC SESSION', 0, 1, 'C');
        $this->Image('logo.png', 10, 0, 30);
        // Line break 
        $this->Ln(2);
    }
    function Footer()
    {
        // Go to 0.9 cm from bottom
        $this->SetY(-9);
        $this->SetFont('Arial', 'I', 8);
        // Print centered page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}



if (isset($_POST['print'])) {

    $department = $_POST['department'];
    $level = $_POST['level'];
    $semester = $_POST['semester'];
    $faculty = $_POST['faculty'];


    $period = new Period();
    $all = array();


    if ($level == "All") {
        $periods = $period->find_by_query("SELECT * FROM period WHERE department='{$department}' AND semester='{$semester}'");

        $gst = Subscourse::find_subs_by_dept_and_level($department, '', $semester, 'gst');
        $other_courses = Subscourse::find_subs_by_dept_and_level($department, '', $semester, 'other_courses');

        $gst_periods = Period::find_my_gst_periods('', $semester, $gst);
        $other_courses_periodss = Period::find_my_subs_periods('', $semester, $other_courses);

        foreach ($periods as $period) {

            $week = json_decode($period->periods);
            array_push($all, $week);
        }

        foreach ($gst_periods as $gst_period) {

            array_push($all, $gst_period);
        }

        // echo "<pre>";
        // print_r($all);
        // echo "</pre>";
        foreach ($other_courses_periodss as $other_courses_periods) {
            foreach ($other_courses_periods as $other) {

                array_push($all, $other);
                // echo "<pre>";
                // print_r($all);
                // echo "</pre>";
            }
        }
    } else {
        $periods = $period->find_by_query("SELECT * from period WHERE department='{$department}' AND level='{$level}' AND semester='{$semester}'"); //level MANUAL
        $periods = array_shift($periods);
        $gst = Subscourse::find_subs_by_dept_and_level($department, $level, $semester, 'gst');
        $other_courses = Subscourse::find_subs_by_dept_and_level($department, $level, $semester, 'other_courses');

        $gst_periods = Period::find_my_gst_periods($level, $semester, $gst);
        $other_courses_periods = Period::find_my_subs_periods($level, $semester, $other_courses);

        $week = json_decode($periods->periods);
        // echo "<pre>";
        // print_r($week);
        // echo "</pre>";
        array_push($all, $week);
        array_push($all, $gst_periods);

        foreach ($other_courses_periods as $other) {
            array_push($all, $other);
            // echo "<pre>";
            // print_r($all);
            // echo "</pre>";
        }
    }







    $pdf = new PDF();
    $pdf->department = $department;
    $pdf->faculty = $faculty;
    $pdf->level = $level . " Level";
    $pdf->semester = $semester;


    $days_array = array('MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY');

    function weekdays($name)
    {
        switch ($name) {
            case 'MONDAY':
                $name = "MON";
                break;
            case 'TUESDAY':
                $name = "TUE.";
                break;
            case 'WEDNESDAY':
                $name = "WED.";
                break;
            case 'THURSDAY':
                $name = "THUR.";
                break;
            case 'FRIDAY':
                $name = "FRI.";
                break;
            case 'SATURDAY':
                $name = "SAT.";
                break;
        }

        return $name;
    }


    $pdf->AliasNbPages();
    $pdf->AddPage('L', 'A4');
    $pdf->SetFont('', '', 10);
    $pdf->SetFillColor(240, 240, 255);

    $pdf->SetFont('', 'B', 10);
    $pdf->Cell(20, 5, 'DAYS', 1, 0, 'C', true);
    $pdf->Cell(0, 5, 'TIME', 1, 1, 'C', true);

    for ($i = 0; $i < count($days_array); $i++) {

        $pdf->SetFont('', 'B', 10);
        $pdf->Cell(20, 5, weekdays($days_array[$i]), 1, 0, 'C', true);
        $pdf->Cell(34, 5, '8-9', 1, 0, 'C', true);
        $pdf->Cell(34, 5, '9-10', 1, 0, 'C', true);
        $pdf->Cell(34, 5, '10-11', 1, 0, 'C', true);
        $pdf->Cell(34, 5, '11-12', 1, 0, 'C', true);
        $pdf->Cell(34, 5, '12-1', 1, 0, 'C', true);
        $pdf->Cell(19, 5, 'BREAK', 1, 0, 'C', true);
        $pdf->Cell(34, 5, '2-3', 1, 0, 'C', true);
        $pdf->Cell(34, 5, '3-4', 1, 1, 'C', true);
        $pdf->SetFont('', '', 10);

        foreach ($all as $week) {
            foreach ($week as $day => $value) {
                foreach ($week->$day as $co => $value2) {
                    $start_array = explode(':', $week->$day->$co->start);
                    $end_array = explode(':', $week->$day->$co->end);

                    $venue = $week->$day->$co->venue;
                    $start = intval($start_array[0]);
                    $end = intval($end_array[0]);

                    if ($day == $days_array[$i]) {

                        $pdf->Cell(20, 5, '', 'LR', 0, 'C', true);

                        if ($start == 8) {
                            if ($end == 10) {

                                $pdf->Cell(68, 5, "$co ($venue)", 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 1, 'C');
                                goto endd;
                            } else {

                                $pdf->Cell(34, 5, "$co ($venue)", 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 1, 'C');
                                goto endd;
                            }
                        } else {
                            $pdf->Cell(34, 5, '', 1, 0, 'C');
                        }

                        if ($start == 9) {
                            if ($end == 11) {

                                $pdf->Cell(68, 5, "$co ($venue)", 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 1, 'C');
                                goto endd;
                            } else {

                                $pdf->Cell(34, 5, "$co ($venue)", 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 1, 'C');
                                goto endd;
                            }
                        } else {
                            $pdf->Cell(34, 5, '', 1, 0, 'C');
                        }

                        if ($start == 10) {
                            if ($end == 12) {

                                $pdf->Cell(68, 5, "$co ($venue)", 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 1, 'C');
                                goto endd;
                            } else {

                                $pdf->Cell(34, 5, "$co ($venue)", 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 1, 'C');
                                goto endd;
                            }
                        } else {
                            $pdf->Cell(34, 5, '', 1, 0, 'C');
                        }

                        if ($start == 11) {
                            if ($end == 13) {

                                $pdf->Cell(68, 5, "$co ($venue)", 1, 0, 'C');
                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 1, 'C');
                                goto endd;
                            } else {

                                $pdf->Cell(34, 5, "$co ($venue)", 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 1, 'C');
                                goto endd;
                            }
                        } else {
                            $pdf->Cell(34, 5, '', 1, 0, 'C');
                        }


                        if ($start == 12) {
                            if ($end == 14) {
                            } else {

                                $pdf->Cell(34, 5, "$co ($venue)", 1, 0, 'C');
                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(34, 5, '', 1, 0, 'C');
                                $pdf->Cell(34, 5, '', 1, 1, 'C');
                                goto endd;
                            }
                        } else {
                            $pdf->Cell(34, 5, '', 1, 0, 'C');
                        }




                        if ($start == 14) {
                            if ($end == 16) {

                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(68, 5, "$co ($venue)", 1, 1, 'C');
                                goto endd;
                            } else {

                                $pdf->Cell(19, 5, '', 'LR', 0, 'C', true);
                                $pdf->Cell(34, 5, '', 1, 1, 'C');
                                $pdf->Cell(34, 5, "$co ($venue)", 1, 1, 'C');
                                goto endd;
                            }
                        } else {
                            $pdf->Cell(34, 5, '', 1, 1, 'C');
                        }

                        endd:
                    }
                }
            }
        }

    }
    $pdf->Ln(5);
    $pdf->MultiCell(0, 5, 'NOTE: NO lecturer should occupy a venue not assigned for his course. Where its necessary to change venue, it must be confirmed that the intended venue is vacant for that period.', 0, 1, 'C', true);
    $pdf->MultiCell(0, 5, "Hassan Abdulsalam \n Examination and Time Table Coordinator \n Faculty of $faculty", 'B', 0, 'R', true);
    
    $pdf->Output();
}
