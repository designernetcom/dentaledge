<?php
$xmlDoc = new DOMDocument();
$xmlDoc->load("sitemap.xml");

$x = $xmlDoc->getElementsByTagName('url');

// Get the q parameter from URL
$q = $_GET["q"];

// Lookup all links from the xml file if length of q > 0
if (strlen($q) > 0) {
    $hint = "";
    for ($i = 0; $i < ($x->length); $i++) {
        $loc = $x->item($i)->getElementsByTagName('loc')->item(0)->nodeValue;
        $title = basename(parse_url($loc, PHP_URL_PATH), ".html"); // Get the basename without extension
        $title = str_replace("-", " ", $title); // Replace hyphens with spaces for better readability
        $title = ucwords($title); // Capitalize each word
        
        // Find a link matching the search text
        if (stristr($title, $q)) {
            if ($hint == "") {
                $hint = "<a href='" . $loc . "' target='_self'>" . $title . "</a>";
            } else {
                $hint = $hint . "<br /><a href='" . $loc . "' target='_self'>" . $title . "</a>";
            }
        }
    }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint == "") {
    $response = "no suggestion";
} else {
    $response = $hint;
}

// Output the response
echo $response;
?>
