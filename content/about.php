<?php
// Fallback redirect to /en/about
// This file exists for backwards compatibility
// The actual content lives in en/about.php
header('Location: /en/about', true, 302);
exit;
?>
