<?php
// generate a random hex color
function generateRandomHex(){
    return str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}


// generate a gradient of hex codes between two colors
function generateGradient($startColor, $endColor, $steps) {
    $startRGB = sscanf($startColor, "%02x%02x%02x");
    $endRGB = sscanf($endColor, "%02x%02x%02x");
    
    $gradient = array();

    for ($i = 0; $i <= $steps; $i++) {
        $r = $startRGB[0] + ($endRGB[0] - $startRGB[0]) * $i / $steps;
        $g = $startRGB[1] + ($endRGB[1] - $startRGB[1]) * $i / $steps;
        $b = $startRGB[2] + ($endRGB[2] - $startRGB[2]) * $i / $steps;
        $gradient[] = sprintf("#%02x%02x%02x", $r, $g, $b);
    }
    return $gradient;
}

//maybe make this a button? blade templates?
$numGradients =  100;

//each array is a hex code for a color, array[0] - startRGB, arrray[1] - endRGB
for ($i = 0; $i < $numGradients; $i++){
    $startColor = generateRandomHex();
    $endColor = generateRandomHex();
    $gradients[] = array($startColor,$endColor);
}

/*
$gradients = array(
    array("df1f00", "00ff00"),
    array("0000ff", "ffff00"),
    array("000000", "ff00ff"),
    array("bdbdbd", "15bb84"),
    array("ffffff", "000000"),
    array("0c000c", "3f003f"),
);
*/


$steps = 20; // Number of steps in the gradient


//generate html
$htmlContent = '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width", initial-scale=1.0">
<title>color</title>
<style>
body { background-color: #070d0d; color: #232323; }
h2 { color: #fff }
.gradient-container { display: flex; flex-direction: column; }
.gradient-row { display: flex; flex-direction: row; }
.gradient-box { width: 80px; height: 80px; margin: 2px; }
</style>
</head>
<body>';

foreach ($gradients as $gradientSet) {
    $startColor = $gradientSet[0];
    $endColor = $gradientSet[1];
    $gradient = generateGradient($startColor, $endColor, $steps);
    $htmlContent .= '<div class="gradient-container">';
    $htmlContent .= '<h2>'.$startColor.'-'.$endColor.'</h2>';
    $htmlContent .= generateGradientHTML($gradient);
    $htmlContent .= '</div>';           
}

$htmlContent .= '</body></html>';

function generateGradientHTML($gradient){
    $html = '<div class="gradient-row">';
    foreach($gradient as $color) {
        $html .= 
              '<div class="gradient-box" style="background-color:'
              .$color.';">'.$color.'</div>';
    }
    $html .= '</div>';
    return $html;
}

//write html contents 
file_put_contents('index.html',$htmlContent);
//print to terminal
//echo $htmlContent

?>
