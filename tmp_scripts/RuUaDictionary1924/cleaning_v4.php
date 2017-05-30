<?php
// php cleaning_v4.php

require_once('../support/_require_once.php');

$file = file_get_contents('cleaning/v.4.txt');

$lines = explode("\n", $file);

$count = count($lines);

$resultText = '';

$sample = 25;

$n = 0;

for ($i = 0; $i < $count+1; $i++) {
    $line = $lines[$i];
    if (empty($line)) {

    } else {
        if (0 < strpos($line, (string)$sample)) {
            $line = str_replace((string)$sample, '', $line);
            $sample++;
            $n = 0;

            if (0 < strpos($line, (string)$sample)) {
                $line = str_replace((string)$sample, '', $line);
                $sample++;

                if (0 < strpos($line, (string)$sample)) {
                    $line = str_replace((string)$sample, '', $line);
                    $sample++;

                    if (0 < strpos($line, (string)$sample)) {
                        $line = str_replace((string)$sample, '', $line);
                        $sample++;

                        if (0 < strpos($line, (string)$sample)) {
                            $line = str_replace((string)$sample, '', $line);
                            $sample++;

                            if (0 < strpos($line, (string)$sample)) {
                                $line = str_replace((string)$sample, '', $line);
                                $sample++;

                                if (0 < strpos($line, (string)$sample)) {
                                    $line = str_replace((string)$sample, '', $line);
                                    $sample++;

                                    if (0 < strpos($line, (string)$sample)) {
                                        $line = str_replace((string)$sample, '', $line);
                                        $sample++;

                                        if (0 < strpos($line, (string)$sample)) {
                                            $line = str_replace((string)$sample, '', $line);
                                            $sample++;

                                            if (0 < strpos($line, (string)$sample)) {
                                                $line = str_replace((string)$sample, '', $line);
                                                $sample++;

                                                if (0 < strpos($line, (string)$sample)) {
                                                    $line = str_replace((string)$sample, '', $line);
                                                    $sample++;

                                                    if (0 < strpos($line, (string)$sample)) {
                                                        $line = str_replace((string)$sample, '', $line);
                                                        $sample++;

                                                        if (0 < strpos($line, (string)$sample)) {
                                                            $line = str_replace((string)$sample, '', $line);
                                                            $sample++;

                                                            if (0 < strpos($line, (string)$sample)) {
                                                                $line = str_replace((string)$sample, '', $line);
                                                                $sample++;

                                                                if (0 < strpos($line, (string)$sample)) {
                                                                    $line = str_replace((string)$sample, '', $line);
                                                                    $sample++;

                                                                    if (0 < strpos($line, (string)$sample)) {
                                                                        $line = str_replace((string)$sample, '', $line);
                                                                        $sample++;

                                                                        if (0 < strpos($line, (string)$sample)) {
                                                                            $line = str_replace((string)$sample, '', $line);
                                                                            $sample++;

                                                                            if (0 < strpos($line, (string)$sample)) {
                                                                                $line = str_replace((string)$sample, '', $line);
                                                                                $sample++;

                                                                                if (0 < strpos($line, (string)$sample)) {
                                                                                    $line = str_replace((string)$sample, '', $line);
                                                                                    $sample++;

                                                                                    if (0 < strpos($line, (string)$sample)) {
                                                                                        $line = str_replace((string)$sample, '', $line);
                                                                                        $sample++;

                                                                                        if (0 < strpos($line, (string)$sample)) {
                                                                                            $line = str_replace((string)$sample, '', $line);
                                                                                            $sample++;

                                                                                            if (0 < strpos($line, (string)$sample)) {
                                                                                                $line = str_replace((string)$sample, '', $line);
                                                                                                $sample++;

                                                                                                if (0 < strpos($line, (string)$sample)) {
                                                                                                    $line = str_replace((string)$sample, '', $line);
                                                                                                    $sample++;

                                                                                                    if (0 < strpos($line, (string)$sample)) {
                                                                                                        $line = str_replace((string)$sample, '', $line);
                                                                                                        $sample++;
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if (413 == $sample) {
                $sample = 418;
            }

            if (454 == $sample) {
                $sample = 471;
            }

            if (557 == $sample) {
                $sample = 589;
            }

               echo $sample. ' (' . $i . '), ';
        } else {
            $n++;
//            echo '.';
        }

        if (606 == $sample && 17260 == $i) {
            $sample = 600;
        }

        if (17000 == $i) {
            $n = 0;
        }

        if (17250 == $i) {
            $n = 0;
        }

        if (17508 == $i) {
            $n = 0;
        }

        if (17758 == $i) {
            $n = 0;
        }

//        if (250 == $n) {
//            echo $i . '/' . $sample;
//            die;
//        }

        $resultText .= $line . "\n";
    }
}

file_put_contents('cleaning/v.5.txt', $resultText);