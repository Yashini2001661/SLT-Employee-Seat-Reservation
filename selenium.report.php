<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;
use Facebook\WebDriver\WebDriverExpectedCondition;

require_once 'vendor/autoload.php';

$seleniumServerUrl = 'http://localhost:4444/wd/hub';
$reportPath = __DIR__ . '/test_report.html';


$driver = RemoteWebDriver::create($seleniumServerUrl, DesiredCapabilities::chrome());

$urls = [
    'http://127.0.0.1:8000/homeRoute',
    'http://127.0.0.1:8000/seat-booking',
    'http://127.0.0.1:8000/admin-login',
    'http://127.0.0.1:8000/admin-dashboard',
    'http://127.0.0.1:8000/attendance',
    'http://127.0.0.1:8000/forgot-password',
    'http://127.0.0.1:8000/loginRoute?',
    'http://127.0.0.1:8000/google-seat-booking',
    'http://localhost:8000/facebook-seat-booking#='
];

$report = "<html><head><title>Combined UI Test Report</title></head><body>";
$report .= "<h1 style='text-align: center; color: #333;'>Test Report for Laravel Project</h1>";
$report .= "<style>
    body {
        font-family: Arial, sans-secrif;
        margin: 0;
        padding: 20px;
        background-color: #f9f9f9;
    }
    table { 
        width: 100%; /* Use full width for better visibility */
        border-collapse: collapse; 
        margin: 20px 0; /* Add margin for separation */
    }
    th, td { 
        padding: 10px; /* Increased padding for better spacing */
        border: 1px solid #ddd; 
        text-align: left; 
        font-size: 14px; /* Slightly larger font size */
    }
    th { 
        background-color: #4CAF50; 
        color: white; 
        font-weight: bold; /* Make headers bold */
    }
    .pass { 
        background-color: #c6efce; 
        color: #006100; 
    }
    .fail { 
        background-color: #ffc7ce; 
        color: #9c0006; 
    }
    h2 {
        margin-top: 40px; /* Space before section headers */
        color: #4CAF50; /* Consistent color for headers */
    }
    h1, h2 {
    font-family:'Times New Roman', serif; /* Bolder font for main headings */
}
    

</style>";


// ... rest of your report generation code




// Table for First Script's Report
$report .= "<h2></h2>";
$report .= "<table><tr><th>URL</th><th>Title</th><th>Header/Footer Found</th><th>Consistency Check</th><th>Responsive Design</th><th>Text Content</th><th>Page Load Time</th></tr>";
foreach ($urls as $url) {
    $driver->get($url);
    $pageTitle = $driver->getTitle();
    $headerFooterCheck = $consistencyCheck = $responsiveDesign = $textContentCheck = $imageCheck = $loadTimeCheck = "<td class='fail'>Fail</td>";
    $pageSize = '';

    try {
        $driver->findElement(WebDriverBy::tagName('header'));
        $driver->findElement(WebDriverBy::tagName('footer'));
        $headerFooterCheck = "<td class='pass'>Pass</td>";
    } catch (Exception $e) {}

    try {
        $body = $driver->findElement(WebDriverBy::tagName('body'));
        $backgroundColor = $body->getCSSValue('background-color');
        $fontFamily = $body->getCSSValue('font-family');
        if ($backgroundColor && $fontFamily) {
            $consistencyCheck = "<td class='pass'>Pass</td>";
        }
    } catch (Exception $e) {}

    try {
        $driver->manage()->window()->setSize(new WebDriverDimension(768, 1024));
        usleep(500000);
        $responsiveDesign = "<td class='pass'>Pass</td>";
    } catch (Exception $e) {}

    try {
        $bodyText = $driver->findElement(WebDriverBy::tagName('body'))->getText();
        if ($bodyText) {
            $textContentCheck = "<td class='pass'>Pass</td>";
        }
    } catch (Exception $e) {}

    

    try {
        $start = microtime(true);
        $driver->navigate()->refresh();
        WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(WebDriverBy::tagName('body'));
        $loadTime = microtime(true) - $start;
        $loadTimeCheck = "<td class='pass'>" . round($loadTime, 2) . " seconds</td>";
    } catch (Exception $e) {
        $loadTimeCheck = "<td class='fail'>Load Failed</td>";
    }


    $report .= "<tr><td>" . htmlspecialchars($url) . "</td><td>" . htmlspecialchars($pageTitle) . "</td>$headerFooterCheck$consistencyCheck$responsiveDesign$textContentCheck$loadTimeCheck</tr>";
}
$report .= "</table>";

// Table for Second Script's Report
$report .= "<h2></h2>";
$report .= "<table><tr><th>URL</th><th>Title</th><th>Images and Icons</th><th>Buttons</th><th>Text Content</th><th>Page Size (WxH)</th></tr>";
foreach ($urls as $url) {
    $driver->get($url);
    $pageTitle = $driver->getTitle();
    $navCheck = $buttonCheck = $textCheck = $stateCheck = "<td class='fail'>Fail</td>";
    $pageSize = '';

    try {
        $images = $driver->findElements(WebDriverBy::tagName('img'));
        foreach ($images as $img) {
            if ($img->getAttribute('src') && $img->getAttribute('alt')) {
                $imageCheck = "<td class='pass'>Pass</td>";
            } else {
                $imageCheck = "<td class='fail'>Missing Alt Text</td>";
                break;
            }
        }
    } catch (Exception $e) {}

    try {
        $buttons = $driver->findElements(WebDriverBy::cssSelector('button, .btn'));
        foreach ($buttons as $button) {
            if ($button->isDisplayed() && $button->isEnabled()) {
                $buttonCheck = "<td class='pass'>Pass</td>";
            }
        }
    } catch (Exception $e) {}

    try {
        $bodyText = $driver->findElement(WebDriverBy::tagName('body'))->getText();
        if ($bodyText) {
            $textCheck = "<td class='pass'>Pass</td>";
        }
    } catch (Exception $e) {}

    

    try {
        $size = $driver->manage()->window()->getSize();
        $pageSize = $size->getWidth() . 'x' . $size->getHeight();
    } catch (Exception $e) {
        $pageSize = 'Unavailable';
    }

    $report .= "<tr><td>" . htmlspecialchars($url) . "</td><td>" . htmlspecialchars($pageTitle) . "</td>$imageCheck$buttonCheck$textCheck<td>$pageSize</td></tr>";
}

$report .= "</table></body></html>";

// Save the combined report
file_put_contents($reportPath, $report);
echo "Combined UI test report generated: " . realpath($reportPath) . "\n";

$driver->quit();
?>